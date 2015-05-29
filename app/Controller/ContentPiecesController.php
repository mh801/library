<?php
class ContentPiecesController extends AppController {
    public $scaffold = 'admin';
/*
 (SELECT l.url FROM content_pieces_links AS cpl
                INNER JOIN links AS l
                    ON cpl.link_id = l.id
                    WHERE cpl.content_piece_id = cp.id
                ) AS links
                
,p.description as partner 


*/

public function index() {
        //print_r($_GET['end_date']);
        Controller::loadModel('Category'); 
        Controller::loadModel('Keyword');
        Controller::loadModel('Type');
        Controller::loadModel('Audience');
        Controller::loadModel('Partner');
        //$this->set('partners',$this->Partner->query('SELECT * FROM partners ORDER BY description ASC')); // make sort asc
        $this->set('partners',$this->Partner->find('all', array('order'=>array('`Partner`.`description`' => 'ASC'))));
        $this->set('audiences',$this->Audience->find('all'));
        $this->set('categories',$this->Category->find('all'));
        $this->set('types',$this->Type->find('all'));    
    // This fetches Leaders, and their associated Followers
    //$all = $this->ContentPiece->find('all');
       // var_dump($_GET['searchwords']);
        if(isset($_GET['searchwords'])){  
            if($_GET['searchwords'] != 'Search for content by name or keyword'){
                $q = $_GET['searchwords'];
            }
        }    
    
        if(isset($_GET['start_date']) && $_GET['start_date'] !=''){
            $sdate =  $_GET['start_date'];
            $sd = date('Y-m-d H:i:s', strtotime($sdate));
        }
        if(isset($_GET['end_date']) && $_GET['end_date'] !=''){
            $edate =  $_GET['end_date'];
            $ed = date('Y-m-d 23:59:59', strtotime($edate));
        }

        
    $sql ='SELECT  distinct cp.id,cp.modified_at,cp.name,cp.description,cp.created_at,cat.id as category_id,cat.name as cat,t.name as type,t.id as type_id,f.file_path as path,f.type as file_type,p.description as partner, a.name as audience    
                FROM content_pieces as cp
                    INNER JOIN content_pieces_categories cpc
                        ON cpc.content_piece_id = cp.id
                    INNER JOIN categories cat
                        ON cpc.category_id = cat.id
                    INNER JOIN content_pieces_types cpt
                        ON cpt.content_piece_id = cp.id
                    INNER JOIN types t
                        ON cpt.type_id = t.id      
                    INNER JOIN content_pieces_files cpf
                        ON cpf.content_piece_id = cp.id
                    INNER JOIN files f
                        ON cpf.file_id = f.id
                    LEFT OUTER JOIN content_pieces_partners cpp
                        ON cpp.content_piece_id = cp.id
                    LEFT OUTER JOIN partners p
                        ON cpp.partner_id = p.id';
        
        
            $sql .=' INNER JOIN audiences_categories ac
                        ON ac.category_id = cat.id
                     INNER JOIN audiences a
                        ON a.id = ac.audience_id';
        if(isset($_GET['audience']) && $_GET['audience'] !='0'){
                        $sql .= ' AND a.id ="'.$_GET['audience'].'"';
        }
        
        if(isset($q)){
                    $sql .= ' INNER JOIN content_pieces_keywords cpk 
                                ON cpk.content_piece_id = cp.id 
                              INNER JOIN keywords k 
                                ON k.id = cpk.keyword_id';
                    }
               $sql .=' WHERE 1';
        if(isset($sd) && isset($ed)){
             $sql .=' AND (cp.modified_at > "'.$sd.'" AND cp.modified_at < "'.$ed.'")';
        }
        
        if(isset($q)){
            $sql .= ' AND (cp.name LIKE "%' .$q. '%" OR cp.description LIKE "%' .$q. '%" OR cat.name LIKE "%' .$q. '%" OR t.name LIKE "%' .$q. '%" OR p.description LIKE "%' .$q. '%" OR k.keyword LIKE "%' .$q. '%")';
            
        }
        
        if(isset($_GET['partner']) && $_GET['partner'] !=''){
           $sql .=' (AND (p.id ="'.$_GET['partner'].'"))';
        }
        
        if(isset($_GET['category']) && $_GET['category'] !='0'){
           $sql .=' AND (cat.id ="'.$_GET['category'].'")';
        }
        
        if(isset($_GET['phone_number']) && $_GET['phone_number'] !='' && $_GET['phone_number'] != 'Enter a phone number'){
           $sql .=' AND (cp.phone_number ="'.$_GET['phone_number'].'")';
        }
        
        if(isset($_GET['type']) && $_GET['type'] !=''){
           $sql .=' AND (t.id ="'.$_GET['type'].'")';
        }
    

        $sql .=' ORDER BY cp.name';
           
        $this->set('pieces',$this->ContentPiece->query($sql));
        if(isset($q)){
            $this->set('search_criteria',$q);    
        }
       
        $ksql = 'select keyword, count(*) as weight from keywords group by keyword ORDER BY weight DESC LIMIT 10';
        $this->set('cloudwords',$this->Keyword->query($ksql));
    //var_dump($this->ContentPiece);
        
           }
    public function view($id=null){
        
    }
    
