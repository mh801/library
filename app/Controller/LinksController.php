<?php
class LinksController extends AppController {
    public $scaffold = 'admin';

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }

    public function index() {
    // This fetches Leaders, and their associated Followers
    $all = $this->Link->find('all');
   // var_dump($all);
	}
    
    public function add(){
    }
    public function post($id=null){
        $this->autoRender = false;
        if (!empty($this->data)) {  
            
            // save the data (auto-handles habtm save)
            $link = explode(',',$this->data['Link']['url']);
            
            foreach($link as $key=>$val){
                $this->Link->create();
                $k['url'] = $val;
                if ($this->Link->save($k)) {                     


                }
                else {
                    $this->Session->setFlash(__('The Audience could not be saved. Please, try again.'),true);
                }
            }
            $this->Session->setFlash(__('The Keywords has been saved.',true));
            $this->redirect(array('action'=>'view',$this->Link->id));
        }
        if (empty($this->data)) {
            $this->data = $this->Keyword->read(null, $id);
        }        
        
    }
    
        public function links($id=null){
        
        $links =$this->Link->query('SELECT l.url FROM content_pieces_links AS cpl
                INNER JOIN links AS l
                    ON cpl.link_id = l.id
                    WHERE cpl.content_piece_id ='.$id.';');
        
        return $links;
    }
    
}