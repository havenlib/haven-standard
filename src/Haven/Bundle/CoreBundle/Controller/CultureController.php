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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// Sensio includes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CultureController extends ContainerAware {

    /**
     * @Route("/admin/edit/culture/{display_language}")
     * @Method("GET")
     * @Template
     */
    public function editAction() {
        $current_language = $this->container->get("haven_core.language.read_handler")->getBySymbol($this->container->get('Request')->get('display_language'));
        $edit_form = $this->container->get("haven_core.culture.form_handler")->createEditForm($current_language->getSymbol());

        return array('edit_form' => $edit_form->createView(), 'language' => $current_language);
    }

    /**
     * @Route("/admin/edit/culture/{display_language}")
     * @Method("POST")
     * @Template
     */
    public function updateAction() {
        $current_language = $this->container->get("haven_core.language.read_handler")->getBySymbol($this->container->get('Request')->get('display_language'));
        $edit_form = $this->container->get("haven_core.culture.form_handler")->createEditForm($current_language->getSymbol());
        $edit_form->bind($this->container->get('Request'));

        if ($edit_form->isValid()) {

            $this->container->get("haven_core.culture.persistence_handler")->save($edit_form->get("symboles")->getData(), $current_language->getSymbol());
            return new RedirectResponse($this->container->get('router')->generate('haven_core_culture_edit', array('edit' => $this->container->get('translator')->trans("edit", array(), "routes"),
                        'display_language' => $current_language->getSymbol())));
        }

        return array('form' => $edit_form->createView());
    }

//    /**
//     * Validate and save form, if invalid returns form
//     * @param type $edit_form
//     * @return true or form
//     */
//    public function processForm($edit_form, $language) {
//
//        if ($edit_form->isValid()) {
//            $em = $this->container->get("Doctrine")->getEntityManager();
//            $languages = $em->getRepository("HavenCoreBundle:Language")->findAll();
//
//            $cultures = $language->getCultures()->toArray();
//            $selected_cultures = $edit_form->get("symboles")->getData();
//
//            // Create new culture for current language if not exist and store them in the cultures array. 
//            foreach ($selected_cultures as $key => $symbol) {
//                $culture = current(array_filter($cultures, function($culture) use ($symbol) {
//                                    return $culture->getSymbol() == $symbol;
//                                }));
//
//                if (!$culture) {
//                    $culture_form = $this->container->get('form.factory')->create(new CultureType());
//                    $culture_form->bind(array('symbol' => $symbol, 'status' => 1));
//                    $culture = $culture_form->getData();
//                    $culture->setLanguage($language);
//                    $language->getCultures()->add($culture);
//                }
//            }
//
//            //Translate each cultures to other languages, and persist.
//            foreach ($language->getCultures() as $culture) {
//                $culture->refreshTranslations($languages);
//            }
//            $em->persist($language);
//            $this->removeCultures($selected_cultures, $language->getCultures(), $em);
//
//            $em->flush();
//
//            return true;
//        }
//
//        return $edit_form;
//    }
//
//    public function removeCultures($selected_cultures, $cultures, $em) {
//        foreach ($cultures as $culture) {
//            if (!in_array($culture->getSymbol(), $selected_cultures)) {
//                $em->remove($culture);
//            }
//        }
//    }
}

?>
