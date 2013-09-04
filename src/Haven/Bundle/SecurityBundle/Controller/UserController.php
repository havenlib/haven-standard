<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\SecurityBundle\Controller;

// Symfony includes
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends ContainerAware {

    /**
     * @Route("/user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $entities = $this->container->get("user.read_handler")->getAll();
        return array("entities" => $entities);
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/show/user/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("user.read_handler")->get($id);
        $delete_form = $this->container->get("user.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity,
            "delete_form" => $delete_form->createView()
        );
    }

    /**
     * Finds and displays all users for admin.
     *
     * @Route("/admin/list/user")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("user.read_handler")->getAll();

        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("user.form_handler")->createDeleteForm($entity->getId())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
        );
    }

    /**
     * @Route("/admin/create/user")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("user.form_handler")->createNewForm();
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/admin/create/user")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("user.form_handler")->createNewForm();
        $edit_form->bind($this->container->get('request'));


        if ($edit_form->isValid()) {
            $this->container->get("user.persistence_handler")->save($user = $edit_form->getData());

            $reset = $this->container->get("user.persistence_handler")->createReset($user);
            $reset_url = $this->container->get('router')->generate(str_replace('add', "reset", $this->container->get("request")->get("_route")), array("uuid" => $reset->getUuid()), true);

            $notifier = $this->container->get('notifier');
            $notifier->createNewUserNotification($reset, $reset_url);
            $notifier->send();

            $this->container->get("session")->getFlashBag()->add("success", "create.success");
            return new RedirectResponse($this->container->get('router')->generate(str_replace('add', "list", $this->container->get("request")->get("_route"))));
        }

        $this->container->get("session")->getFlashBag()->add("error", "create.error");

        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    public function createResetAction($user) {

        /**
         * Permet de créer le reset et l'url de reset puis d'envoyer le mail à l'utilisateur
         */
        $reset = $this->container->get("user.persistence_handler")->createReset($user);
        $reset_url = $this->container->get('router')->generate(str_replace('add', "reset", $this->container->get("request")->get("_route")), array("uuid" => $reset->getUuid()), true);

        $notifier = $this->container->get('notifier');
        $notifier->createNewUserNotification($reset, $reset_url);
        $notifier->send();
    }

    /**
     * @Route("/admin/edit/user/{id}")
     * @return RedirectResponse
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
        $entity = $this->container->get('user.read_handler')->get($id);
        $edit_form = $this->container->get("user.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("user.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/edit/user/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('user.read_handler')->get($id);
        $edit_form = $this->container->get("user.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("user.form_handler")->createDeleteForm($entity->getId());


        $edit_form->bind($this->container->get('Request'));
        if ($edit_form->isValid()) {
            $this->container->get("user.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "create.success");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('update', "list", $this->container->get("request")->get("_route"))));
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
     * Set a user entity state to inactive.
     *
     * @Route("/admin/user/{id}/state", name="HavenSecurityBundle_toggleState")
     * @Method("GET")
     */
    public function toggleStateAction($id) {
        $em = $this->container->get('doctrine')->getEntityManager();
        $entity = $em->find('HavenSecurityBundle:User', $id);
        if (!$entity) {
            throw new NotFoundHttpException("User non trouvé");
        }
        $entity->setStatus(!$entity->getStatus());
        $em->persist($entity);
        $em->flush();

        return new RedirectResponse($this->container->get("request")->headers->get('referer'));
    }

    /**
     * @Route("/admin/delete/user")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("user.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route"))));
    }

    /**
     * reset confirmation by the user
     * @Route("/initialize/password/{uuid}") 
     * @Route("/reset/password/{uuid}") 
     * @Method("GET")
     * @Template()
     */
    public function resetAction($uuid) {
        $reset = $this->container->get("user.read_handler")->getResetByUuid($uuid);

        if (is_null($reset))
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();

        $form = $this->container->get("form.factory")->create(new \Haven\Bundle\SecurityBundle\Form\ConfirmType());
        return array("edit_form" => $form->createView(), "uuid" => $uuid);
    }

    /**
     * 
     * @Route("/initialize/password/{uuid}") 
     * @Route("/reset/password/{uuid}") 
     * @Method("POST")
     * @Template()
     */
    public function performResetAction($uuid) {
        $reset = $this->container->get("user.read_handler")->getResetByUuid($uuid);

        if (is_null($reset))
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();

        $form = $this->container->get("form.factory")->create(new \Haven\Bundle\SecurityBundle\Form\ConfirmType());
        $form->bind($this->container->get('request'));
        

        if ($form->isValid()) {

            if (is_null($user = $reset->getUser()) || $reset->getConfirmation() != $form->get('confirmation')->getData())
                throw new \Exception("user.doesnt.exist.or.initialization.request.not.found");

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user = $reset->getUser());

            $user->setPassword($encoder->encodePassword($form->get('plainPassword')->get('first')->getData(), $user->getSalt()));

            $this->container->get("user.persistence_handler")->save($user);
            $this->container->get("user.persistence_handler")->removeResets($user);

            $this->container->get("session")->getFlashBag()->add("success", "congratulation.password.changed.now.connect");

            return new RedirectResponse($this->container->get('router')->generate(str_replace('performreset', "index", $this->container->get("request")->get("_route"))));
        }

        $template = str_replace(":performReset.html.twig", ":reset.html.twig", $this->container->get("request")->get('_template'));
        $params = array("edit_form" => $form->createView(), "uuid" => $uuid);

        return new Response($this->container->get('templating')->render($template, $params));
    }

//    protected function generateI18nRoute($route, $parameters = array(), $translate = array(), $lang = null, $absolute = false) {
//        foreach ($translate as $word) {
//            $parameters[$word] = $this->container->get('translator')->trans($word, array(), "routes", $lang);
//        }
//        return $this->container->get('router')->generate($route, $parameters, $absolute);
//    }
}