<?php
class ContentPiecesFiles extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('File');
        $this->belongsTo('ContentPiece');
    }
}