<?php

namespace Haven\Bundle\CoreBundle\Generic;

use \Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader {

    private $kernel;

    public function __construct(\AppKernel $kernel) {
        $this->kernel = $kernel;
    }

    /**
     * Upload a file in web directory. If $location parameter is not 
     * precised, file will be moved in /web/uploads/tmp directory by 
     * default else it will be moved in /web/your_directory.
     * 
     * @param type $file
     * @param string $location
     * @return boolean
     * 
     */
    public function moveFile(UploadedFile $file, $location = null) {
        $relative_location = ($location) ? $location : "tmp";
        $location = $this->kernel->getRootDir() . "/../web/uploads/" . $relative_location;

        if (!file_exists($location))
            mkdir($location, 0777, true);

        $file->move($location, $file->getClientOriginalName());

        return $relative_location . "/" . $file->getClientOriginalName();
    }

    public function moveFiles($data, $location = null, $final = array(), $key = null) {
        if (is_array($data)) {
            foreach ($data as $key => $d) {
                $this->moveFiles($d, $location, $final, $key);
            }
        } else if ($data instanceof UploadedFile) {
//            $data = array(
//                'name' => $data->getClientOriginalName(),
//                'size' => $data->getSize(),
//                'path' => $this->moveFile($data, $location)
//            );
            unset($data);
        }
        
        return $data;
    }

    
}

?>
