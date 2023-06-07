<h1>Welcome To LMS</h1>

{{-- <!DOCTYPE html>
<html>
<head>
  <title>Chat Show</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
  <div id="app">
    <h1>Chat Show</h1>

    <div class="chat-container">
      <div id="messages" class="message-list">
        <!-- Messages will be dynamically added here -->
      </div>

      <form id="chat-form" action="{{ url('chat.sendMessage') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="message" placeholder="Message" required>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>

  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('92713003b8d0638219f4', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('chat-channel');
    channel.bind('new-message', function(data) {
    debugger

      // Append the new message to the message list
      var message = document.createElement('div');
      message.classList.add('message');
      message.innerHTML = '<strong>' + data.username + ':</strong> ' + data.message;
      document.getElementById('messages').appendChild(message);
    });
  </script>
</body>
</html> --}}


{{-- window.Echo.private(`user-chat-channel-${recipientId}`)
    .listen('.new-message', (message) => {
        // Handle the new message event, e.g., display the message in the UI
        console.log(message);
    }); --}}