<?php
class KeywordsController extends AppController {
    public $scaffold = 'admin';

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }
    public function index() {
    // This fetches Leaders, and their associated Followers
    $all = $this->Keyword->find('all');
	}
    
    
    public function add(){
	}
    
    public function post($id=null){
        $this->autoRender = false;
        if (!empty($this->data)) {  
            
            // save the data (auto-handles habtm save)
            $keyword = explode(',',$this->data['Keyword']['keyword']);
            
            foreach($keyword as $key=>$val){
                $this->Keyword->create();
                $k['keyword'] = $val;
                if ($this->Keyword->save($k)) {                     


                }
                else {
                    $this->Session->setFlash(__('The Keyword could not be saved. Please, try again.'),true);
                }
            }
            $this->Session->setFlash(__('The Keywords has been saved.',true));
            $this->redirect(array('action'=>'view',$this->Keyword->id));
        }
        if (empty($this->data)) {
            $this->data = $this->Keyword->read(null, $id);
        }        
        
    }
    
    public function keywords($id=null){
        
        $keywords =$this->Keyword->query('SELECT k.keyword FROM content_pieces_keywords AS cpk
                INNER JOIN keywords AS k
                    ON cpk.keyword_id = k.id
                    WHERE cpk.content_piece_id ='.$id.';');
        
        return $keywords;
    }
}