<?php
namespace Haven\Bundle\SecurityBundle\Lib;

use Haven\Bundle\CoreBundle\Lib\Mailing\BaseMailMessage;

/**
 * Description of PasswordResetMailMessage
 *  Courriel utiliser pour l'initialisation du mot de passe
 * @author themaster
 */
class PasswordResetMailMessage extends BaseMailMessage {

    public function __construct($env = 'dev') {
        parent::__construct($env);
        $this->setFrom(array("/default/" => 'info@evocatio.com' ,
             "/haven.com/" => "sig@stephanchampagne.com"));
         $this->setDestinataire(array("sc@evocatio.com" => array()));
    }

    protected function getDestinataireData() {
        if (!isset($this->_Destinataire[$this->getCurrentTo()]["/%message%/"]))
            $this->_Destinataire[$this->getCurrentTo()]["/%message%/"] = null;
        return parent::getDestinataireData();
    }

    public function setMessage($message) {
        $this->_Destinataire[$this->getCurrentTo()]["/%message%/"] = $message;
    }
    public function setParameters($params = array()){
        foreach ($params as $name => $value){
            $this->_Destinataire[$this->getCurrentTo()]["/%".$name."%/"] = $value;
        }
    }
    
    public function addParam($name, $value){
        $this->_Destinataire[$this->getCurrentTo()]["/%".$name."%/"] = $value;
    }
}