<?php
class FilesController extends AppController {    
    
  

    
    public $scaffold = 'admin';
    //public $destination = dirname(__FILE__) . '../webroot/uploads/';
    
 
    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }
    
    public function index() {
    // This fetches Leaders, and their associated Followers
    $all = $this->File->find('all');
    var_dump($all);
	}

    
    public function view($id =null){
        
        $this->File->find('first', array(
        'conditions' => array('id' => $id)));
        
        $this->set('file',$this->File->find('first', array(
        'conditions' => array('id' => $id))));
        //var_dump(compact($this->File));                      
    }        
    
    public function add(){
    
    
    }
    
    public function post($id=null){
        
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->File->create();

            extract($this->data['file']['file']);
            
            if($size && !$error){
                $this->File->name = $name;
                $file_path = WWW_ROOT . DS . 'uploads' . DS . $name;
                move_uploaded_file($tmp_name, $file_path);
                $this->File->file_path = DS . 'uploads' . DS . $name;
                $this->File->type = $type;
                $this->File->is_active = 1;
            }else{
                $this->set('error',$error);
            }
            
            
            if ($this->File->save($this->File)) {                  
                
                Controller::loadModel('ContentPiecesFiles');
                 
                $this->ContentPiecesFiles->create();
                if ($this->ContentPiecesFiles) {
                    //var_dump ($this->data['file']['ContentPiece']);
                    $d2['content_piece_id'] =$this->data['file']['ContentPiece'];
                    $d2['file_id'] =$this->File->id;                                        
                    $this->ContentPiecesFiles->save($d2);
                                              
                }                
                
                    $this->Session->setFlash(__('The File has been saved.',true));
                    $this->redirect(array('action'=>'view',$this->File->id));
                
            }
            else {
                $this->Session->setFlash(__('The File could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->File->read(null, $id);
        }
    }
    
    public function ajaxpost($id=null){
       
        $this->autoRender = false;
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->File->create();

            extract($this->data['file']['file']);
            
            if($size && !$error){
                $this->File->name = $name;
                $file_path = WWW_ROOT . DS . 'uploads' . DS . $name;
                move_uploaded_file($tmp_name, $file_path);
                $this->File->file_path = DS . 'uploads' . DS . $name;
                $this->File->type = $type;
                $this->File->is_active = 1;
            }            
            
            
            if ($this->File->save($this->File)) {  
                Controller::loadModel('ContentPiecesFiles');
                                //save the category    
                $this->ContentPiecesCategories->create();
                if ($this->ContentPiecesCategories) {
                    echo $this->data;
                    $d2['content_piece_id'] =$this->data['ContentPiece'];
                    $d2['file_id'] =$this->File->id;                                        
                    $this->ContentPiecesFiles->save($d2);
                                              
                }
                
            }
            else {
                $this->Session->setFlash(__('The File could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->File->read(null, $id);
        }
    }
    
    }
    
