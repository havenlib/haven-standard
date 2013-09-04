<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\PortfolioBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PortfolioController extends ContainerAware {

    protected $ROUTE_PREFIX = "haven_portfolio";

    /**
     * @Route("/portfolio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $entities = $this->container->get("portfolio.read_handler")->getAllPublished();
        return array("entities" => $entities);
    }

    /**
     * @Route("/admin/{list}/portfolio")
     * @Method("GET")
     * @Template()
     */
    public function listAction() {
        $entities = $this->container->get("portfolio.read_handler")->getAll();
        foreach ($entities as $entity) {
            $delete_forms[$entity->getId()] = $this->container->get("portfolio.form_handler")->createDeleteForm($entity->getId())->createView();
        }

        return array("entities" => $entities
            , 'delete_forms' => isset($delete_forms) && is_array($delete_forms) ? $delete_forms : array()
        );
    }

    /**
     * @Route("/admin/{show}/portfolio/{id}", defaults={"show" = "afficher"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $entity = $this->container->get("portfolio.read_handler")->get($id);
        $delete_form = $this->container->get("portfolio.form_handler")->createDeleteForm($id);

        return array(
            'entity' => $entity,
            "delete_form" => $delete_form->createView()
        );
    }

    /**
     * @Route("/admin/{create}/portfolio")
     * @Method("GET")
     * @Template
     */
    public function createAction() {
        $edit_form = $this->container->get("portfolio.form_handler")->createNewForm();
        return array("edit_form" => $edit_form->createView());
    }

    /**
     * Creates a new foglio entity.
     *
     * @Route("/admin/{create}/portfolio")
     * @Method("POST")
     * @Template
     */
    public function addAction() {
        $edit_form = $this->container->get("portfolio.form_handler")->createNewForm();

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("Request"))
                ->slug(array("name"))
                ->getRequest();

        $edit_form->bind($request);

        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("portfolio.persistence_handler")->save($edit_form->getData());

            return new RedirectResponse($this->generateI18nRoute($route = $this->ROUTE_PREFIX . '_portfolio_list', array(), array('list')));
        } else {
            $this->container->get("session")->getFlashBag()->add("error", "create.error");
        }


        $template = str_replace(":add.html.twig", ":create.html.twig", $this->container->get("request")->get('_template'));
        $params = array(
            'entity' => $edit_form->getData()
            , 'edit_form' => $edit_form->createView()
        );

        return new Response($this->container->get('templating')->render($template, $params));
    }

    /**
     * @Route("/admin/{edit}/portfolio/{id}")
     * @Method("GET")
     * @Template
     */
    public function editAction($id) {
        $entity = $this->container->get('portfolio.read_handler')->get($id);
        $edit_form = $this->container->get("portfolio.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("portfolio.form_handler")->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * @Route("/admin/{edit}/portfolio/{id}")
     * @return RedirectResponse
     * @Method("POST")
     * @Template
     */
    public function updateAction($id) {
        $entity = $this->container->get('portfolio.read_handler')->get($id);
        $edit_form = $this->container->get("portfolio.form_handler")->createEditForm($entity->getId());
        $delete_form = $this->container->get("portfolio.form_handler")->createDeleteForm($entity->getId());

        $request = $this->container->get('request_modifier')->setRequest($this->container->get("request"))
                ->slug(array("name"))
                ->getRequest();

        $edit_form->bind($request);


        if ($edit_form->get('save')->isClicked() && $edit_form->isValid()) {
            $this->container->get("portfolio.persistence_handler")->save($edit_form->getData());
            $this->container->get("session")->getFlashBag()->add("success", "update.success");

            return new RedirectResponse($this->generateI18nRoute($route = $this->ROUTE_PREFIX . '_portfolio_list', array(), array('list')));
        } else {
            if ($edit_form->get('template')->isClicked()) {
                $edit_form = $this->container->get("portfolio.form_handler")->createNewForm($edit_form->getData());
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
     * @Route("/admin/{delete}/portfolio")
     * @Method("POST")
     */
    public function deleteAction() {

        $form_data = $this->container->get("request")->get('form');
        $this->container->get("portfolio.persistence_handler")->delete($form_data['id']);

        return new RedirectResponse($this->container->get('router')->generate(str_replace('delete', "list", $this->container->get("request")->get("_route")), array(
                    'list' => $this->container->get('translator')->trans("list", array(), "routes"))));
    }

    protected function generateI18nRoute($route, $parameters = array(), $translate = array(), $lang = null, $absolute = false) {
        foreach ($translate as $word) {
            $parameters[$word] = $this->container->get('translator')->trans($word, array(), "routes", $lang);
        }
        return $this->container->get('router')->generate($route, $parameters, $absolute);
    }

}
