<?php
class ContentPiecesKeywords extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Keywords');
        $this->belongsTo('ContentPieces');
    }
}