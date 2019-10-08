(function($) {
  const { admin_display_name, FIREBASE_CONFIG } = wp_data;
  const app = firebase.initializeApp(FIREBASE_CONFIG);
  const db = app.firestore();
  const channelsList = document.getElementById('channels-list');
  
  const chatUI = document.getElementById('chat-ui');
  const transcript = chatUI.querySelectorAll('#rw-chat-transcript')[0];
  const form = chatUI.querySelectorAll('#chat-form')[0];
  const input = form.querySelectorAll('input')[0];

  let currentChannelId;

  function listen4Messages(channelId) {
    db.collection("channels")
      .doc(channelId)
      .collection('messages')
      .orderBy('timestamp', 'asc')
      .onSnapshot(function(querySnapshot) {
        transcript.innerHTML = '';
        querySnapshot.forEach(function(doc) {
          const chatBubble = cloneChatBubble();
          chatBubble.querySelectorAll('.chat-bubble-name')[0].innerText = doc.data().name;
          chatBubble.querySelectorAll('.chat-bubble-time')[0].innerText = timeFormatter(doc.data().timestamp);
          chatBubble.querySelectorAll('.chat-bubble-text')[0].innerText = doc.data().text;
          doc.data().isGuest ? chatBubble.classList.add('guest') : null;
          transcript.appendChild(chatBubble);
        });
      });
  }

  function handleChatFormSubmit(e) {
    e.preventDefault();
    const data = {
      name: 'Jade',
      text: input.value,
      timestamp: Date.now(),
      isGuest: false
    };
    db.collection("channels")
      .doc(currentChannelId)
      .collection('messages')
      .add(data);
    input.value = '';
  };

  function handleChannelItemClick(e) {
    let id = e.target.id;
    if (!id) { id = e.target.parentNode.id; }
    currentChannelId = id;

    Array.prototype.slice.call(channelsList.children).forEach(el => {
      el.classList.remove('active');
      if (el.id === currentChannelId) {
        el.classList.add('active');
      }
    });

    listen4Messages(currentChannelId);
  }

  function deleteChannel(e) {
    e.preventDefault();
    let confirmation = confirm("Are you sure?");
    if (confirmation) {
      const id = $(this).parent().attr('id');
      db.collection("channels").doc(id)
        .delete()
        .catch(err => console.log(err));
    }
  }

  function timeFormatter(dateTime){
    var date = new Date(dateTime);
    if (date.getHours()>=12){
        var hour = parseInt(date.getHours()) - 12;
        var amPm = "PM";
    } else {
        var hour = date.getHours(); 
        var amPm = "AM";
    }
    var time = hour + ":" + date.getMinutes() + " " + amPm;
    return time;
  }

  function cloneChatBubble() {
    var clone = document.getElementById("chat-bubble-template").content.querySelector('.chat-bubble').cloneNode(true);
    return clone;
  };

  function cloneChannelItem() {
    var clone = document.getElementById("channel-item-template").content.querySelector('.channel-item').cloneNode(true);
    return clone;
  };

  db.collection("channels")
    .orderBy('timestamp', 'asc')
    .onSnapshot(function(querySnapshot) {
      channelsList.innerHTML = '';
      querySnapshot.forEach(function(doc) {
        if (!currentChannelId) {
          currentChannelId = doc.id;
        }
        const newItem = cloneChannelItem();
        newItem.id = doc.id;
        if (newItem.id === currentChannelId) {
          newItem.classList.add('active');
        }
        newItem.querySelectorAll('.channel-label')[0].innerText = doc.data().name;
        newItem.addEventListener('click', handleChannelItemClick);
        channelsList.appendChild(newItem);
      });

      if (currentChannelId) {
        listen4Messages(currentChannelId);
      }
    });
  
  form.addEventListener('submit', handleChatFormSubmit);
  $('body').on('click', '.delete', deleteChannel)



  // dropdown
  $("body").on('click', "nav ul li a:not(:only-child)", function(e) {
    $(this).siblings(".dropdown").toggle();
  
    $(".dropdown").not($(this).siblings()).hide();
    e.stopPropagation();
  });
  
  $("html").click(function() {
    $(".dropdown").hide();
  });

})(jQuery);