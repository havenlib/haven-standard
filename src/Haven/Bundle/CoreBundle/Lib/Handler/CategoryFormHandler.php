<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

class CategoryFormHandler extends FormHandler {

    protected function getDefaultTypeClass() {
        return "Haven\Bundle\CoreBundle\Form\CategoryType";
    }
   
}

?>
