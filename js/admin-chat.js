(function() {
  const { admin_display_name, firebaseConfig, chatBubbleHTMLString } = wp_data;
  const app = firebase.initializeApp(firebaseConfig);
  const db = app.firestore();
  const parser = new DOMParser();
  const channelsList = document.getElementById('channels-list');

  const chatUI = document.getElementById('chat-ui');
  const transcript = chatUI.querySelectorAll('#rw-chat-transcript')[0];
  const form = chatUI.querySelectorAll('#chat-form')[0];
  const input = form.querySelectorAll('input')[0];  
  const channelItemString = '<div class="channel-item"><h4 class="channel-label">Guest Name</h4></div>';

  let currentChannelId;

  function listen4Messages(channelId) {
    db.collection("channels")
      .doc(channelId)
      .collection('messages')
      .orderBy('timestamp', 'asc')
      .onSnapshot(function(querySnapshot) {
        transcript.innerHTML = '';
        querySnapshot.forEach(function(doc) {
          const chatBubble = parser.parseFromString(chatBubbleHTMLString, 'text/html').body.firstChild;
          console.log(chatBubble)
          chatBubble.querySelectorAll('.chat-bubble-name')[0].innerText = doc.data().name;
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
    listen4Messages(currentChannelId);
  }

  db.collection("channels")
    .orderBy('timestamp', 'asc')
    .onSnapshot(function(querySnapshot) {
      channelsList.innerHTML = '';
      querySnapshot.forEach(function(doc) {
        if (!currentChannelId) {
          currentChannelId = doc.id;
        }
        const newItem = parser.parseFromString(channelItemString, 'text/html').body.firstChild;
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

})();