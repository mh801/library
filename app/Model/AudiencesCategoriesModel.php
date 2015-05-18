<?php
class AudiencesCategories extends AppModel {
    
    public function initialize(array $config)
    {
        $this->belongsTo('Audiences');
        $this->belongsTo('Categories');
    }
}