    public function add(){        
         $this->layout = 'admin';
        Controller::loadModel('Category'); 
        Controller::loadModel('Type');
        Controller::loadModel('Audience');
        Controller::loadModel('Partner');
        //$this->set('partners',$this->Partner->find('all'));
        $this->set('partners',$this->Partner->find('all', array('order'=>array('`Partner`.`description`' => 'ASC'))));
        $this->set('audiences',$this->Audience->find('all'));
        $this->set('categories',$this->Category->find('all'));
        $this->set('types',$this->Type->find('all'));
        
    }
    
    
    public function post($id=null){
        Controller::loadModel('ContentPiecesFiles');    
        Controller::loadModel('File'); 
        Controller::loadModel('Category'); 
        Controller::loadModel('Type');  
        
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->ContentPiece->create();
          
            if ($this->ContentPiece->save($this->data)) {                     
              
            $this->Session->setFlash(__('The Content Piece has been saved.',true));
            $this->redirect(array('action'=>'view',$this->ContentPiece->id));
                
                
            }
            else {
                $this->Session->setFlash(__('The Content Piece could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->ContentPiece->read(null, $id);
        }

	} 
    
    public function ajaxpost($id=null){
        
        $this->autoRender = false;
        
        
        //Controller::loadModel('ContentPiecesAudiences'); 
        Controller::loadModel('ContentPiecesCategories'); 
        Controller::loadModel('ContentPiecesTypes'); 
        Controller::loadModel('ContentPiecesKeywords');
        Controller::loadModel('Keyword');
         Controller::loadModel('ContentPiecesPartners');
        Controller::loadModel('ContentPiecesLinks');
        Controller::loadModel('Link');
        //Controller::loadModel('ContentPiecesFiles'); 
        Controller::loadModel('File'); 
 
        
        if (!empty($this->data)) {                
            // save the data (auto-handles habtm save)
            $this->ContentPiece->create();
            
            
            if ($this->ContentPiece->save($this->data)) { 
            
                //save the category    
              $this->ContentPiecesCategories->create();
              if ($this->ContentPiecesCategories) {
                    $d2['content_piece_id'] =$this->ContentPiece->id;
                    $d2['category_id'] =$this->data['Category'];                                        
                    $this->ContentPiecesCategories->save($d2);                            
                }
                
            if($this->data['Partner'] != null && $this->data['Partner'] != ''){
                //save the partner    
              $this->ContentPiecesPartners->create();
              if ($this->ContentPiecesPartners) {
                    $d1['content_piece_id'] =$this->ContentPiece->id;
                    $d1['partner_id'] =$this->data['Partner'];                                        
                    $this->ContentPiecesPartners->save($d1);                                              
                }                
            }
                //save the type
              $this->ContentPiecesTypes->create();
              if ($this->ContentPiecesTypes) {
                    $d3['content_piece_id'] =$this->ContentPiece->id;
                    $d3['type_id'] =$this->data['Type'];                                        
                    $this->ContentPiecesTypes->save($d3);
                                                      
                }                
                 echo $this->ContentPiece->id;
                
              //add keywords
             $keyword = explode(',',$this->data['ContentPiece']['Keyword']);
                
                    if($this->data['ContentPiece']['Keyword'] !=''){
                       foreach($keyword as $key=>$val){
                            $this->Keyword->create();
                            $k['keyword'] = $val;
                            if ($this->Keyword->save($k)) {                     
                                $this->ContentPiecesKeywords->create();
                                if ($this->ContentPiecesKeywords) {
                                    $d4['content_piece_id'] =$this->ContentPiece->id;
                                    $d4['keyword_id'] =$this->Keyword->id;                                        
                                    $this->ContentPiecesKeywords->save($d4);
                                }
                            }     
                        }
                    }
                
                //add links
                
             $link = explode(',',$this->data['ContentPiece']['Link']);
                
                    if($this->data['ContentPiece']['Link'] !=''){
                       foreach($link as $key=>$val){
                            $this->Link->create();
                            $l['url'] = $val;
                            if ($this->Link->save($l)) {                     
                                $this->ContentPiecesLinks->create();
                                if ($this->ContentPiecesLinks) {
                                    $d5['content_piece_id'] =$this->ContentPiece->id;
                                    $d5['link_id'] =$this->Link->id;                                        
                                    $this->ContentPiecesLinks->save($d5);
                                }
                            }     
                        }
                    }                                                 
            }
            else {
                $this->Session->setFlash(__('The Content Piece could not be saved. Please, try again.'),true);
            }
        }
        if (empty($this->data)) {
            $this->data = $this->ContentPiece->read(null, $id);
        }

	}      
    
}