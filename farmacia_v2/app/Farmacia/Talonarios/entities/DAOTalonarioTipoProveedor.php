<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonarioTipoProveedor extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_TIPO_PROVEEDOR;
    protected $primary_key = "id_talonario_tipo_proveedor";

    function __construct()
    {
        parent::__construct();
    }

}
