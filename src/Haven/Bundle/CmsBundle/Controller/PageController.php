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
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class PageController extends ContainerAware {

    /**
     * Finds and all pages for admin.
     *
     * @Route("admin/{list}/page")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("page.read_handler")->getAll();

        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("page.form_handler")->createDeleteForm($entity->getId())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
        );
    }

    /**
     * Finds and displays a page entity.
     *
     * @Route("/admin/{show}/page/{id}")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("page.read_handler")->get($id);
        $delete_form = $this->container->get("page.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity
            , "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/{create}/page")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("page.form_handler")->createNewForm();
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * @Route("/admin/{create}/page")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("page.form_handler")->createNewForm();

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("title"))
                ->upload()
                ->getRequest();

        $edit_form->bind($request);

        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("page.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return $this->redirectEditAction($edit_form->getData()->getId());
        } else {
            if ($edit_form->get('tpl')->isClicked()) {

                $this->container->get("page.form_handler")->createNewForm($edit_form->getData());
            } else {
                $this->container->get("session")->getFlashBag()->add("error", "create.error");
            }
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/{edit}/page/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
//        $entity = $this->container->get('page.read_handler')->get($id);
        $edit_form = $this->container->get("page.form_handler")->createEditForm($id);
        $delete_form = $this->container->get("page.form_handler")->createDeleteForm($id);
//        $edit_html_content_form = $this->container->get("page_content.form_handler")->createNewFormForPage($edit_form->getData());



        return array(
            'entity' => $edit_form->getData(),
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
//            'edit_html_content_form' => $edit_html_content_form->CreateView()
        );
    }

    /**
     * @Route("/admin/{edit}/page/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $edit_form = $this->container->get("page.form_handler")->createEditForm($id);
        $delete_form = $this->container->get("page.form_handler")->createDeleteForm($id);
//        $edit_html_content_form = $this->container->get("page_content.form_handler")->createNewFormForPage($edit_form->getData());

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("title"))
                ->upload()
                ->getRequest();

        $edit_form->bind($request);

        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("page.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "edit.success");

            return $this->redirectEditAction($edit_form->getData()->getId());
        } else {
            if ($edit_form->get('tpl')->isClicked()) {

                $this->container->get("session")->getFlashBag()->add("success", "template.changed");
                $edit_form = $this->container->get("page.form_handler")->changeTemplate($edit_form->getData());
            } else {
                $this->container->get("session")->getFlashBag()->add("error", "edit.error");
            }
        }


        $template = str_replace(":update.html.twig", ":edit.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $edit_form->getData(),
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/{delete}/page")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("page.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route")), array(
                    'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    protected function redirectListAction() {
        return new RedirectResponse($this->container->get('router')->generate('haven_cms_page_list', array('list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    protected function redirectEditAction($id) {
        return new RedirectResponse($this->container->get('router')->generate('haven_cms_page_edit', array(
                    'edit' => $this->container->get('translator')->trans("edit", array(), "routes")
                    , 'id' => $id)));
    }

}

?>
