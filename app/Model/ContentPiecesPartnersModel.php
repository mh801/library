<?php
class ContentPiecesPartners extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Partner');
        $this->belongsTo('ContentPiece');
    }
}