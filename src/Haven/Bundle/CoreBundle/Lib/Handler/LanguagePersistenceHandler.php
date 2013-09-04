<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Haven\Bundle\CoreBundle\Lib\Handler\LanguageReadHandler;
use Haven\Bundle\CoreBundle\Entity\Language;

class LanguagePersistenceHandler {

    protected $em;
    protected $security_context;
    protected $read_handler;

    public function __construct(LanguageReadHandler $read_handler, EntityManager $em, SecurityContext $security_context) {
        $this->em = $em;
        $this->security_context = $security_context;
        $this->read_handler = $read_handler;
    }

    public function save($selected_languages) {
        $languages = $this->read_handler->getAll();

        // Create new language if not exist and store them in the languages array
        foreach ($selected_languages as $symbol) {
            $language = current(array_filter($languages, function($language) use ($symbol) {
                                return $language->getSymbol() == $symbol;
                            }));

            if (!$language) {
                $language = new Language();
                $language->setSymbol($symbol);
                $language->setStatus(1);
                
                $languages[] = $language;
            }
            $this->em->persist($language);
        }

        //Translate each language to other languages and persist.
        foreach ($languages as $language) {
            $language->refreshTranslations($languages);
            $language->refreshMyCulturesTranslations($languages);
        }
        $this->removeUnselectedLanguages($selected_languages, $languages);
        $this->em->flush();
    }

    private function removeUnselectedLanguages($selected_languages, $languages) {
        foreach ($languages as $language) {
            if (!in_array($language->getSymbol(), $selected_languages)) {
                $this->em->remove($language);
            }
        }
    }

}

?>
