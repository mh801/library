<?php
class Audience extends AppModel {
    var $name ='Audience';
    $this->belongsToMany('Category', [
            'through' => 'AudiencesCategories',
        ]);
   /* public $belongsToMany = array(
        'Categories' =>
            array(
                'className' => 'Category',
                'joinTable' => 'audiences_categories',
                'foreignKey' => 'audience_id',
                'associationForeignKey' => 'category_id',
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