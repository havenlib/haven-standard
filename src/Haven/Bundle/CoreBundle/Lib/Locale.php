<?php

namespace Haven\Bundle\CoreBundle\Lib;

/**
 * Description of LocalesManager
 *
 * @author Stéphan Champagne <sc@evocatio.com>
 */
class Locale extends \Symfony\Component\Locale\Locale {

    static public function getSystemLocales() {
//        gets the string of installed locales and split in array
        $locales = shell_exec('locale -am');
        $locales = preg_split('/\n/', $locales);
//        remove the capitalized C POSIX and others, keep unique values
        array_walk($locales, function(&$string) {
                    return (strtolower(substr($string, 0, 2)) == substr($string, 0, 2));
                })
        ;
        return array_unique($locales);
    }

    static public function getAvailableDisplaySystemLocales($locale = null) {
        $available = self::getSystemLocales();


//        echo "<pre>";
////        print_r($available);
//        foreach($available as $one){
//            echo self::getDisplayLanguage($one, "fr_CA")." ";
//            echo self::getDisplayName($one, "fr_CA")." ";
//        }
//        echo "</pre>";
//        die();
        return $available;
    }

    /**
     * Return the list of languages from system locales. Regardless of culture.
     * 
     * @return type array("en" => "English", ...)
     */
    static public function getAvailableDisplayLanguage() {
        $locales = self::getAvailableDisplaySystemLocales();

        $langues = array();
        foreach ($locales as $locale) {
            $langues[Locale::getPrimaryLanguage($locale)] = Locale::getDisplayLanguage($locale);
        }

        return array_unique($langues);
    }

    /**
     * Return the list of languages from system locales. Regardless of culture.
     * 
     * @return type array("en" => "English", ...)
     */
    static public function getAvailableDisplayCulture($symbol = null) {
        $locales = self::getAvailableDisplaySystemLocales(Locale::getDefault());

        $langues = array();
        foreach ($locales as $locale) {

            $symbole = Locale::getPrimaryLanguage($locale) . "_" . Locale::getRegion($locale);
            if ($symbol != null) {
                if (Locale::getPrimaryLanguage($locale) == $symbol) {
                    $langues[$symbole] = Locale::getDisplayRegion($locale);
                }
            } else {
                $langues[$symbole] = Locale::getDisplayRegion($locale);
            }
        }
        
        return array_unique($langues);
    }

    static public function getAvailableSystemLocales() {
        $available = self::getSystemLocales();
        return array_intersect_key(self::getLocales(), array_flip($available));
    }

}