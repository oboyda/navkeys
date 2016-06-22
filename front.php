<?php

function nvk_print_list(){
	if($nvk_list = nvk_get_option('nvk_list')){ ?>
	<script type="text/javascript">
		jQuery(function($){
			<?php
			$nav_list_js_items = array();
			foreach($nvk_list as $list_item){
				$nav_list_js_items[] = '{key:"' . strtoupper($list_item['key']) . '", url:"' . $list_item['url'] . '"}';
			}
			echo 'var nvkList = [' . implode(',', $nav_list_js_items) . '];';
			?>
			$(document).keydown(function(event){
				var activeTagName = document.activeElement.tagName.toLowerCase();
				if(event.shiftKey && activeTagName != "input"  && activeTagName != "textarea"){
					event.preventDefault();
					for(var i=0; i<nvkList.length; i++){
						if(event.key == nvkList[i].key){
							window.location = nvkList[i].url;
						}
					}
				}
			});
		});
	</script>
	<?php
	}
}
add_action('wp_head', 'nvk_print_list');

function nvk_inject_access_keys($buffer){
	return preg_replace_callback('|<a(.*?)href="(.*?)"(.*?)>|', 'nvk_inject_access_keys_callback', $buffer);
}

$nvk_processed_list = array();
function nvk_inject_access_keys_callback($matches){
	global $nvk_processed_list;
	$nvk_list = nvk_get_option('nvk_list');
	if($nvk_list && isset($matches[2])){
		$matched_url = nvk_strip_last_slash($matches[2]);
		foreach($nvk_list as $list_item){
			$accesskey_att = ' accesskey="' . $list_item['key'] . '"';
			if(!in_array($matched_url, $nvk_processed_list) && $matched_url == nvk_strip_last_slash($list_item['url']) && strpos($matches[0], $accesskey_att) === false){
				$nvk_processed_list[] = $matched_url;
				return str_replace('>', $accesskey_att . '>', $matches[0]);
			}
		}
	}
	return $matches[0];
}

function nvk_buffer_start(){
	if(!is_admin() && !is_page('log-in')){
		ob_start('nvk_inject_access_keys');
	}
}
function nvk_buffer_end(){
	if(!is_admin() && !is_page('log-in') && ob_get_contents()){
		ob_end_flush();
	}
}
add_action('after_setup_theme', 'nvk_buffer_start');
add_action('shutdown', 'nvk_buffer_end');
