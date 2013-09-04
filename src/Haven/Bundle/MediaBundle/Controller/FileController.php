<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class FileController extends ContainerAware {

    /**
     * @Route("/file")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $entities = $this->container->get("file.read_handler")->getAllPublished();
        return array("entities" => $entities);
    }

    /**
     * Finds and displays all files for admin.
     *
     * @Route("/admin/list/file")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("haven_media.file.read_handler")->getAll();


        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
        );
    }

    /**
     * @Route("/admin/create/file")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("haven_media.file.form_handler")->createNewForm();
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * Creates a new file entity.
     *
     * @Route("/admin/create/file")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("haven_media.file.form_handler")->createNewForm();
        $request = $this->container->get('request_modifier')->setRequest($this->container->get("Request"))
                ->slug(array("title"))
                ->upload()
                ->getRequest();

        $edit_form->bind($request);


        if ($edit_form->isValid()) {
            $this->container->get("haven_media.file.persistence_handler")->batchSave($edit_form->get("files")->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('add', "list", $this->container->get("request")->get("_route")), array(
                        'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/edit/file/{id}")
     * @Method("GET")
     * @Template
     * 
     * @return RedirectResponse
     */
    public function editAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.file.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/edit/file/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.file.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());


        $edit_form->bind($this->container->get('Request'));
        if ($edit_form->isValid()) {
            $this->container->get("haven_media.file.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('update', "list", $this->container->get("request")->get("_route")), array(
                        'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
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

    /**
     * @Route("/admin/delete/file")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("haven_media.file.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route")), array(
                    'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    /**
     * @Route("/admin/download/file/{id}")
     * @Method("POST")
     */
    public function downloadAction($id) {
        $send_file = $this->container->get("haven_media.file.read_handler")->get($id);
        $path = $this->container->get('kernel')->getRootDir() . "/" . $send_file->getPathName();
        
        $content = file_get_contents($path);
        ob_clean();

        $response = new Response();
        $response->headers->set('Content-Type', $send_file->getMimeType());
        $response->headers->set('Content-Length', $send_file->getSize());
        $response->setContent($content);
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $send_file->getName(), "DownloadedFile");
        $response->headers->set('Content-Disposition', $d);

        return $response;
    }

//    /**
//     * Set a file entity state to inactive.
//     *
//     * @Route("/admin/file/{id}/state", name="HavenWebBundle_FileToggleState")
//     * @Method("GET")
//     */
//    public function toggleStateAction($id) {
//        $em = $this->container->get('doctrine')->getEntityManager();
//        $entity = $em->find('HavenWebBundle:File', $id);
//        if (!$entity) {
//            throw new NotFoundHttpException("File non trouvé");
//        }
//        $entity->setStatus(!$entity->getStatus());
//        $em->persist($entity);
//        $em->flush();
//
//        return new RedirectResponse($this->container->get("request")->headers->get('referer'));
//    }
}
