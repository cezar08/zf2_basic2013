<?php

namespace Cool\Db;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class TableGateway extends AbstractTableGateway {

    /**
     * Chave primária
     *
     * @var string
     */
    protected $pk;

    /**
     * ObjectPrototype
     * @var stdClass
     */
    protected $objectPrototype;

    public function __construct(Adapter $adapter, $table, $objectPrototype) {
        $this->adapter = $adapter;
   
        $this->table = $objectPrototype->getTableName();
        $this->objectPrototype = $objectPrototype;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype($objectPrototype);
    }

    public function initialize() {
        parent::initialize();
        $this->pk = $this->objectPrototype->pk; //pega a pk de nossa entidade
        if (!is_string($this->pk)) { //se não for declarada pk ela será id
            $this->pk = 'id';
        }
    
    }

    public function fetchAll($columns = null, $where = null,  $order = null, $limit = null, $offset = null) {
        $select = new Select();
        $select->from($this->getTable());

        if ($columns)
            $select->columns($columns);

        if ($where)
            $select->where($where);
            
        if ($order)
            $select->order($order); 

        if ($limit)
            $select->limit((int) $limit);

        if ($offset)
            $select->offset((int) $offset);

        return $this->selectWith($select);
    }

    public function get($id) {
        $id = (int) $id;
        
        $rowset = $this->select(array($this->pk => $id));
        $row = $rowset->current();
        if (!$row) {
            die("Não exixste ID $id");
        }
        return $row;
    }

    public function save($object) {

        $data = $object->getData();

        $id = (int) isset($data[$this->pk]) ? $data[$this->pk] : 0;
        
        if ($id == 0) {

            if ($this->insert($data) < 1)
                die("Erro ao inserir");

            $object->id = $this->lastInsertValue;
        } else {
            
            if (!$this->get($id))
                die('Id não existe');
          
            if ($this->update($data, array($this->pk => $id)) < 1)
                    
                die("Erro ao atualizar");
        }

        return $object;
    }

    public function delete($id) {
        return parent::delete(array($this->pk => $id));
    }

}
