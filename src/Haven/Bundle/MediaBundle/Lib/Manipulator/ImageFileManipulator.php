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

class ImageFileManipulator {

    private $root_dir;
    private $upload_dir;

    public function __construct($root_dir, $upload_dir) {
        $this->root_dir = $root_dir;
        $this->upload_dir = $upload_dir;
    }

    /**
     * 
     * @param type $fileName
     * @param type $pathName
     * @param type $mimeType
     * @param type $srcWidth
     * @param type $srcHeight
     * @param type $dstWidth
     * @param type $dstHeight
     * @param type $x
     * @param type $y
     * @return boolean or array
     * 
     * To crop set $srcWidth with $dstWith value and set $srcHeight with $dstHeight when passing parameters
     */
    public function resizeOrCrop($fileName, $pathName, $mimeType, $srcWidth, $srcHeight, $dstWidth, $dstHeight, $x = 0, $y = 0) {
        $dstImage = $this->createImageFrom($pathName, $mimeType);
        $dstPathName = str_replace($fileName, $dstFileName = str_replace(strstr($fileName, ".", true), uniqid(), $fileName), $pathName);

        $dstImageTrueC = imagecreatetruecolor($dstWidth, $dstHeight);

        //Keep png file transparency
        if ($mimeType == "image/png") {
            imagealphablending($dstImageTrueC, false);
            imagesavealpha($dstImageTrueC, true);
            imagefilledrectangle($dstImageTrueC, 0, 0, $dstWidth, $dstHeight, $transparent = imagecolorallocatealpha($dstImageTrueC, 255, 255, 255, 127));
        }

        $resizeSuccess = imagecopyresampled($dstImageTrueC, $dstImage, 0, 0, $x, $y, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
        if (!$resizeSuccess)
            return false;

        $createSuccess = $this->createPhysicalFile($mimeType, $dstImageTrueC, $newPath = $this->root_dir . "/" . $dstPathName, 100);
        if (!$createSuccess)
            return false;

        return array("pathName" => $dstPathName
            , "width" => $dstWidth
            , "height" => $dstHeight
            , "fileName" => $dstFileName
            , "mimeType" => $mimeType
            , "size" => filesize($newPath));
    }

    private function createImageFrom($pathName, $mimeType) {
        switch ($mimeType) {
            case "image/jpeg":
                return imagecreatefromjpeg($path = $this->root_dir . "/" . $pathName);
                break;
            case "image/png":
                return imagecreatefrompng($path = $this->root_dir . "/" . $pathName);
                break;
            default:
                throw new \Exception("You are trying to resize an unresizable file of MIME type " . $mimeType . ". Only png, jpeg files are accepted");
                break;
        }
    }

    private function createPhysicalFile($mimeType, $newImage, $newPath) {
        switch ($mimeType) {
            case "image/jpeg":
                return imagejpeg($newImage, $newPath, 100);
                break;
            case "image/png":
                return imagepng($newImage, $newPath);
                break;
            default:
                throw new \Exception("You are trying to resize an unresizable file of MIME type " . $mimeType . ". Only png, jpeg files are accepted");
                break;
        }
    }

}

?>
