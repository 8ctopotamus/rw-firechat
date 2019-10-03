<?php 

define('FIREBASE_SDK_URL', 'https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"');
define('FIRESTORE_SDK_URL', 'https://www.gstatic.com/firebasejs/6.6.1/firebase-firestore.js');

define('FIREBASE_CONFIG', array(
  'apiKey' => getenv('FIREBASE_API_KEY'),
  'authDomain' => getenv('FIREBASE_AUTH_DOMAIN'),
  'databaseURL' => getenv('FIREBASE_DATABASE_URL'),
  'projectId' => getenv('FIREBASE_PROJECT_ID'),
  'storageBucket' => getenv('FIREBASE_STORAGE_BUCKET'),
  'messagingSenderId' => getenv('FIREBASE_MESSAGING_SENDER_ID'),
  'appId' => getenv('FIREBASE_APP_ID'),
));

$chatBubbleHTMLString = '<div class="chat-bubble">
<img src="https://realwealthmarketing.com/wp-content/uploads/2017/05/jade-paczelt.jpg" alt="avatar" class="chat-bubble-avatar" />
<div>
  <span class="chat-bubble-name">Jade</span>
  <span class="chat-bubble-text">Hi there! How can I help?</span>
</div>
</div>';

/*
 * Admin scripts and styles
 */
function rw_firechat_admin_assets( $hook ) {
  global $chatBubbleHTMLString;
  wp_register_style('rw_firechat_admin_styles', plugin_dir_url( __DIR__ ) . '/css/admin.css');
  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);  
  wp_register_script('rw_firechat_admin_js', plugin_dir_url( __DIR__ ) . '/js/admin-chat.js', '', '', true);
  if ( $hook === 'toplevel_page_rw-firechat' ) {
    wp_enqueue_style( 'rw_firechat_admin_styles' );
    wp_enqueue_script( 'firebase_sdk' );
    wp_enqueue_script( 'firebase_firestore' );
    wp_localize_script( 'rw_firechat_admin_js', 'wp_data', array(
      'firebaseConfig' => FIREBASE_CONFIG,
      'admin_display_name' => wp_get_current_user()->display_name,
      'chatBubbleHTMLString' => $chatBubbleHTMLString,
    ) );
    wp_enqueue_script( 'rw_firechat_admin_js' );
  }
}
add_action( 'admin_enqueue_scripts', 'rw_firechat_admin_assets' );


/*
 * Frontend scripts and styles
 */
function rw_firechat_assets() {
  global $chatBubbleHTMLString;
  wp_register_style('rw_firechat_styles', plugin_dir_url( __DIR__ ) . '/css/style.css');
  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);
  wp_register_script('rw_firechat_js', plugin_dir_url( __DIR__ ) . '/js/frontend-chat.js', '', '', true);
  wp_localize_script( 'rw_firechat_js', 'wp_data', array(
    'firebaseConfig' => FIREBASE_CONFIG,
    'chatBubbleHTMLString' => $chatBubbleHTMLString,
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
  global $chatBubbleHTMLString;
  include 'frontend-chat.php';
}
add_action('wp_footer', 'rw_firechat_footer');