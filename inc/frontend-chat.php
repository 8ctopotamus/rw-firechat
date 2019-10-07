<div id="rw-chat-widget">
  <!-- <div id="rw-chat-fab"><span class="dashicons dashicons-format-chat"></span></div> -->

  <form id="start-chat">
    <span>Enter your info to start chatting!</span>
    <input name="name" type="text" placeholder="Name" class="form-control" />
    <input name="email" type="email" placeholder="Email" class="form-control" />
    <button type="submit" class="btn btn-block">Start chat</button>
  </form>

  <div id="rw-chat-ui">
    <div id="rw-chat-toolbar">
      <strong class="name">Jade</strong>
      <button id="mini">&#95;</button>
      <button id="close">&times;</button>
    </div>
    <?php echo $chatBubbleHTMLString; ?>
    <div id="rw-chat-transcript"></div>
    <form id="chat-form">
      <input type="text" class="form-control" placeholder="Your message..." />
    </form>
  </div>
</div><!-- #rw-chat-widget -->