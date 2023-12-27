const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

app.use(express.json());

// Serve your website or any other static files
app.use(express.static('public'));

app.post('/send-notification', (req, res) => {
  const { message } = req.body;

  // Send notification to connected clients
  io.emit('notification', message);

  res.json({ success: true });
});

// WebSocket connection
io.on('connection', (socket) => {
  console.log('A user connected');

  // Handle disconnection
  socket.on('disconnect', () => {
    console.log('User disconnected');
  });
});

const PORT = process.env.PORT || 3000;

server.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${2700}`);
});