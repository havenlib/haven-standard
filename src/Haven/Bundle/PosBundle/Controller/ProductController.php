<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PosBundle\Controller;

// Symfony includes
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

//// Haven includes
//use Haven\Bundle\WebBundle\Entity\ProductTranslation as EntityTranslation;

class ProductController extends ContainerAware {

    /**
     * @Route("/product")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $entities = $this->container->get("haven_pos.product.read_handler")->getAllPublished();
        return array("entities" => $entities);
    }

    /**
     * @Route("/admin/rank/product/{id}")
     * @Method("POST")
     * @Template
     */
    public function rankAction($id) {
        $entity = $this->container->get("haven_pos.product.read_handler")->get($id);
        $form_data = $this->container->get("request")->get('form');
        $new_rank = (int) $form_data['rank'];

        if (is_int($new_rank) && $new_rank) {
            $this->container->get("haven_pos.product.persistence_handler")->rank($entity, $new_rank);
            $this->container->get("session")->getFlashBag()->add("success", "ranking.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('rank', "list", $this->container->get("request")->get("_route"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "ranking.error");
        return new RedirectResponse($this->container->get('router')->generate(str_replace('rank', "list", $this->container->get("request")->get("_route"))));
    }

    /**
     * @Route("/admin/show/product/{id}", defaults={"show" = "afficher"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("haven_pos.product.read_handler")->get($id);
        $delete_form = $this->container->get("haven_pos.product.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity,
            "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/list/product")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("haven_pos.product.read_handler")->getAll();
        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("haven_pos.product.form_handler")->createDeleteForm($entity->getId())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
        );
    }

    /**
     * @Route("/product/{slug}")
     * @Method("GET")
     * @Template()
     */
    public function displayAction($slug) {
        $locale = $this->container->get("request")->get("_locale");

        $entity = $this->container->get("haven_pos.product.read_handler")->getByLocalizedSlug($slug, $locale);

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
     * @Route("/admin/create/product")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("haven_pos.product.form_handler")->createNewForm();
        return array(
            'entity' => $edit_form->getData()
            , "edit_form" => $edit_form->createView()
        );
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/admin/create/product")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("haven_pos.product.form_handler")->createNewForm();

        $request = $this->container->get("Request");

        $edit_form->bind($request);

        if ($edit_form->isValid()) {
            $this->container->get("haven_pos.product.persistence_handler")->save($edit_form->getData());

            return new RedirectResponse($this->container->get('router')->generate(str_replace('add', "list", $this->container->get("request")->get("_route"))));
        }
        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $edit_form->getData()
            , 'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/edit/product/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
        $entity = $this->container->get('haven_pos.product.read_handler')->get($id);
        $edit_form = $this->container->get("haven_pos.product.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_pos.product.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/edit/product/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('haven_pos.product.read_handler')->get($id);
        $edit_form = $this->container->get("haven_pos.product.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_pos.product.form_handler")->createDeleteForm($entity->getId());

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("title"))
                ->getRequest();

        $edit_form->bind($request);


        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("haven_pos.product.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "update.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('update', "list", $this->container->get("request")->get("_route"))));
        } else {
            if ($edit_form->get('template')->isClicked()) {
                $edit_form = $this->container->get("haven_pos.product.form_handler")->createNewForm($edit_form->getData());
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
     * Set a product entity state to inactive.
     *
     * @Route("/product/{id}/state", name="HavenPosBundle_ProductToggleState")
     * @Method("GET")
     */
    public function toggleStateAction($id) {
        $em = $this->container->get('doctrine')->getEntityManager();
        $entity = $em->find('HavenPosBundle:Product', $id);
        if (!$entity) {
            throw new NotFoundHttpException("Product non trouvé");
        }
        $entity->setStatus(!$entity->getStatus());
        $em->persist($entity);
        $em->flush();

        return new RedirectResponse($this->container->get("request")->headers->get('referer'));
    }

    /**
     * @Route("/admin/delete/product")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("haven_pos.product.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route")), array(
                    'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

//    /**
//     * @Route("/product/{slug}")
//     * @Method("GET")
//     * @Template
//     */
//    public function showFromSlugAction(EntityTranslation $entityTranslation) {
//        $locale = $this->container->get("request")->get("_locale");
//        if ($entityTranslation->getTransLang()->getSymbol() != \Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale) && $entityTranslation->getParent()->getTranslationByLang(\Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale))) {
//            $slug = $entityTranslation->getParent()->getTranslationByLang(\Haven\Bundle\CoreBundle\Lib\Locale::getPrimaryLanguage($locale))->getSlug();
//            return new RedirectResponse($this->container->get('router')->generate($route = $this->ROUTE_PREFIX . '_product_showfromslug', array("slug" => $slug)));
//        }
//        $entity = $entityTranslation->getParent();
//
//        if (!$entity) {
//            throw new NotFoundHttpException('entity.not.found');
//        }
//
//        $delete_form = $this->container->get("haven_pos.product.form_handler")->createDeleteForm($entity->getId());
//
//        $template = str_replace(":showFromSlug.html.twig", ":show.html.twig", $this->container->get("request")->get('_template'));
//
//        $params = array(
//            "entity" => $entity,
//            'delete_form' => $delete_form->createView()
//        );
//
//        return new Response($this->container->get('templating')->render($template, $params));
//    }

    public function listWidgetAction($template = null, $maximum = null) {
        $repo = $this->container->get('doctrine')->getRepository("HavenPosBundle:Product");
        $entities = $repo->findLastCreatedOnline($maximum);


        return new Response($this->container->get('templating')->render($template ? $template : 'HavenPosBundle:Product:list_widget.html.twig', array('entities' => $entities)));
    }

//    protected function generateI18nRoute($route, $parameters = array(), $translate = array(), $lang = null, $absolute = false) {
//        foreach ($translate as $word) {
//            $parameters[$word] = $this->container->get('translator')->trans($word, array(), "routes", $lang);
//        }
//        return $this->container->get('router')->generate($route, $parameters, $absolute);
//    }

}
