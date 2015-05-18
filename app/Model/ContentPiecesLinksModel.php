<?php
class ContentPiecesLinks extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Link');
        $this->belongsTo('ContentPiece');
    }
}