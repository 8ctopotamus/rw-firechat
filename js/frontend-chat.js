(function() {
  const { firebaseConfig } = wp_data;
  const chatWidget = document.getElementById('rw-chat-widget');
  const startChatForm = document.getElementById('start-chat');

  const chatUI = chatWidget.querySelectorAll('#rw-chat-ui')[0];
  const transcript = chatUI.querySelectorAll('#rw-chat-transcript')[0];
  const form = chatUI.querySelectorAll('#chat-form')[0];
  const input = form.querySelectorAll('input')[0];

  const app = firebase.initializeApp(firebaseConfig);
  const db = app.firestore();

  let channelID;

  function cloneChatBubble() {
    const clone = chatWidget.querySelectorAll('.chat-bubble')[0].cloneNode(true);
    clone.querySelectorAll('.chat-bubble-avatar')[0].src = 'https://realwealthmarketing.com/wp-content/uploads/2017/11/sample-headshot-placeholder.jpg';
    clone.querySelectorAll('.chat-bubble-name')[0].innerText = 'Guest';
    return clone;
  }

  function handleChatFormSubmit(e) {
    e.preventDefault();
    const clone = cloneChatBubble();
    clone.classList.add('guest');
    clone.querySelectorAll('.chat-bubble-text')[0].innerText = input.value;
    transcript.appendChild(clone);
    console.log(channelID)
    input.value = '';
  }

  function startChat(e) {
    e.preventDefault();
    const data = {
      name: e.target.querySelectorAll('input[type="text"]')[0].value,
      value: e.target.querySelectorAll('input[type="email"]')[0].value,
    };
    db.collection('channels')
      .add(data)
      .then(docRef => channelID = docRef.id)
      .catch(err => console.log(err));
    startChatForm.style.display = 'none';
    chatUI.style.display = 'block';
  }

  // db.collection("channels")
  //   .onSnapshot(function(querySnapshot) {
  //     querySnapshot.forEach(function(doc) {
  //       console.log(doc.id, doc.data())
  //     });
  //   });

  form.addEventListener('submit', handleChatFormSubmit);
  startChatForm.addEventListener('submit', startChat);
})();