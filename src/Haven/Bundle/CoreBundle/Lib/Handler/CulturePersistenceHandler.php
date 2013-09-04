<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Haven\Bundle\CoreBundle\Lib\Handler\CultureReadHandler;
use Haven\Bundle\CoreBundle\Entity\Culture;

class CulturePersistenceHandler {

    protected $em;
    protected $security_context;
    protected $read_handler;
    protected $language_read_handler;

    public function __construct(CultureReadHandler $read_handler, LanguageReadHandler $language_read_handler, EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
        $this->language_read_handler = $language_read_handler;
    }

    public function save($selected_cultures, $symbol) {

        $current_language = $this->language_read_handler->getBySymbol($symbol);

        $cultures = $current_language->getCultures()->toArray();
        $languages = $this->language_read_handler->getAll();
        // Create new culture for current language if not exist and store them in the cultures array. 
        foreach ($selected_cultures as $symbol) {
            $culture = current(array_filter($cultures, function($culture) use ($symbol) {
                                return $culture->getSymbol() == $symbol;
                            }));

            if (!$culture) {
                $culture = new Culture();
                $culture->setSymbol($symbol);
                $culture->setStatus(1);
                $culture->setLanguage($current_language);

                $current_language->getCultures()->add($culture);
            }
        }

        //Translate each cultures to other languages, and persist.
        foreach ($current_language->getCultures() as $culture) {
            $culture->refreshTranslations($languages);
        }
        $this->em->persist($current_language);
        $this->removeUnselectedCultures($selected_cultures, $current_language->getCultures(), $this->em);

        $this->em->flush();
    }

    public function removeUnselectedCultures($selected_cultures, $cultures, $em) {
        foreach ($cultures as $culture) {
            if (!in_array($culture->getSymbol(), $selected_cultures)) {
                $em->remove($culture);
            }
        }
    }

}

?>
