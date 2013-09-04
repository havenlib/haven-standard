<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Stéphan Champagne <sc@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Haven\Bundle\MediaBundle\Entity\File
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 */
class File {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $mimeType
     *
     * @ORM\Column(name="mimeType", type="string", length=128, unique=false, nullable = true)
     */
    private $mimeType;

    /**
     * @var string $pathName
     *
     * @ORM\Column(name="pathName", type="string", length=128, unique=false, nullable = true)
     */
    private $pathName;

    /**
     * @var string $prePersistName
     */
    private $prePersistName;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=128, unique=false, nullable = true)
     */
    private $name;

    /**
     * @var string $fileName
     *
     * @ORM\Column(name="fileName", type="string", length=128, unique=false, nullable = true)
     */
    private $fileName;

    /**
     * @var string $size
     *
     * @ORM\Column(name="size", type="integer", nullable = true)
     */
    private $size;

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return File
     */
    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Set pathName
     *
     * @param string $pathName
     * @return File
     */
    public function setPathName($pathName) {
        $this->pathName = $pathName;

        return $this;
    }

    /**
     * Get pathName
     *
     * @return string 
     */
    public function getPathName() {
        return $this->pathName;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return File
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName() {
        return $this->fileName;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return File
     */
    public function setSize($size) {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    public function getType() {
        return strstr($this->getMimeType(), '/', true);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist() {
        $this->prePersistName = $this->getPathName();
        $this->setPathName(str_replace("/tmp/", "/", $this->getPathName()));
    }

    /**
     * When the file persists, if it is in the tmp subdir, it will be move before save.
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function moveToPermanent() {
//        to keep the save as it is, I need to get the path without the filename and also remove the /tmp
        $destination_path = str_replace($this->getFileName(), '', $this->getPathName());
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        if (null !== $this->getPathName() && $this->getPathName() != $this->prePersistName) {
            $this->move($destination_path);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFromFileSystem() {
        if (is_file($this->getPathName())) {
            unlink($this->getPathName());
        }
    }

//    eventually will be overwritten by a collection of move providers (for save in repositories like youtube etc) depending on discriminator (and filetype)
    private function move($directory, $name = null) {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
        }

        $target = $directory . (null === $name ? $this->getFileName() : $name);

        if (!@rename($this->prePersistName, $target)) {
            $error = error_get_last();
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error['message'])));
        }

        @chmod($target, 0666 & ~umask());

        return new File($target);
    }
    
    public function __toString() {
        return $this->getName();
    }

}