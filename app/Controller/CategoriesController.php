<?php
class CategoriesController extends AppController {
    public $scaffold = 'admin';
    public $helpers = array('Form', 'Html', 'Session');
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }
    
    public function index() {
    // This fetches Leaders, and their associated Followers
    $this->set('all', $this->Category->find('all'));    
	}

    public function view($id =null){
        Controller::loadModel('Audience'); 
        Controller::loadModel('AudiencesCategories');
        Controller::loadModel('Type'); 
        Controller::loadModel('CategoriesTypes');
        $this->Category->find('first', array(
        'conditions' => array('id' => $id)));
        
         $ad = $this->AudiencesCategories->find('list', 
                                        array(
                                        'conditions' => array('category_id' => $id),
                                         'fields' =>'audience_id')
                                         );
        if(count($ad)>0){
            foreach($ad as $aud){

                $audience_ids[] = $aud; 
            }
            $audience_ids = implode(',',$audience_ids);
            $this->set('audience',$this->Audience->query("SELECT name,id FROM audiences WHERE id IN (".$audience_ids.");"));
        }
        
        
         $type = $this->CategoriesTypes->find('list', 
                                        array(
                                        'conditions' => array('category_id' => $id),
                                        'fields' =>'type_id')
                                         );
        
        if(count($type)>0){
            foreach($type as $t){

                $t_ids[] = $t; 
            }
            var_dump($t_ids);
            $type_ids = implode(',',$t_ids);
            echo $type_ids;
            $this->set('types',$this->Type->query("SELECT name,id FROM types WHERE id IN (".$type_ids.");"));
        }        
        
        //$audience = $this->Audience->query("SELECT name FROM audiences WHERE id IN (".$audience_ids.");");
        
       
        $this->set('category',$this->Category->find('first', array(
        'conditions' => array('id' => $id))));
        //var_dump(compact($this->Audience));                      
    }

	public function add(){
    	Controller::loadModel('Audience'); 
	 	$this->set('audiences',$this->Audience->find('all'));
        
		//$this->set('Audience') = $this->Audience;

	}

	public function post($id=null){
        Controller::loadModel('AudiencesCategories'); 
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->Category->create();
            $this->AudiencesCategories->create();
          //  $date = now();
          //  $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
            $this->Category->modified_at = date('Y-m-d H:i:s');
            if ($this->Category->save($this->data)) {                     
                if ($this->AudiencesCategories) {
                    $d2['category_id'] =$this->Category->id;
                    $d2['audience_id'] =$this->data['Audience'];                                        
                    $this->AudiencesCategories->save($d2);
                    $this->Session->setFlash(__('The Category has been saved.',true));
                    $this->redirect(array('action'=>'view',$this->Category->id));
                    
                }else{
                    $this->Session->setFlash(__('The Category could not be saved. Please, try again.'),true);
                }
                
            }
            else {
                $this->Session->setFlash(__('The Category could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Category->read(null, $id);
        }

	}

    
    public function filterbyaudience($id=null){
        $this->autoRender = false;
        $id = $_GET['id'];
        $res = '<option value="0">All</option>';
        if($id != 0){
            Controller::loadModel('AudiencesCategories');

            $cid = $this->AudiencesCategories->find('list', 
                                        array(
                                        'conditions' => array('audience_id' => $id),
                                         'fields' =>'category_id')
                                         );                        
            if(count($cid)>0) {
                foreach($cid as $c){

                    $cat_ids[] = $c; 
                }
                $cat_ids = implode(',',$cat_ids);                  
                   $cats = $this->Category->query("SELECT name,id FROM categories WHERE id IN (".$cat_ids.");");
                
                

                foreach($cats as $cat){             
                   
                    $res .= '<option value="'.$cat['categories']['id'].'">'.$cat['categories']['name'].'</option>';

                }
               
            }
        }else{
            $cats = $this->Category->query("SELECT name,id FROM categories WHERE 1;");           

            foreach($cats as $cat){             
                 $res .= '<option value="'.$cat['categories']['id'].'">'.$cat['categories']['name'].'</option>';
            }
        }
        echo $res;         
    }  
}