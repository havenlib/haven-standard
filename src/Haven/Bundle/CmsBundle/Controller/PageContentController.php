<?php

namespace Haven\Bundle\CmsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PageContentController extends ContainerAware {

    /**
     * Finds and all persona for admin.
     *
     * @Route("admin/{list}/page_content")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("page_content.read_handler")->getAll();

        return array("entities" => $entities);
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/admin/{show}/page_content/{id}")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("page_content.read_handler")->get($id);
        $delete_form = $this->container->get("page_content.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity
            , "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/{create}/page_content/{page_id}")
     * @Method("GET")
     * @Template
     */
    public function createAction($page_id) {
        $page = $this->container->get("page.read_handler")->get($page_id);
        $edit_form = $this->container->get("page_content.form_handler")->createNewFormForPage($page);
        
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * @Route("/admin/{create}/page_content/{page_id}")
     * @Method("POST")
     * @Template
     */
    public function addAction($page_id) {
        $page = $this->container->get("page.read_handler")->get($page_id);
        $edit_form = $this->container->get("page_content.form_handler")->createNewFormForPage($page);

        $edit_form->bind($this->container->get("request")->get("haven_bundle_cmsbundle_pagecontenttype"));


        if ($edit_form->isValid()) {
            $this->container->get("page_content.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return $this->redirectEditAction($edit_form->getData()->getId());
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/{edit}/page_content/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
        $entity = $this->container->get('page_content.read_handler')->get($id);
        $edit_form = $this->container->get("page_content.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("page_content.form_handler")->createDeleteForm($entity->getId());
        
        
        
        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/{edit}/page_content/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('page_content.read_handler')->get($id);
        $edit_form = $this->container->get("page_content.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("page_content.form_handler")->createDeleteForm($entity->getId());

        $edit_form->bind($this->container->get("request")->get("haven_bundle_cmsbundle_pagecontenttype"));

        if ($edit_form->isValid()) {
            $this->container->get("page_content.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return $this->redirectEditAction($edit_form->getData()->getId());
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

    protected function redirectListAction() {
        return new RedirectResponse($this->container->get('router')->generate('haven_cms_pagecontent_list', array('list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    protected function redirectEditAction($id) {
        return new RedirectResponse($this->container->get('router')->generate('haven_cms_pagecontent_edit', array(
                    'edit' => $this->container->get('translator')->trans("edit", array(), "routes")
                    , 'id' => $id)));
    }

}

?>
