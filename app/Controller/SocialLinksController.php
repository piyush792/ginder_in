<?php
    Class SocialLinksController extends AppController {
        var $name = "SocialLinks";
        var $uses = array("SocialLink");

        public function beforeFilter() {
            parent::beforeFilter();
            if(isset($this->params['admin'])){
            }else{
                $this->Auth->allow("index");
            }
        }

        public function admin_index($id=1)
        {
            
            $social_link_detail = $this->SocialLink->findById($id);
            if ($this->request->is('post') && !empty($this->request->data)) {

                // echo "<pre>";
                // print_r($this->request->data); exit;

                $this->SocialLink->id = $id;

                $fieldList = array('facebook', 'twitter', 'pinterest', 'instagram', 'facebook_status', 'twitter_status', 'pinterest_status', 'instagram_status');

                $this->SocialLink->save($this->request->data, false, $fieldList);
            }else{
                $this->request->data = $social_link_detail;
            }
        }
        
    }
?>
