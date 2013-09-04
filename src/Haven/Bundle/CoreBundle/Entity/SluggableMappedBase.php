<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Haven\Bundle\CoreBundle\Entity\SluggableMappedBase
 * 
 * @UniqueEntity(fields={"trans_lang", "slug"})
 * @ORM\MappedSuperclass
 */
abstract class SluggableMappedBase extends TranslationMappedBase {

    /**
     * @var string $slug
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
        return $this->slug;
    }

}