<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Haven\Bundle\CoreBundle\Entity\TranslationMappedBase
 *
 * @ORM\MappedSuperclass
 */
abstract class TranslationMappedBase {

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="trans_lang_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $trans_lang;
    

    /**
     * Set trans_lang
     *
     * @param Haven\Bundle\CoreBundle\Entity\Language $transLang
     */
    public function setTransLang(\Haven\Bundle\CoreBundle\Entity\Language $transLang)
    {
        $this->trans_lang = $transLang;
    }

    /**
     * Get trans_lang
     *
     * @return Haven\Bundle\CoreBundle\Entity\Language 
     */
    public function getTransLang()
    {
        return $this->trans_lang;
    }

    protected function getParent(){
        
        throw new \Exception("Vous devez définir la fonction getParent() dans avec la class traduite comme cible dans ".get_called_class());
    }
}