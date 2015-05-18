<?php
class CategoriesTypes extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Categories');
        $this->belongsTo('Types');
    }
}