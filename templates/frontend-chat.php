<template id="chat-bubble-template">
  <div class="chat-bubble">
    <p class="chat-bubble-text"></p>
  </div>
</template>

<div id="rw-chat-widget">
  <div id="rw-chat-toolbar">
    <div>
      <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/img/jade.jpg"" alt="avatar" class="chat-bubble-avatar" />
    </div>

    <div class="status">
      <strong class="name">Jade</strong>
      <span class="status">Online</span>
    </div>
    
    <button id="mini">&#95;</button>
  </div>

  <section>
    <form id="start-chat">
      <input name="name" type="text" placeholder="Name" class="form-control" />
      <input name="email" type="email" placeholder="Email" class="form-control" />
      <button type="submit" class="btn btn-block">Start chat</button>
    </form>

    <div id="rw-chat-ui">
      <div id="rw-chat-transcript">
        <span>How can we help you?</span>
      </div>
      <form id="chat-form">
        <div class="input-group">
          <input type="text" placeholder="Your message..." class="form-control" data-emoji-picker="true" />
          <span class="input-group-btn">
            <button class="btn btn-success" type="submit">Send</button>
          </span>
        </div>
      </form>
    </div>
  </section>
</div><!-- #rw-chat-widget -->