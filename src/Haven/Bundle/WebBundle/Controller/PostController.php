<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\WebBundle\Controller;

// Symfony includes
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// Haven includes
use Haven\Bundle\WebBundle\Entity\PostTranslation as EntityTranslation;

class PostController extends ContainerAware {

    /**
     * Deprecated. To remove when no more used
     */
    protected $ROUTE_PREFIX = "haven_post";

    /**
     * @Route("/post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $entities = $this->container->get("haven_web.post.read_handler")->getAllPublished();
        return array("entities" => $entities);
    }

    /**
     * @Route("/admin/rank/post/{id}")
     * @Method("POST")
     * @Template
     */
    public function rankAction($id) {
        $entity = $this->container->get("haven_web.post.read_handler")->get($id);
        $form_data = $this->container->get("request")->get('form');
        $new_rank = (int) $form_data['rank'];

        if (is_int($new_rank) && $new_rank) {
            $this->container->get("haven_web.post.persistence_handler")->rank($entity, $new_rank);
            $this->container->get("session")->getFlashBag()->add("success", "ranking.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('rank', "list", $this->container->get("request")->get("_route"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "ranking.error");
        return new RedirectResponse($this->container->get('router')->generate(str_replace('rank', "list", $this->container->get("request")->get("_route"))));
    }

    /**
     * @Route("/admin/show/post/{id}", defaults={"show" = "afficher"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("haven_web.post.read_handler")->get($id);
        $delete_form = $this->container->get("haven_web.post.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity,
            "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/list/post")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("haven_web.post.read_handler")->getAllOrderedByRank();
        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("haven_web.post.form_handler")->createDeleteForm($entity->getId())->createView();
            $rank_forms[$entity->getId()] = $this->container->get("haven_web.post.form_handler")->createRankForm($entity->getId(), $entity->getRank())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
            , 'rank_forms' => isset($rank_forms) && is_array($rank_forms) ? $rank_forms : array()
        );
    }

    /**
     * @Route("/post/{slug}")
     * @Method("GET")
     * @Template()
     */
    public function displayAction($slug) {
        $locale = $this->container->get("request")->get("_locale");

        $entity = $this->container->get("haven_web.post.read_handler")->getByLocalizedSlug($slug, $locale);

        if (!$entity) {
            throw new NotFoundHttpException('entity.not.found');
        }


        $delete_form = $this->container->get("page.form_handler")->createDeleteForm($entity->getId());

        $template = str_replace(":displayFromSlug.html.twig", ":display.html.twig", $this->container->get("request")->get('_template'));

        $params = array(
            "entity" => $entity,
            'delete_form' => $delete_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/create/post")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("haven_web.post.form_handler")->createNewForm();
        return array(
            'entity' => $edit_form->getData()
            , "edit_form" => $edit_form->createView()
        );
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/admin/create/post")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("haven_web.post.form_handler")->createNewForm();

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("Request"))
                ->slug(array("title"))
                ->getRequest();

        $edit_form->bind($request);

        if (/* $edit_form->get('save')->isClicked() && */ $edit_form->isValid()) {
            $this->container->get("haven_web.post.persistence_handler")->save($edit_form->getData(), true);

            return new RedirectResponse($this->container->get('router')->generate(str_replace('add', "list", $this->container->get("request")->get("_route"))));
        }
//        else {
//            if ($edit_form->get('template')->isClicked()) {
//                $edit_form = $this->container->get("haven_web.post.form_handler")->createNewForm($edit_form->getData());
//            } else {
//                $this->container->get("session")->getFlashBag()->add("error", "create.error");
//            }
//        }


        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $edit_form->getData()
            , 'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/edit/post/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
        $entity = $this->container->get('haven_web.post.read_handler')->get($id);
        $edit_form = $this->container->get("haven_web.post.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_web.post.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/edit/post/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('haven_web.post.read_handler')->get($id);
        $edit_form = $this->container->get("haven_web.post.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_web.post.form_handler")->createDeleteForm($entity->getId());

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("title"))
                ->getRequest();

        $edit_form->bind($request);


        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("haven_web.post.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "update.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('update', "list", $this->container->get("request")->get("_route"))));
        } else {
            if ($edit_form->get('template')->isClicked()) {
                $edit_form = $this->container->get("haven_web.post.form_handler")->createNewForm($edit_form->getData());
            } else {
                $this->container->get("session")->getFlashBag()->add("error", "create.error");
            }
        }

        $template = str_replace(":update.html.twig", ":edit.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * Set a post entity state to inactive.
     *
     * @Route("/post/{id}/state", name="HavenWebBundle_PostToggleState")
     * @Method("GET")
     */
    public function toggleStateAction($id) {
        $em = $this->container->get('doctrine')->getEntityManager();
        $entity = $em->find('HavenWebBundle:Post', $id);
        if (!$entity) {
            throw new NotFoundHttpException("Post non trouvé");
        }
        $entity->setStatus(!$entity->getStatus());
        $em->persist($entity);
        $em->flush();

        return new RedirectResponse($this->container->get("request")->headers->get('referer'));
    }

    /**
     * @Route("/admin/delete/post")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("haven_web.post.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route")), array(
                    'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    /**
     * @Route("/admin/search/post")
     * @Method("GET")
     * @Template
     */
    public function searchAction() {
        $form = $this->container->get("haven_web.post.form_handler")->createSearchForm();

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/admin/search/post")
     * @Method("POST")
     * @Template
     */
    public function performSearchAction() {
        $form = $this->container->get("haven_web.post.form_handler")->createSearchForm();
        $form->bind($request = $this->container->get("request"));

        if ($form->isValid()) {
            $entities = $this->container->get("haven_web.post.read_handler")->search($form->getData());
        } else {
            $this->container->get("session")->getFlashBag()->add("error", "create.error");
        }

        $template = str_replace(":performSearch.html.twig", ":search.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entities' => isset($entities) ? $entities : null,
            'form' => $form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/post/{slug}")
     * @Method("GET")
     * @Template
     */
    public function showFromSlugAction(EntityTranslation $entityTranslation) {
        $locale = $this->container->get("request")->get("_locale");
        if ($entityTranslation->getTransLang()->getSymbol() != \Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale) && $entityTranslation->getParent()->getTranslationByLang(\Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale))) {
            $slug = $entityTranslation->getParent()->getTranslationByLang(\Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale))->getSlug();
            return new RedirectResponse($this->container->get('router')->generate($route = $this->ROUTE_PREFIX . '_post_showfromslug', array("slug" => $slug)));
        }
        $entity = $entityTranslation->getParent();

        if (!$entity) {
            throw new NotFoundHttpException('entity.not.found');
        }

        $delete_form = $this->container->get("haven_web.post.form_handler")->createDeleteForm($entity->getId());

        $template = str_replace(":showFromSlug.html.twig", ":show.html.twig", $this->container->get("request")->get('_template'));

        $params = array(
            "entity" => $entity,
            'delete_form' => $delete_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    public function listWidgetAction($template = null, $maximum = null) {
        $repo = $this->container->get('doctrine')->getRepository("HavenWebBundle:Post");
        $entities = $repo->findLastCreatedOnline($maximum);


        return new Response($this->container->get('templating')->render($template ? $template : 'HavenWebBundle:Post:list_widget.html.twig', array('entities' => $entities)));
    }

}
