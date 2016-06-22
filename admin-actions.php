<?php
function nvk_get_list_html($nvk_list=null){
	$html = '';
	if(!isset($nvk_list)){
		$nvk_list = nvk_get_option('nvk_list');
	}
	if($nvk_list){
		$html .= '<table></tbody>';
		foreach($nvk_list as $k => $list_item){
			$html .= '<tr>';
			$html .= '<td>' . __('Key', 'nvk') . ' <input type="text" name="nvk_list[' . $k . '][key]" size="2" value="' . $list_item['key'] . '" /></td>';
			$html .= '<td>' . __('URL', 'nvk') . ' <input type="text" class="regular-text" name="nvk_list[' . $k . '][url]" value="' . $list_item['url'] . '" /></td>';
			$html .= '<td>' . __('Remove', 'nvk') . ' <input type="checkbox" name="nvk_list[' . $k . '][del]" value="1" /></td>';
			$html .= '</tr>';
		}
		$html .= '</tbody></table>';
	}
	return $html;
}

add_action('wp_ajax_nvk_update_list', 'nvk_update_list');
function nvk_update_list(){
	$nvk_list = array();
	if(isset($_POST['nvk_list']) && !empty($_POST['nvk_list'])){
		foreach($_POST['nvk_list'] as $list_item){
			$key = trim($list_item['key']);
			$url = trim($list_item['url']);
			if($key != '' && $url != '' && !isset($list_item['del'])){
				$nvk_list[] = array('key' => $key, 'url' => $url);
			}
		}
	}
	if(isset($_POST['nvk_list_new']) && !empty($_POST['nvk_list_new'])){
		$key = trim($_POST['nvk_list_new']['key']);
		$url = trim($_POST['nvk_list_new']['url']);
		if($key != '' && $url != '' && !nvk_check_key_exists($key, $nvk_list)){
			$nvk_list[] = array('key' => $key, 'url' => $url);
		}
	}

	if(empty($nvk_list)){
		delete_option('nvk_list' . NVK_LANG);
	}else{
		update_option('nvk_list' . NVK_LANG, $nvk_list);
	}

	header('Content-Type: text/html');
	echo nvk_get_list_html($nvk_list);
	die();
}

function nvk_check_key_exists($key, $list){
	if(empty($list)){
		return false;
	}
	foreach($list as $list_item){
		if($list_item['key'] == $key){
			return true;
		}
	}
	return false;
}
