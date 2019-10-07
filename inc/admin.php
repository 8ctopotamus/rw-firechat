<?php

add_action('admin_menu', 'rw_firechat_admin');

function rw_firechat_admin() {
  add_menu_page( 
    __('RW FireChat', 'rw-firechat'),
    __('RW FireChat', 'rw-firechat'),
    'manage_options',
    'rw-firechat',
    'rw_firechat_admin_html',
    'dashicons-format-chat',
  );

  add_submenu_page(
    'rw-firechat',
    __('RW FireChat Settings', 'rw-firechat'),
    __('Settings', 'rw-firechat'),
    'manage_options',
    'rw-firechat-settings',
    'rw_firechat_settings_html'
  );

	add_settings_section(
		'xtable_rw_firechat_settings_section', 
		__( 'RW FireChat Settings', 'rw-firechat' ), 
		'rw_firechat_settings_section_callback', 
		'rw_firechat_settings'
  );
  
	add_settings_field( 
		'rw_firechat_settings', 
		__( 'Add your firebase config here.', 'rw-firechat' ), 
		'rw_firechat_settings_render_inputs', 
		'rw_firechat_settings',
		'xtable_rw_firechat_settings_section' 
	);
  
  register_setting( 'rw_firechat_settings', 'rw_firechat_settings' );
}

// settings section heading
function rw_firechat_settings_section_callback() {
  echo '<p>' . __('Add your firebase config', 'rw-firechat') . '</p>';
}
// settings fields
function rw_firechat_settings_render_inputs() {
  global $firebaseConfigConstants;

  $options = get_option( 'rw_firechat_settings' ); 
  
  foreach($firebaseConfigConstants as $key): ?>
    <label for="rw_firechat_settings[<?php echo $key; ?>]"><?php echo $key; ?></label>
	  <input name='rw_firechat_settings[<?php echo $key; ?>]' value="<?php echo wp_unslash( $options[$key] ); ?>" />
  <?php endforeach;
}

function rw_firechat_settings_html() {
  if ( !current_user_can('manage_options') ) {
    return;
  }
  ?>
    <form id="firebase-keys-form" method="post" action="options.php">
      <?php
        settings_fields( 'rw_firechat_settings' );
        do_settings_sections( 'rw_firechat_settings' );
        submit_button();
      ?>
    </form>
  <?php
}

function rw_firechat_admin_html() {
  if ( !current_user_can('manage_options') ) {
    return;
  }

  if ( isset($_GET['error']) ){
    echo '<p class="notice notice-error">' . $_GET['error'] . '</p>';
  }
  
  include 'admin-chat.php';
}