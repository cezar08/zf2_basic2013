<?php

namespace Admin\Model;

use Cool\Db\Entity;

class Usuario extends Entity {

    protected $tableName = "Usuario";

    protected $login;
    protected $senha;
    protected $perfil;

 

}