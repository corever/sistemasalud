<?php

/**
* Cosof
* @author Victor Retamal <victor.retamal@cosof.cl>
*/

Class Email{
    
    /**
     *
     * @var Zend_Mail 
     */
    protected $_email;
    
    /**
     *
     * @var Smarty
     */
    protected $_smarty;
    
    /**
     * Constructor
     */
    public function __construct() {
        $tr				= new Zend_Mail_Transport_Sendmail('-fnotificaciones.sumanet@gmail.com');
        $this->_email	= New Zend_Mail('UTF-8');
        $this->_email->setDefaultTransport($tr);
        $this->_email->setReplyTo("noresponder@minsal.cl", "Ministerio de salud");
        
        $this->_smarty					= new Smarty();
        $this->_smarty->template_dir	= APP_PATH ."libs/Helpers/Email/View";
        $this->_smarty->compile_dir		= APP_PATH ."views/templates_c";
        $this->_smarty->cache_dir		= APP_PATH ."views/cache";
        $this->_smarty->config_dir		= APP_PATH ."views/configs";
        
        $this->_smarty->assign("url", HOST . "index.php/");
    }
    
    /**
     * 
     * @param string $email
     * @param string $nombre
     */
    public function to($email, $nombre){
		if(ENVIROMENT != "PROD"){
			$this->_email->addTo("victor.retamal@cosof.cl", "Victor Retamal");
		} else {
			$this->_email->addTo($email, $nombre);
		}
    }
    
    /**
     * 
     * @param string $subject
     */
    public function subject($subject){
        $this->_email->setSubject($subject);
    }
    
    /**
     * 
     * @param string $html
     */
    public function setContent($html){
        $this->_email->setBodyHtml($html);
        $this->_email->setBodyText(strip_tags($html));
    }
    
    /**
     * 
     * @param string $email
     * @param string $nombre
     */
    public function from($email, $nombre){
        $this->_email->setFrom($email, $nombre);
    }
    
    /**
     * 
     * @return type
     */
    public function send(){
       return $this->_email->send();
    }
}