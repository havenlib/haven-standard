<?php

namespace Haven\Bundle\CoreBundle\Lib;

use \Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader {

    private $root_dir;
    private $upload_dir;

    public function __construct($root_dir, $upload_dir) {
        $this->root_dir = $root_dir;
        $this->upload_dir = $upload_dir;
    }

    public function uploadRequestFiles(\Symfony\Component\HttpFoundation\Request $request) {
        $files = $request->files->all();
        $data = $request->request->all();

        return $this->moveFilesToTempAndMerge($files, $data);
    }

    public function moveFilesToTempAndMerge($filesT, $requestT) {
//        $filesT = array_pop($filesT);
//        $requestT = array_pop($requestT);
//        echo "<pre>";
//        print_r($filesT);
//        echo "</pre>";
//        die();
        if (!empty($filesT)) {

            $this->changeUploadsToFiles($filesT, $requestT);
        }

//           print_r($filesT);die();
//        echo "return values ======>";
//        print_r($requestT);
//        $resultT = array_merge_recursive($filesT, $requestT);

        return $requestT;
    }

    /**
     * recursive look into the ArrayFiles to find all ["uploads"], and transform them to ["files"] and merge them with arrayRequest.
     * It changes the uploadedFiles to array's and moves the files to a new location configured in %secure_upload_dir%
     * @param type $arrayFile
     * @param type $arrayRequest
     */
    private function changeUploadsToFiles(&$arrayFile, &$arrayRequest) {
        if (array_key_exists("uploads", $arrayFile) && !empty($arrayFile["uploads"][0])) {
            $arrayRequest["files"] = array_merge(!empty($arrayRequest["files"]) ? $arrayRequest["files"] : array(), $this->transformUploadedFileToFileArray($arrayFile["uploads"]));
//                echo 'i------------n' . print_r(array_keys($arrayFile), 1);
//            unset($array["uploads"]);
        }

        foreach ($arrayFile as $key => &$child) {

            if (is_array($child)) {
                $this->changeUploadsToFiles($child, $arrayRequest[$key]);
//                unset($child);
            }
        }
    }

    private function transformUploadedFileToFileArray($file) {
        $upload_dir = $this->upload_dir;
        array_walk_recursive($file, function(&$item, &$key) use ($upload_dir) {
                    if ($item instanceof UploadedFile /*&& !$item->getError()*/) {
                        $on_rep_name = uniqid() . "." . $item->guessExtension();
                        $array = Array
                            (
                            ("mimeType") => $item->getClientMimeType()
                            , ("pathName") => $upload_dir . "tmp/" . $on_rep_name
                            , ("name") => $item->getClientOriginalName()
                            , ("fileName") => $on_rep_name
                            , ("size") => $item->getClientSize()
                        );
                        $item->move($upload_dir . "tmp/", $on_rep_name);
                        $item = $array;
                    }
                });
        return $file;
    }

//    /**
//     * Upload a file in web directory. If $location parameter is not 
//     * precised, file will be moved in /web/uploads/tmp directory by 
//     * default else it will be moved in /web/your_directory.
//     * 
//     * @param type $file
//     * @param string $location
//     * @return boolean
//     * 
//     */
//    public function moveFile(UploadedFile $file, $location = null) {
//
//        $relative_location = ($location) ? $location : "tmp";
//        $location = $this->root_dir->getRootDir() . "/../web/uploads/" . $relative_location;
//
//        if (!file_exists($location))
//            mkdir($location, 0777, true);
//
//        $file->move($location, $file->getClientOriginalName());
//
//        return $relative_location . "/" . $file->getClientOriginalName();
//    }
//    public function moveFiles($data, $location = null) {
//        if (is_array($data)) {
//            foreach ($data as $d) {
//                $this->moveFiles($d, $location);
//            }
//        } else if ($data instanceof UploadedFile) {
//            $this->moveFile($data, $location);
//        }
//    }
//    /**
//     * Takes the uploaded files stored in getUploads, and creates new files and add them to add files @TODO create a interface,
//     * @param type $entity (uploadable)
//     * @param type $destination Where we want the file to go
//     * @return type
//     * @throws \Exception 
//     */
//    public function makeFilesFromUploads($entity = null, $destination = null) {
//        // the file property can be empty if the field is not required
//        if (null === $entity) {
//            return;
//        }
//
//        if (null === $destination) {
//            throw new \Exception("you need a target for your file");
//        }
////            echo "<pre>";
////            echo "list uploads";
////            print_r($entity->getUploads());
//        foreach ($entity->getUploads() as $upload) {
////            has to check for empty, or error
//            if (!empty($upload) && !$upload->getError()) {
//                $movedFile = $upload->move($destination, uniqid() . "_" . $upload->getClientOriginalName());
//                $file = new File($movedFile);
//                $file->setName($upload->getClientOriginalName());
//                $file->fillFromFile($movedFile, $destination);
////            echo "One upload in loop";
////            print_r($upload);
////            echo "Moved upload in loop";
////            print_r($upload);
//                $entity->addFile($file);
//            }
//        }
////            print_r($entity->getUploads());
////            echo "</pre>";
//        $entity->clearUploads();
//    }
}

?>
