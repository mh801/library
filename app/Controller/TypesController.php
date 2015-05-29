<?php
class TypesController extends AppController {
    public $scaffold = 'admin';
    //public $hasMany = 'Categories';

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }
    
    public function view($id =null){
        Controller::loadModel('Category'); 
        Controller::loadModel('CategoriesTypes');
        
        $this->Type->find('first', array(
        'conditions' => array('id' => $id)));
        
         $cat = $this->CategoriesTypes->find('list', 
                                        array(
                                        'conditions' => array('type_id' => $id),
                                         'fields' =>'category_id')
                                         );
        foreach($cat as $c){
            
            $category_ids[] = $c; 
        }
        $category_ids = implode(',',$category_ids);
        
        //$audience = $this->Audience->query("SELECT name FROM audiences WHERE id IN (".$audience_ids.");");
        
        $this->set('category',$this->Category->query("SELECT id,name FROM categories WHERE id IN (".$category_ids.");"));
        $this->set('type',$this->Type->find('first', array(
        'conditions' => array('id' => $id))));
        //var_dump(compact($this->Audience));                      
    }    
    
    
    public function add(){
    	Controller::loadModel('Category'); 
	 	$this->set('categories',$this->Category->find('all'));
        Controller::loadModel('Audience'); 
	 	$this->set('audiences',$this->Audience->find('all'));
        
		//$this->set('Audience') = $this->Audience;

	}
    
	public function post($id=null){
        Controller::loadModel('CategoriesTypes'); 
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->Type->create();
            $this->CategoriesTypes->create();
          //  $date = now();
          //  $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
            $this->Type->modified_at = date('Y-m-d H:i:s');
            if ($this->Type->save($this->data)) {                     
                if ($this->CategoriesTypes) {
                    $d2['type_id'] =$this->Type->id;
                    $d2['category_id'] =$this->data['Category'];                                        
                    $this->CategoriesTypes->save($d2);
                    $this->Session->setFlash(__('The Category Type has been saved.',true));
                    $this->redirect(array('action'=>'view',$this->Type->id));
                    
                }else{
                    $this->Session->setFlash(__('The Category Type could not be saved. Please, try again.'),true);
                }
                
            }
            else {
                $this->Session->setFlash(__('The Category Type could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Type->read(null, $id);
        }

	}
    
    public function filterbycategory($id=null){
        $this->autoRender = false;
        $id = $_GET['id'];
        $res = '<option value="0">All</option>';
        if($id != 0){
            Controller::loadModel('CategoriesTypes');

            $tid = $this->CategoriesTypes->find('list', 
                                            array(
                                            'conditions' => array('category_id' => $id),
                                             'fields' =>'type_id')
                                             );
            
            
            if(count($tid)>0) {
                foreach($tid as $t){

                    $type_ids[] = $t; 
                }
                $type_ids = implode(',',$type_ids);               
                   $types = $this->Type->query("SELECT name,id FROM types WHERE id IN (".$type_ids.");");
                
                

                foreach($types as $type){                             
                 $res .= '<option value="'.$type['types']['id'].'">'.$type['types']['name'].'</option>';

                }
               
            }
        }else{
            $types = $this->Type->query("SELECT name,id FROM types WHERE 1;");           

            foreach($types as $type){             
                 $res .= '<option value="'.$type['types']['id'].'">'.$type['types']['name'].'</option>';

            }
        }
        echo $res;         
    }    
}