(function($) {
  const { FIREBASE_CONFIG } = wp_data;
  const app = firebase.initializeApp(FIREBASE_CONFIG);
  const db = app.firestore();

  const chatWidget = document.getElementById('rw-chat-widget');
  const startChatForm = document.getElementById('start-chat');
  const chatUI = chatWidget.querySelectorAll('#rw-chat-ui')[0];
  const transcript = chatUI.querySelectorAll('#rw-chat-transcript')[0];
  const form = chatUI.querySelectorAll('#chat-form')[0];
  const input = form.querySelectorAll('input')[0];
  const mini = chatWidget.querySelectorAll('#mini')[0];
  
  const admin = { username: 'Jade' };

  const lsKey = 'rwChatChannelID';

  let guestName;
  let channelID = lsKey in localStorage ? localStorage.getItem(lsKey) : null;

  function scrollToBottom() {
    transcript.scrollTop = transcript.scrollHeight;
  }

  function cloneChatBubble() {
    var clone = document.getElementById("chat-bubble-template").content.querySelector('.chat-bubble').cloneNode(true);
    return clone;
  };

  function handleChatFormSubmit(e) {
    e.preventDefault();
    const data = {
      name: guestName,
      text: input.value,
      timestamp: Date.now(),
      isGuest: true
    };
    db.collection("channels")
      .doc(channelID)
      .collection('messages')
      .add(data);
    input.value = '';
  };

  function listen4Messages() {
    db.collection("channels")
      .doc(channelID)
      .collection('messages')
      .orderBy('timestamp', 'asc')
      .onSnapshot(function(querySnapshot) {
        transcript.innerHTML = '';
        querySnapshot.forEach(function(doc) {
          const clone = cloneChatBubble();
          clone.querySelectorAll('.chat-bubble-text')[0].innerText = doc.data().text;
          doc.data().isGuest ? clone.classList.add('guest') : null;
          transcript.appendChild(clone);
        });
        scrollToBottom();
      });
  };

  function startChat(e) {
    e.preventDefault();
    const data = {
      name: e.target.querySelectorAll('input[type="text"]')[0].value,
      email: e.target.querySelectorAll('input[type="email"]')[0].value,
      timestamp: Date.now(),
    };
    db.collection('channels')
      .add(data)
      .then(docRef => {
        channelID = docRef.id;
        guestName = data.name
        guestEmail = data.email
        localStorage.setItem(lsKey, docRef.id);
        startChatForm.style.display = 'none';
        chatUI.style.display = 'block';
        // add a first message
        const openingMessage = {
          name: admin.username,
          text: `Hi ${guestName}, how can I help you?`,
          timestamp: Date.now(),
          isGuest: false
        };
        db.collection("channels")
          .doc(channelID)
          .collection('messages')
          .add(openingMessage);
        input.value = '';
        // subscribe
        listen4Messages();
      })
      .catch(err => console.log(err));
  };

  // check to see if channel exists on load
  if (channelID) {
    db.collection("channels").doc(channelID).get().then(function(doc) {
      if (doc.exists) {
        guestName = doc.data().name
        guestEmail = doc.data().email
        startChatForm.style.display = 'none';
        chatUI.style.display = 'block';
        listen4Messages();
      } else {
        localStorage.clear(lsKey);
      }
    });
  }

  startChatForm.addEventListener('submit', startChat);

  form.addEventListener('submit', handleChatFormSubmit);
  
  mini.addEventListener('click', e => {
    $(chatWidget).toggleClass('closed').find('section').slideToggle();
  });

})(jQuery);