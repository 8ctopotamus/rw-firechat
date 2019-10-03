<?php

add_action('admin_menu', 'rw_firechat_admin');

function rw_firechat_admin() {
  add_menu_page( 
    'RW FireChat',
    'RW FireChat',
    'manage_options',
    'rw-firechat',
    'rw_firechat_admin_html',
    'dashicons-format-chat',
  );
}

function rw_firechat_admin_html() {
  if ( !current_user_can('manage_options') ) {
    return;
  }
  
  if ( isset($_GET['error']) ){
    echo '<p class="notice notice-error">' . $_GET['error'] . '</p>';
  }

  ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <div id="chat-dashboard">
        <div id="channels-list"></div>
        <div id="chat-ui">          
          <div id="rw-chat-transcript"></div>
          <form id="chat-form">
            <input type="text" class="form-control" placeholder="Your message..." />
          </form>
        </div>
      </div>
    </div><!-- /.wrap -->
  <?php 
}