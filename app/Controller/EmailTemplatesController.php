<?php
    class EmailTemplatesController extends AppController {
        var $name = 'EmailTemplates';        
        var $uses = array("EmailTemplate");

        public function beforeFilter() {
            parent::beforeFilter();
            if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
            }else{
                $this->Auth->allow();
            }
        }

        public function admin_edit($id=null){           
            if (!empty($this->request->data)) {
                if ($this->EmailTemplate->save($this->request->data)) {
                    $this->Session->setFlash('<div class="alert alert-block alert-info"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Email template has been updated successfully.</h4></div>');
                } else {
                    $this->Session->setFlash('<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Email template couldnot be updated.</h4></div>');
                }
            }
            //To get the draft name list
            $draftNameList = $this->EmailTemplate->find('list', array('fields' => array('EmailTemplate.id', 'EmailTemplate.draft_name'), 'order' => 'EmailTemplate.id ASC'));

            $this->request->data = array();
            if(!empty($id)){
                $this->request->data = $this->EmailTemplate->findById($id);
            }
            
            $this->set(compact('draftNameList'));
        }
  
    }
?>