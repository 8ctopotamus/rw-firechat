<template id="channel-item-template">
  <div class="channel-item">
    <h4 class="channel-label">Guest Name</h4>
    <button class="delete">&times;</button>
  </div>
</template>

<template id="chat-bubble-template">
  <div class="chat-bubble">
    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/avatar-placeholder.jpg" alt="avatar" class="chat-bubble-avatar" />
    <div>
    <span class="chat-bubble-time"></span>
      <span class="chat-bubble-name"></span>
      <span class="chat-bubble-text"></span>
    </div>
  </div>
</template>

<div class="wrap">
  <div id="chat-dashboard">
    <h1 id="chat-heading"><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <div id="chat-dashboard-grid">
      <div id="channels-list"></div>
      <div id="chat-ui">
        <div id="rw-chat-transcript"></div>
        <form id="chat-form">
          <input type="text" class="form-control" placeholder="Your message..." />
        </form>
      </div>
    </div>
  </div>
</div><!-- /.wrap -->