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
//Haven includes
use Haven\Bundle\CoreBundle\Lib\Locale;
use Haven\Bundle\CoreBundle\Entity\Language;

class CoreController extends ContainerAware {

    /**
     * @Route("/changeLanguage", name="change_language")
     */
    public function changeLanguageAction() {
        $router = $this->container->get("router");
        $doctrine = $this->container->get("Doctrine");
        $request = $this->container->get("Request");

        // if language exists and is status, set current language to it
        if ($doctrine->getEntityManager()->getRepository("HavenCoreBundle:Culture")->findBy(array('status' => 1, 'symbol' => $request->get("lang")))) {
//        get the base URL to remove form http_referer to get URI
            $urlBaseReferer = $router->getContext()->getScheme() . "://" . $router->getContext()->getHost() . $router->getContext()->getBaseUrl();
//        figuring out the referers route information 
            $uri = str_replace($urlBaseReferer, "", $request->server->get('HTTP_REFERER'));
            $routeArray = $router->match($uri);
//        changing the locale to the current one while probably have to manage sluggable around here
            $routeArray["_locale"] = $request->get("lang");

            $route = $routeArray["_route"];
            unset($routeArray["_route"]);
//        $this->container->get("session")->getFlashBag()->add("error", "lang is : " . print_r($routeArray,true) );  //   $router->match($this->getRequest()->server->get('HTTP_REFERER')));

            return new RedirectResponse($this->container->get('router')->generate($route, $routeArray));
        }
        return new RedirectResponse($request->server->get('HTTP_REFERER'));
    }

    /**
     * Cette action sert à render un widget de selection de la language
     * @Route("/switcher", name="core_switcher_widget")
     * @param <string> $template        Le template à utiliser pour lister les languages
     * @param <boolean> $status         Si l'on doit retourner seulement les languages statuss
     */
    public function i18nSwitcherAction($template = null, $status = true) {
        $rep = $this->container->get("Doctrine")->getRepository("HavenCoreBundle:Culture");
        $languages = $status ? $rep->findByStatus(true) : $rep->findAll();
        return new Response(
                        $this->container->get('templating')->render(
                                $template ? $template : 'HavenCoreBundle:Core:i18nSwitcher.html.twig'
                                , array('languages' => $languages)
                ));
    }

}
