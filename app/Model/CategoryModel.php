<?php
class Category extends AppModel {
    var $name ='Category';
        $this->belongsToMany('Audience', [
            'through' => 'AudiencesCategories',
        ]);
    /*
    public $belongsToMany = array(
        'Audience' =>
            array(
                'className' => 'Audience',
                'joinTable' => 'audiences_categories',
                'foreignKey' => 'category_id',
                'associationForeignKey' => 'audience_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''
            )
    );
    */
}