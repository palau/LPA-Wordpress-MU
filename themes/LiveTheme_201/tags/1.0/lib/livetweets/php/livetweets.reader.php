<?php
	
	/*
	* Live Tweets Reader
	* Copyright (c) 2010 The Standard Theme Team
	* Licensed under GPL2
	* http://standardtheme.com
	*/	
	
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	$str_url = 'http://search.twitter.com/search.json?q=';
	$hashtag = trim($_GET['hashtag']);
	$username = trim($_GET['username']);

	if(isset($hashtag) && strlen($hashtag) != 0) {
		$str_hashtag = "%23" . $hashtag;
		$str_url .= $str_hashtag;
	}
	
	if(isset($username) && strlen($username) != 0) {
		$str_username = '';
		if(isset($hashtag) && strlen($hashtag) != 0) {
			$str_username = '+OR+';
		}
		$str_username .= "%40" . $username;
		$str_url .= $str_username;
	}
	
	echo file_get_contents($str_url);
	
?>