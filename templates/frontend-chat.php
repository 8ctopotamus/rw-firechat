<div id="rw-chat-widget" class="closed">
  <div id="rw-chat-toolbar">
    <img src="https://realwealthmarketing.com/wp-content/uploads/2017/05/jade-paczelt.jpg" alt="avatar" class="chat-bubble-avatar" />
    
    <div class="status">
      <strong class="name">Jade</strong>
      <span class="status">Online</span>
    </div>
    
    <button id="mini">&#95;</button>
    <!-- <button id="close">&times;</button> -->
  </div>

  <section style="display: none;">
    <form id="start-chat">
      <input name="name" type="text" placeholder="Name" class="form-control" />
      <input name="email" type="email" placeholder="Email" class="form-control" />
      <button type="submit" class="btn btn-block">Start chat</button>
    </form>

    <div id="rw-chat-ui">
      <?php echo $chatBubbleHTMLString; ?>
      <div id="rw-chat-transcript">
        <span>How can we help you?</span>
      </div>
      <form id="chat-form">
        <input type="text" class="form-control" placeholder="Your message..." />
      </form>
    </div>
  </section>
</div><!-- #rw-chat-widget -->