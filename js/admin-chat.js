(function() {
  const { admin_display_name, firebaseConfig } = wp_data;
  console.log(firebaseConfig)
  firebase.initializeApp(firebaseConfig);
})();