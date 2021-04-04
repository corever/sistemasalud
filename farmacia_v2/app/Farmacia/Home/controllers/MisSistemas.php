<?php
namespace App\Farmacia\Home;

class MisSistemas extends \pan\Kore\Controller {

    private $_DAOUsuarioModulo;

    public function __construct()
    {
        parent::__construct();
        $this->session->isValidate();
     
        $this->_DAOUsuarioModulo    = new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioModulo();
        
    }


    public function index(){
        
        $idUsuario  = $_SESSION[\Constantes::SESSION_BASE]['id'];
        $arrModulo  = $this->_DAOUsuarioModulo->getListaUsuario($idUsuario);
        
        $this->view->addJS('bitacora.js', 'app/_FuncionesGenerales/BitacoraBase/assets/js');
        $this->view->set('arrModulo', $arrModulo);
        $this->view->set('contenido', $this->view->fetchIt('missistemas'));
        
        $this->view->render();
        
    }
    
    /**
	* Descripción : Entrar a Modulo
	* @author David Guzmán <david.guzman@cosof.cl> 02/06/2020
    */
    public function entrarModulo(){
        $params     = $this->request->getParametros();
        $_SESSION[\Constantes::SESSION_BASE]['idModuloSelecionado'] = $params['id_modulo'];
        echo json_encode(array("correcto"=>true));
	}
}
