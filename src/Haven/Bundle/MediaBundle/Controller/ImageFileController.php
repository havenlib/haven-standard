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

class ImageFileController extends ContainerAware {

    /**
     * @Route("/admin/resize/image/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function resizeAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.image_file.form_handler")->createResizeForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/resize/image/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function perfomResizingAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.image_file.form_handler")->createResizeForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());

        $edit_form->bind($this->container->get('Request'));
        if ($edit_form->isValid()) {
            $resizeResult = $this->container->get("haven_media.image_file.manipulator")->resizeOrCrop($entity->getFileName()
                    , $entity->getPathName()
                    , $entity->getMimeType()
                    , $entity->getWidth()
                    , $entity->getHeight()
                    , $edit_form->get("width")->getData()
                    , $edit_form->get("height")->getData()
            );

            if ($resizeResult && is_array($resizeResult)) {
                $data = array_merge($resizeResult, array(
                    "name" => $resizeResult["width"] . 'x' . $resizeResult["height"] . "_" . $entity->getName()
                    , "alt" => $entity->getAlt()
                ));

                $newEntity = $this->container->get("haven_media.file.manipulator")->mergeWithArray(new \Haven\Bundle\MediaBundle\Entity\ImageFile, $data);

                $this->container->get("haven_media.file.persistence_handler")->save($newEntity);
                $this->container->get("session")->getFlashBag()->add("success", "resize.success");

                return new RedirectResponse($this->container->get('router')->generate($this->container->get("request")->get("_route"), array(
                            'id' => $newEntity->getId())));
            }
        }

        $this->container->get("session")->getFlashBag()->add("error", "resize.error");

        $template = str_replace(":perfomResizing.html.twig", ":resize.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/crop/image/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function cropAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.image_file.form_handler")->createCropForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/crop/image/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function perfomCropAction($id) {
        $entity = $this->container->get('haven_media.file.read_handler')->get($id);
        $edit_form = $this->container->get("haven_media.image_file.form_handler")->createCropForm($entity->getId());
        $delete_form = $this->container->get("haven_media.file.form_handler")->createDeleteForm($entity->getId());

        $edit_form->bind($this->container->get('Request'));
        if ($edit_form->isValid()) {
            $resizeResult = $this->container->get("haven_media.image_file.manipulator")->resizeOrCrop($entity->getFileName()
                    , $entity->getPathName()
                    , $entity->getMimeType()
                    , $width = $edit_form->get("width")->getData()
                    , $height = $edit_form->get("height")->getData()
                    , $width
                    , $height
                    , $edit_form->get("x")->getData()
                    , $edit_form->get("y")->getData()
            );

            if ($resizeResult && is_array($resizeResult)) {
                $data = array_merge($resizeResult, array(
                    "name" => $resizeResult["width"] . 'x' . $resizeResult["height"] . "_" . $entity->getName()
                    , "alt" => $entity->getAlt()
                ));

                $newEntity = $this->container->get("haven_media.file.manipulator")->mergeWithArray(new \Haven\Bundle\MediaBundle\Entity\ImageFile, $data);

                $this->container->get("haven_media.file.persistence_handler")->save($newEntity);
                $this->container->get("session")->getFlashBag()->add("success", "resize.success");

                return new RedirectResponse($this->container->get('router')->generate($this->container->get("request")->get("_route"), array(
                            'id' => $newEntity->getId())));
            }
        }

        $this->container->get("session")->getFlashBag()->add("error", "crop.error");

        $template = str_replace(":perfomResizing.html.twig", ":resize.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/show/image/{id}")
     * @Method("GET")
     * @Template
     */
    public function showAction($id) {
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

}
