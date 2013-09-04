<?php

namespace Haven\Bundle\CoreBundle\Lib\Mailing;

/**
 * Description of DossierAcceptMailMessage
 *
 * @author lbreleur
 */
class MailMessage extends \Swift_Message {

//    public function __construct($env = 'dev') {
//        parent::__construct($env);
//        $this->setFrom(array());
//    }
//
//    protected function getDestinataireData() {
//        if (!isset($this->_Destinataire[$this->getCurrentTo()]["/%message%/"]))
//            $this->_Destinataire[$this->getCurrentTo()]["/%message%/"] = null;
//        return parent::getDestinataireData();
//    }
//
//    public function setMessage($message) {
//        $this->_Destinataire[$this->getCurrentTo()]["/%message%/"] = $message;
//    }
//
//    public function setParameters($params = array()) {
//        foreach ($params as $name => $value) {
//            $this->_Destinataire[$this->getCurrentTo()]["/%" . $name . "%/"] = $value;
//        }
//    }
//
//    public function addParam($name, $value) {
//        $this->_Destinataire[$this->getCurrentTo()]["/%" . $name . "%/"] = $value;
//    }
}