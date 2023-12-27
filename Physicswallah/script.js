// script.js

// Include Socket.io library via CDN (replace with the actual CDN link)
// Make sure to include this line in your HTML file before script.js
// <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

// WebSocket connection to the server
const socket = io();

// Listen for notifications from the server
socket.on('notification', (message) => {
  sendNotification(message);
});

// Function to send a notification
function sendNotification(message) {
  if (Notification.permission === 'granted') {
    var notification = new Notification('Your Title', {
      body: message,
      icon: 'path/to/icon.png' // Optional icon URL
    });

    // Optional: Handle click on notification
    notification.onclick = function() {
      // Handle click event
    };
  }
}

// Ask user for notification permission
if (Notification.permission !== 'granted') {
  Notification.requestPermission().then(function(permission) {
    if (permission === 'granted') {
      // User granted permission, you can now receive notifications
    }
  });
}