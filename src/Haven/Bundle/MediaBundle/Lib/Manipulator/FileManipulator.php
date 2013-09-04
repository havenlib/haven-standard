<?php

/*
 * This file is part of the Haven package.
 *
 * (c) Laurent Breleur <lbreleur@evocatio.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Haven\Bundle\MediaBundle\Lib\Manipulator;

class FileManipulator {

    private $root_dir;
    private $upload_dir;

    public function __construct($root_dir, $upload_dir) {
        $this->root_dir = $root_dir;
        $this->upload_dir = $upload_dir;
    }

    public function transformTo($entity) {
        if (preg_match("/image/", $entity->getMimeType())) {
            return $this->transformToImage($entity);
        } elseif (preg_match("/application/", $entity->getMimeType())) {
            return $this->transformToApplication($entity);
        } elseif (preg_match("/audio/", $entity->getMimeType())) {
            return $this->transformToAudio($entity);
        } else {
            return $this->transformToUnknow($entity);
        }
    }

    private function transformToImage($entity) {
        $entity = $this->merge($entity, new \Haven\Bundle\MediaBundle\Entity\ImageFile());

        list($width, $height) = getimagesize($this->root_dir . "/" . $entity->getPathName());
        $entity->setWidth($width);
        $entity->setHeight($height);

        return $entity;
    }

    private function transformToApplication($entity) {
        return $entity = $this->merge($entity, new \Haven\Bundle\MediaBundle\Entity\ApplicationFile());
    }

    private function transformToAudio($entity) {
        return $entity = $this->merge($entity, new \Haven\Bundle\MediaBundle\Entity\AudioFile());
    }

    private function transformToUnknow($entity) {
        return $entity = $this->merge($entity, new \Haven\Bundle\MediaBundle\Entity\UnknowFile());
    }

    public function merge($obj1, $obj2) {
        foreach ((array) $obj1 as $key => $value) {
            if (method_exists($obj2, $method_name = "set" . ucfirst(trim(str_replace(get_class($obj1), "", $key)))))
                $obj2->{$method_name}($value);
        }

        return $obj2;
    }

    public function mergeWithArray($obj, $data) {
        foreach ($data as $key => $value) {
            if (method_exists($obj, $method_name = "set" . ucfirst(trim($key))))
                $obj->{$method_name}($value);
        }

        return $obj;
    }

}

?>
