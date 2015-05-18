<?php
class ContentPiecesAudiences extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Audiences');
        $this->belongsTo('ContentPieces');
    }
}