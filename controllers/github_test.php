<?php

class Github_test extends Controller {

    function __construct() {
    	parent::Controller();
        $this->load->library('github_lib');
        
        echo "<pre>";
    }
    
    /* Get all user data for a username, including repo's */
    function user($username = 'philsturgeon') {
    	
    	$returned = $this->github_lib->user_info($username);
    	print_r($returned);
    }
    
    // Get a users commit history for a project (3rd parameter is branch - default master)
    function commits($term, $lang = '') {
    	
    	$returned = $this->github_lib->user_timeline('philsturgeon', 'codeigniter-github');
    	print_r($returned);
    }
    
    
    /* Search repositories with a term and optional a programming language */
    function search($term = 'codeigniter', $language = 'php') {
    	
    	$returned = $this->github_lib->search($term, $language);
    	print_r($returned);
    }
    
}

?>