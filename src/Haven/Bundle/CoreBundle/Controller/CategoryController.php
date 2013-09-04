<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\CoreBundle\Controller;

// Symfony includes
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CategoryController extends ContainerAware {

    /**
     * @Route("/category")
     * 
     * @Method("GET")
     * @Template()
     */
    public function indexAction($discriminator) {
        if (!$this->container->has($discriminator . ".read_handler"))
            throw new \Exception($discriminator . ".read_handler doesn't exist or isn't setted in service.yml");

        $entities = $this->container->get($discriminator . ".read_handler")->getAll();

        return array("entities" => $entities);
    }

    /**
     * Finds and all persona for admin.
     *
     * @Route("admin/list/category")
     * @Method("GET")
     * @Template()
     */
    public function listAction($discriminator) {
        $entities = $this->container->get($discriminator . ".read_handler")->getAll();

        return array("entities" => $entities);
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/admin/show/category/{id}")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $discriminator) {
        $entity = $this->container->get($discriminator . ".read_handler")->get($id);
        $delete_form = $this->container->get($discriminator . ".form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity
            , "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/create/category")
     * 
     * @Method("GET")
     * @Template
     */
    public function createAction($discriminator) {
        $edit_form = $this->container->get($discriminator . ".form_handler")->createNewForm();

        return array("edit_form" => $edit_form->createView());
    }

    /**
     * Creates a new persona entity.
     *
     * @Route("/admin/create/category")
     * 
     * @Method("POST")
     * @Template
     */
    public function addAction($discriminator) {

        $edit_form = $this->container->get($discriminator . ".form_handler")->createNewForm();

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("name"))
                ->getRequest();

        $edit_form->bind($request);

        if ($edit_form->isValid()) {
            $this->container->get($discriminator . ".persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate('haven_core_' . $discriminator . '_list', array('suffix' => $this->container->get('translator')->trans($discriminator, array(), "routes")
                        , 'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":create.html.twig", ":new.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/edit/category/{id}")
     * 
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id, $discriminator) {
        $entity = $this->container->get($discriminator . ".read_handler")->get($id);
        $delete_form = $this->container->get($discriminator . ".form_handler")->createDeleteForm($id);
        $edit_form = $this->container->get($discriminator . ".form_handler")->createEditForm($id);

        return array(
            'edit_form' => $edit_form->createView()
            , 'entity' => $entity
            , "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/edit/category/{id}")
     * 
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id, $discriminator) {
        $entity = $this->container->get($discriminator . ".read_handler")->get($id);
        $delete_form = $this->container->get($discriminator . ".form_handler")->createDeleteForm($id);
        $edit_form = $this->container->get($discriminator . ".form_handler")->createEditForm($id);

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("name"))
                ->getRequest();

        $edit_form->bind($request);
        if ($edit_form->isValid()) {
            $this->container->get($discriminator . ".persistence_handler")->save($edit_form->getData());

            $this->container->get("session")->getFlashBag()->add("success", "update.success");
            return new RedirectResponse($this->container->get('router')->generate('haven_core_' . $discriminator . '_list', array('suffix' => $this->container->get('translator')->trans($discriminator, array(), "routes")
                        , 'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "update.error");

        $template = str_replace(":update.html.twig", ":edit.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

}

?>
