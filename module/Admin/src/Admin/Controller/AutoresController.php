<?php

namespace Admin\Controller;

use Cool\Controller\CoolController;
use Zend\View\Model\ViewModel;

/**
 * Controller que gerencia os autores
 * @package Admin
 * @group Controller
 * @author Eu <eu@eu.com>
 * 
 */
class AutoresController extends CoolController {

    public function indexAction() {  
        $autores = $this->getTable('\Admin\Model\Autor')->fetchAll()->toArray();  
        return new ViewModel(array(
            'autores' => $autores,
      
        ));
    }

    public function addAction() {
        $request = $this->getRequest();
        $form = new \Admin\Form\Autor();
    
        if ($request->isPost()) {
            $values = $request->getPost();          
            unset($values['submit']);
            $Autor = new \Admin\Model\Autor();
            $Autor->setData($values);
            $id = $this->getTable('\Admin\Model\Autor')->save($Autor);            
            if (!$id)
                die('Erro');
            else {
                return $this->redirect()->toUrl('/admin/autores');
            }
        }

        return new ViewModel(array(
            'form' => $form)
        );
    }

    public function updateAction() {
        $id = $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $form = new \Admin\Form\Autor();
            $request = $this->getRequest();
            $dadosAutor = $this->getTable('\Admin\Model\Autor')->get($id);
        if ($request->isPost()) {
            $values = $request->getPost();
           
            unset($values['submit']);
            $Autor = new \Admin\Model\Autor();
            $Autor->setData($values);
            $id = $this->getTable('\Admin\Model\Autor')->save($Autor);
            
            if (!$id)
                die('Erro');
            else {
                return $this->redirect()->toUrl('/admin/autores');
            }
        }
            
            
            $form->populateValues($dadosAutor->toArray());
            return new ViewModel(array('form' => $form));
        } else {
            die("Passe um Id");
        }
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {            
            $id = $this->getTable('\Admin\Model\Autor')->delete($id);
            return $this->redirect()->toUrl('/admin/autores');
        }
        die('Passe o Id');
    }

}
