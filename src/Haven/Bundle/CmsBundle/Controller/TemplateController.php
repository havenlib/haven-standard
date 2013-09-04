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

class TemplateController extends ContainerAware {

    /**
     * Finds and all templates for admin.
     *
     * @Route("admin/{list}/template")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("template.read_handler")->getAll();

        return array("entities" => $entities);
    }

    /**
     * Finds and displays a template entity.
     *
     * @Route("/admin/{show}/template/{id}")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("template.read_handler")->get($id);
        $delete_form = $this->container->get("template.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity
            , "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/{create}/template")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("template.form_handler")->createNewForm();
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * @Route("/admin/{create}/template")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("template.form_handler")->createNewForm();

        $edit_form->bind($this->container->get("request"));



        if ($edit_form->isValid()) {
            $this->container->get("template.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('add', "edit", $this->container->get("request")->get("_route")), array(
                        'edit' => $this->container->get('translator')->trans("edit", array(), "routes")
                        , 'id' => $edit_form->getData()->getId())));
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/{edit}/template/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
//        $entity = $this->container->get('template.read_handler')->get($id);
        $edit_form = $this->container->get("template.form_handler")->createEditForm($id);
        $delete_form = $this->container->get("template.form_handler")->createDeleteForm($id);
//        $edit_html_content_form = $this->container->get("template_content.form_handler")->createNewFormForTemplate($edit_form->getData());



        return array(
            'entity' => $edit_form->getData(),
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
//            'edit_html_content_form' => $edit_html_content_form->CreateView()
        );
    }

    /**
     * @Route("/admin/{edit}/template/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $edit_form = $this->container->get("template.form_handler")->createEditForm($id);
        $delete_form = $this->container->get("template.form_handler")->createDeleteForm($id);
//        $edit_html_content_form = $this->container->get("template_content.form_handler")->createNewFormForTemplate($edit_form->getData());

//        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
//                ->slug(array("name"))
//                ->upload()
//                ->getRequest();
        $edit_form->bind($this->container->get("request"));
        if ($edit_form->isValid()) {
            $this->container->get("template.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('update', "edit", $this->container->get("request")->get("_route")), array(
                        'edit' => $this->container->get('translator')->trans("edit", array(), "routes")
                        , 'id' => $edit_form->getData()->getId())));
        }

        $this->container->get("session")->getFlashBag()->add("error", "update.error");

        $template = str_replace(":update.html.twig", ":edit.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $edit_form->getData(),
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    protected function redirectListAction() {
        return new RedirectResponse($this->container->get('router')->generate('haven_cms_template_list', array('list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

//    protected function redirectEditAction($id) {
//        return new RedirectResponse($this->container->get('router')->generate('haven_cms_template_edit', array(
//                    'edit' => $this->container->get('translator')->trans("edit", array(), "routes")
//                    , 'id' => $id)));
//    }
}

?>
