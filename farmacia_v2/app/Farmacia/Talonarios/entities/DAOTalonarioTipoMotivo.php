<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonarioTipoMotivo extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_TIPO_MOTIVO;
    protected $primary_key = "id_talonario_tipo_motivo";

    function __construct()
    {
        parent::__construct();
    }
}
