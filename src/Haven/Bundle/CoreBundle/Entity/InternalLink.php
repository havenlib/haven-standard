<?php

namespace Haven\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Haven\Bundle\CoreBundle\Entity\InternalLink
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class InternalLink extends Link {
    
    /**
     * @ORM\Column(name="route", type="string", length=128)
     */
    protected $_route;

    /**
     * @ORM\Column(name="params", type="string", length=1024)
     */
    protected $_route_params;

    public function __construct($route = null, array $params = array()) {
        $this->_route = $route;
        $this->_route_params = $params;
    }

    /**
     * Set _route
     *
     * @param string $route
     * @return InternalLink
     */
    public function setRoute($route) {
        $this->_route = $route;

        return $this;
    }

    /**
     * Get _route
     *
     * @return string 
     */
    public function getRoute() {
        return $this->_route;
    }

    /**
     * Set _route_params
     *
     * @param string $routeParams
     * @return InternalLink
     */
    public function setRouteParams($routeParams) {
        $this->_route_params = $routeParams;

        return $this;
    }

    /**
     * Get _route_params
     *
     * @return array 
     */
    public function getRouteParams() {
        return unserialize($this->_route_params);
    }

}