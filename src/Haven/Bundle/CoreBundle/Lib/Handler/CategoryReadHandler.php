<?php

namespace Haven\Bundle\CoreBundle\Lib\Handler;

class CategoryReadHandler extends ReadHandler {

    protected function getDefaultEntityClass() {
        return "Haven\Bundle\CoreBundle\Entity\Category";
    }

}

?>
