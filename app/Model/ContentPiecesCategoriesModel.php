<?php
class ContentPiecesCategories extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Category');
        $this->belongsTo('ContentPiece');
    }
}