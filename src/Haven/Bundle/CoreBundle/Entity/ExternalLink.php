<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Haven\Bundle\CoreBundle\Entity\ExternalLink
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ExternalLink extends Link {


    /**
     * @ORM\Column(name="url", type="string", length=1024)
     */
    protected $url;

    public function __construct($url = null) {
        $this->url = $url;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ExternalLink
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
    }

}