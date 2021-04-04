<?php
namespace App\Notificaciones\Home;

class MisNotificaciones extends \pan\Kore\Controller {

  public function __construct()
  {
    parent::__construct();
    $this->session->isValidate();
  }

  public function index(){

    $this->view->addJS('notificaciones.js');
    $this->view->addJS('Notificaciones.cargarGrilla()');

    $this->view->set('contenido', $this->view->fetchIt('index'));
    $this->view->render();
  }
  
  public function cargarGrilla(){

    $this->view->set('arrDatos',  array());
    $this->view->render("grilla");	
  }

}
