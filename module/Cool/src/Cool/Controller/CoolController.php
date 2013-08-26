<?php

namespace Cool\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Cool\Db\TableGateway;

class CoolController extends AbstractActionController {

    /**
     * Returns a TableGateway
     *
     * @param  string $table
     * @return TableGateway
     */
    protected function getTable($table) {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $tableGateway = new TableGateway($dbAdapter, $table, new $table);
        $tableGateway->initialize();

        return $tableGateway;
    }



}