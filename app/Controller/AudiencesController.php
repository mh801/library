<?php
class AudiencesController extends AppController {
    public $scaffold = 'admin';
    //public $hasMany = 'Categories';
      function beforeFilter() {
    parent::beforeFilter();
        $this->layout = 'admin';
  }
    public function index(){
    	var_dump($this->Audience->find('list')); 
	}
    
    public function view($id =null){
        Controller::loadModel('Category'); 
        Controller::loadModel('AudiencesCategories');
        
        $this->Audience->find('first', array(
        'conditions' => array('id' => $id)));
        
         $cat = $this->AudiencesCategories->find('list', 
                                        array(
                                        'conditions' => array('audience_id' => $id),
                                         'fields' =>'category_id')
                                         );
        if(count($cat)>0){
        foreach($cat as $c){
            
            $category_ids[] = $c; 
        }
        $category_ids = implode(',',$category_ids);
        
        //$audience = $this->Audience->query("SELECT name FROM audiences WHERE id IN (".$audience_ids.");");
        
        $this->set('category',$this->Category->query("SELECT name,id FROM categories WHERE id IN (".$category_ids.");"));
        }
        $this->set('audience',$this->Audience->find('first', array(
        'conditions' => array('id' => $id))));
        //var_dump(compact($this->Audience));                      
    }    
    
    
    public function all(){    
        
       // $this->set('audience',$this->Audience->find('all'));
        
        $this->paginate = array('all');
        $audience = $this->paginate();
        $this->set(compact('audience'));
        /*
         $cat = $this->AudiencesCategories->find('list', 
                                        array(
                                        'conditions' => array('audience_id' => $id),
                                         'fields' =>'category_id')
                                         );
        
        foreach($cat as $c){
            
            $category_ids[] = $c; 
        }
        $category_ids = implode(',',$category_ids);
        
        //$audience = $this->Audience->query("SELECT name FROM audiences WHERE id IN (".$audience_ids.");");
        
        $this->set('category',$this->Category->query("SELECT name FROM categories WHERE id IN (".$category_ids.");"));
        $this->set('audience',$this->Audience->find('first', array(
        'conditions' => array('id' => $id))));
        */
    }        
    
    public function add(){


	}
    
    public function post($id=null){
       
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->Audience->create();
          
            if ($this->Audience->save($this->data)) {                     
              
                    $this->Session->setFlash(__('The Audience has been saved.',true));
                    $this->redirect(array('action'=>'view',$this->Audience->id));
                
            }
            else {
                $this->Session->setFlash(__('The Audience could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Audience->read(null, $id);
        }

	}    
}