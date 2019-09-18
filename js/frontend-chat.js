(function() {
  const { firebaseConfig } = wp_data;
  const fab = document.getElementById('rw-chat-fab');
  const chatUI = document.getElementById('rw-chat-ui');
  
  const toggleUI = e => {
    e.target.style.display = 'none';
    chatUI.style.display = 'block';
  };

  firebase.initializeApp(firebaseConfig);
  fab.addEventListener('click', toggleUI);
})();