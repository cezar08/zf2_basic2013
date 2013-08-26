<?php

namespace Admin\Model;

use Cool\Db\Entity;

class Autor extends Entity {

    protected $tableName = "Autor";
    protected $pk = 'id_autor';
    protected $nome;
    protected $sobrenome;

}

?>
