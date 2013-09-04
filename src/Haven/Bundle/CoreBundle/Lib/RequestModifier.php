<?php

namespace Haven\Bundle\CoreBundle\Lib;

class RequestModifier {

    private $request;
    private $slugifier;
    private $uploader;

    function __construct(Slugifier $slugifier, Uploader $uploader) {
        $this->slugifier = $slugifier;
        $this->uploader = $uploader;
    }

    function slug($fields) {

        if (empty($this->request))
            throw new \Exception(get_class($this) . " expected a \Symfony\Component\HttpFoundation\Request object. You must pass it through setRequest.");

        $result = $this->slugifier->slugifyRequest($this->request, $fields);
        $this->request->request->replace($result);

        return $this;
    }

    public function upload() {

        if (empty($this->request))
            throw new \Exception(get_class($this) . " expected a \Symfony\Component\HttpFoundation\Request object. You must pass it through setRequest.");

        $result = $this->uploader->uploadRequestFiles($this->request);
        $this->request->request->replace($result);

        return $this;
    }

    public function getRequest() {
        return $this->request;
    }

    public function setRequest(\Symfony\Component\HttpFoundation\Request $request) {
        $this->request = clone $request;

        return $this;
    }

}

?>
