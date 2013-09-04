<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Haven\Bundle\MediaBundle\Entity\File;

/**
 * @ORM\Entity()
 */
class ApplicationFile extends File {

    /**
     * @var integer
     */
    protected $id;

    /**
     * Get id
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

}