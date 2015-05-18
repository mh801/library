<?php
class ContentPiecesTypes extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Type');
        $this->belongsTo('ContentPiece');
    }
}