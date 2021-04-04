<?php

namespace App\Farmacia\Talonarios\Entity;

class DAOTalonarioEstado extends \pan\Kore\Entity
{

    protected $table       = TABLA_TALONARIO_ESTADO;
    protected $primary_key = "id_talonario_estado";

    function __construct()
    {
        parent::__construct();
    }
}
