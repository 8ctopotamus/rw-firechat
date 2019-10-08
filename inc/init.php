<?php 

define('FIREBASE_SDK_URL', 'https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"');
define('FIRESTORE_SDK_URL', 'https://www.gstatic.com/firebasejs/6.6.1/firebase-firestore.js');

$firebaseConfigConstants = [
  'FIREBASE_API_KEY',
  'FIREBASE_AUTH_DOMAIN',
  'FIREBASE_DATABASE_URL',
  'FIREBASE_PROJECT_ID',
  'FIREBASE_STORAGE_BUCKET',
  'FIREBASE_MESSAGING_SENDER_ID',
  'FIREBASE_APP_ID',
];

$options = get_option( 'rw_firechat_settings' ); 

define('FIREBASE_CONFIG', array(
  'apiKey' => $options['FIREBASE_API_KEY'],
  'authDomain' => $options['FIREBASE_AUTH_DOMAIN'],
  'databaseURL' => $options['FIREBASE_DATABASE_URL'],
  'projectId' => $options['FIREBASE_PROJECT_ID'],
  'storageBucket' => $options['FIREBASE_STORAGE_BUCKET'],
  'messagingSenderId' => $options['FIREBASE_MESSAGING_SENDER_ID'],
  'appId' => $options['FIREBASE_APP_ID'],
));

/*
 * Admin scripts and styles
 */
function rw_firechat_admin_assets( $hook ) {
  wp_register_style('rw_firechat_admin_styles', plugin_dir_url( __DIR__ ) . '/css/admin.css');

  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);  
  wp_register_script('rw_firechat_admin_js', plugin_dir_url( __DIR__ ) . '/js/admin-chat.js', '', '', true);

  if ( $hook === 'rw-firechat_page_rw-firechat-settings' ) {
    wp_enqueue_style( 'rw_firechat_admin_styles' );
  }

  if ( $hook === 'toplevel_page_rw-firechat' ) {
    wp_enqueue_style( 'rw_firechat_admin_styles' );
    wp_enqueue_script( 'firebase_sdk' );
    wp_enqueue_script( 'firebase_firestore' );
    wp_localize_script( 'rw_firechat_admin_js', 'wp_data', array(
      'FIREBASE_CONFIG' => FIREBASE_CONFIG,
      'admin_display_name' => wp_get_current_user()->display_name,
    ) );
    wp_enqueue_script( 'rw_firechat_admin_js' );
  }
}
add_action( 'admin_enqueue_scripts', 'rw_firechat_admin_assets' );


/*
 * Frontend scripts and styles
 */
function rw_firechat_assets() {  
  wp_register_style('rw_firechat_styles', plugin_dir_url( __DIR__ ) . '/css/style.css');

  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);
  wp_register_script('rw_firechat_js', plugin_dir_url( __DIR__ ) . '/js/frontend-chat.js', array('jquery'), '', true);
  wp_localize_script( 'rw_firechat_js', 'wp_data', array(
    'FIREBASE_CONFIG' => FIREBASE_CONFIG,
  ) );
  
  wp_enqueue_style( 'dashicons' );
  wp_enqueue_style( 'rw_firechat_styles' );

  wp_enqueue_script('firebase_sdk');
  wp_enqueue_script('firebase_firestore');
  wp_enqueue_script('rw_firechat_js');
}
add_action('wp_enqueue_scripts', 'rw_firechat_assets');


/*
 * Frontend Chat UI
 */
function rw_firechat_footer() {
  include plugin_dir_path( __DIR__ ) . '/templates/frontend-chat.php';
}
add_action('wp_footer', 'rw_firechat_footer');