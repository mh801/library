<?php
class PartnersController extends AppController {
    public $scaffold = 'admin';

    function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'admin';
    }
    
    public function index() {
    // This fetches Leaders, and their associated Followers
    $all = $this->Partner->find('all');
    var_dump($all);
	}
}