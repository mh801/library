<?php
class ContentPiece extends AppModel {
    public $hasOne = 'File';
    
    public function getLinks($id=null){
        $links = $this->query('
            SELECT l.url FROM content_pieces_links cpl
                INNER JOIN links l
                ON cpl.link_id = l.id
             WHERE cpl.content_piece_id = '. $id . ';
        ');
        return $links;
    }
}