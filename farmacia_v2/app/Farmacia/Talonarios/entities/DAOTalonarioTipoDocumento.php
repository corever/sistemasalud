<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonarioTipoDocumento extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_TIPO_DOCUMENTO;
    protected $primary_key = "id_talonario_tipo_documento";

    function __construct()
    {
        parent::__construct();
    }

}
