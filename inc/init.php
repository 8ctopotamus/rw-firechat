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


/*
 * Admin scripts and styles
 */
function rw_support_chat_admin_assets( $hook ) {
  wp_register_style('rw_support_chat_admin_styles', plugin_dir_url( __DIR__ ) . '/css/admin.css');
  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);  
  wp_register_script('rw_support_chat_admin_js', plugin_dir_url( __DIR__ ) . '/js/admin-chat.js', '', '', true);
  if ( $hook === 'toplevel_page_rw-support-chat' ) {
    wp_enqueue_style( 'rw_support_chat_admin_styles' );
    wp_enqueue_script( 'firebase_sdk' );
    wp_enqueue_script( 'firebase_firestore' );
    wp_localize_script( 'rw_support_chat_admin_js', 'wp_data', array(
      'firebaseConfig' => FIREBASE_CONFIG,
      'admin_display_name' => wp_get_current_user()->display_name,
    ) );
    wp_enqueue_script( 'rw_support_chat_admin_js' );
  }
}
add_action( 'admin_enqueue_scripts', 'rw_support_chat_admin_assets' );


/*
 * Frontend scripts and styles
 */
function rw_support_chat_assets() {
  wp_register_style('rw_support_chat_styles', plugin_dir_url( __DIR__ ) . '/css/style.css');
  wp_register_script('firebase_sdk', FIREBASE_SDK_URL, '', '', true);
  wp_register_script('firebase_firestore', FIRESTORE_SDK_URL, '', '', true);
  wp_register_script('rw_support_chat_js', plugin_dir_url( __DIR__ ) . '/js/frontend-chat.js', '', '', true);
  wp_localize_script( 'rw_support_chat_js', 'wp_data', array(
    'firebaseConfig' => FIREBASE_CONFIG,
  ) );
  wp_enqueue_style( 'dashicons' );
  wp_enqueue_style( 'rw_support_chat_styles' );
  wp_enqueue_script('firebase_sdk');
  wp_enqueue_script('firebase_firestore');
  wp_enqueue_script('rw_support_chat_js');
}
add_action('wp_enqueue_scripts', 'rw_support_chat_assets');


/*
 * Frontend Chat UI
 */
function rw_support_chat_footer() {
  // echo '<div id="rw-chat-fab"><span class="dashicons dashicons-format-chat"></span></div>';
  echo '<div id="rw-chat-widget">
    <form id="start-chat">
      Enter your name and email to start chatting!
      <input name="name" type="text" placeholder="Name" class="form-control" />
      <input name="email" type="email" placeholder="Email" class="form-control" />
      <button type="submit" class="btn btn-block">Start chat</button>
    </form>

    <div id="rw-chat-ui">
      <div class="chat-bubble">
        <img src="https://realwealthmarketing.com/wp-content/uploads/2017/05/jade-paczelt.jpg" alt="Help" class="chat-bubble-avatar" />
        <div>
          <span class="chat-bubble-name">Jade</span>
          <span class="chat-bubble-text">Hi there! How can I help?</span>
        </div>
      </div>
      <div id="rw-chat-transcript">
      </div>
      <form id="chat-form">
        <input type="text" class="form-control" placeholder="Your message..." />
      </form>
    </div>
  </div>';
}
add_action('wp_footer', 'rw_support_chat_footer');