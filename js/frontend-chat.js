(function() {
  const { firebaseConfig } = wp_data;
  const app = firebase.initializeApp(firebaseConfig);
  const db = app.firestore();

  const chatWidget = document.getElementById('rw-chat-widget');
  const startChatForm = document.getElementById('start-chat');
  const chatUI = chatWidget.querySelectorAll('#rw-chat-ui')[0];
  const transcript = chatUI.querySelectorAll('#rw-chat-transcript')[0];
  const form = chatUI.querySelectorAll('#chat-form')[0];
  const input = form.querySelectorAll('input')[0];
  
  const lsKey = 'rwChatChannelID';

  let guestName;
  let channelID = lsKey in localStorage ? localStorage.getItem(lsKey) : null;

  function cloneChatBubble() {
    const clone = chatWidget.querySelectorAll('.chat-bubble')[0].cloneNode(true);
    clone.querySelectorAll('.chat-bubble-avatar')[0].src = 'https://realwealthmarketing.com/wp-content/uploads/2017/11/sample-headshot-placeholder.jpg';
    clone.querySelectorAll('.chat-bubble-name')[0].innerText = 'Guest';
    return clone;
  };

  function handleChatFormSubmit(e) {
    e.preventDefault();
    const data = {
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
          clone.querySelectorAll('.chat-bubble-name')[0].innerText = guestName;
          doc.data().isGuest ? clone.classList.add('guest') : null;
          transcript.appendChild(clone);
        });
      });
  };

  function startChat(e) {
    e.preventDefault();
    const data = {
      name: e.target.querySelectorAll('input[type="text"]')[0].value,
      email: e.target.querySelectorAll('input[type="email"]')[0].value,
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
        listen4Messages();
      })
      .catch(err => console.log(err));
  };

  // check to see if channel exists
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

  startChatForm.addEventListener('submit', startChat);
  form.addEventListener('submit', handleChatFormSubmit);

})();