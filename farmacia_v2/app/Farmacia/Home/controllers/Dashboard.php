<?php
namespace App\Farmacia\Home;

class Dashboard extends \pan\Kore\Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();
    }

    public function index(){
        $this->view->set('contenido', $this->view->fetchIt('dashboard'));
        $this->view->render();
    }
}
