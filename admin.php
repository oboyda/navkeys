<?php

add_action('admin_menu', 'nvk_add_submenu_page');
function nvk_add_submenu_page(){
	add_options_page(
		'NavKeys',
		'NavKeys',
		'manage_options',
		'nvk-settings',
		'nvk_display_settings_page'
	);
}

function nvk_display_settings_page(){ ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h1><?php _e('NavKeys Options', 'nvk'); ?></h1>
		<table class="form-table"><tbody>
			<tr>
				<th scope="row"><?php _e('Keys list', 'nvk'); ?></th>
				<td>
					<form id="nvk-list-form" method="POST">
						<div id="nvk-list-wrapper">
							<?php echo nvk_get_list_html(); ?>
						</div>
						<table id="nvk-new-table"><tbody>
							<tr>
								<th colspan="2"><?php _e('Add new access key', 'nvk'); ?></th>
							</tr>
							<tr>
								<td>
									<?php _e('Key', 'nvk'); ?> <input type="text" name="nvk_list_new[key]" size="2" />
								</td>
								<td>
									<?php _e('URL', 'nvk'); ?> <input type="text" class="regular-text" name="nvk_list_new[url]" />
								</td>
							</tr>
						</tbody></table>
						<p>
							<input type="hidden" name="action" value="nvk_update_list" />
							<button id="nvk-update-list-btn" class="button" type="submit"><?php _e('Update', 'nvk'); ?><span id="nvk-update-loader" style="display: none;"> ...</span></button>
						</p>
					</form>
				</td>
			</tr>
		</tbody></table>
	</div>
	<?php
}
