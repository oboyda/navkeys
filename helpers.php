<?php

function nvk_strip_last_slash($url){
	if(substr($url, -1) == '/'){
		$url = substr($url, 0, strlen($url)-1);
	}
	return $url;
}

function nvk_get_option($name, $lang=true){
	if(!$lang){
		return get_option($name);
	}
	return get_option($name . NVK_LANG);
}
