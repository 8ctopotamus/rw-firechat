<template id="channel-item-template">
  <div class="channel-item">
    <h4 class="channel-label">Guest Name</h4>
    <nav>
      <ul>
        <li>
          <a href="#!"><span class="dashicons dashicons-menu"></span></a>
          <ul class="dropdown">
            <li><a href="#!">Infusionsoft</a></li>
            <li><button class="delete">Delete</button></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</template>

<template id="chat-bubble-template">
  <div class="chat-bubble">
    <img src="https://realwealthmarketing.com/wp-content/uploads/2017/05/jade-paczelt.jpg" alt="avatar" class="chat-bubble-avatar" />
    <div>
    <span class="chat-bubble-time"></span>
      <span class="chat-bubble-name">Jade</span>
      <span class="chat-bubble-text">Hi there! How can I help?</span>
    </div>
  </div>
</template>

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