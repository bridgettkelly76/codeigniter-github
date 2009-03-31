<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Philip Sturgeon
 * @created 31/03/2009
 */

class GitHub_lib {
	
    private $CI;                // CodeIgniter instance
    
    function __construct($url = '') {
        $this->CI =& get_instance();
        log_message('debug', 'GitHub class initialized');
    }

    public function user_info($username = '')
    {
    	$responce = $this->_fetch_data('http://github.com/api/v1/json/'.$username);
    	
    	if(empty($responce->user))
    	{
    		return FALSE;
    	}
    	
    	return $responce->user;
    }

    public function user_timeline($username, $project, $branch = 'master')
    {
    	$responce = $this->_fetch_data('http://github.com/api/v1/json/'.$username.'/'.$project.'/commits/'.$branch);
    	
    	if(!empty($responce->commits))
    	{
    		return FALSE;
    	}
    	
    	return $responce->commits;
    }
    
    public function search($term = '', $language = NULL)
    {
    	if(!empty($language) && is_string($language))
    	{
    		$language = strtolower($language);
    	}
    	
    	$responce = $this->_fetch_data('http://github.com/api/v1/json/search/'.$term);
    	
    	if(empty($responce->repositories) or !is_array($responce->repositories))
    	{
    		return FALSE;
    	}
    	
    	$results = array();
    	
    	foreach($responce->repositories as &$result)
    	{
    		if($language != strtolower($result->language)) continue;
    		$results[] = $result;
    	}
    	
    	return $results;
    }

    private function _fetch_data($url){
		
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);

		if ($status == '200'){
			return json_decode( $returned );
		} else {
			return false;
		}
	}
	
}
// END GitHub class
?>