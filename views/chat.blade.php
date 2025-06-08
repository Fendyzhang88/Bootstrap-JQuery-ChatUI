<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #chat-box {
            height: 400px;
            overflow-y: scroll;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .bubble {
            max-width: 70%;
            padding: 12px;
            border-radius: 16px;
            margin: 2px;
            word-break: break-word;
        }

        /* Style bubble guest (misal biru) */
        .bubble.guest {
            align-self: flex-end;
            background-color: #79F0BA;
            color: #000;
        }

        /* Style bubble AI (misal abu-abu) */
        .bubble.ai {
            align-self: flex-start;
            background-color: #f1f1f1;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3>Chat Room</h3>
        <div id="chat-box" class="mb-3"></div>
        <form id="chat-form" class="d-flex">
            <input type="text" id="message" class="form-control me-2" placeholder="Type a message..." required>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchMessages() {
                $.get("{{ route('chat.fetch') }}", function(data) {
                    $('#chat-box').html('');
                    data.forEach(function(msg) {
                        if(msg.user == "Guest"){
                            css = "guest";
                        }else{
                            css = "ai";
                        }
                        $('#chat-box').append("<div class='bubble " + css + "'><strong>" + msg.user + "</strong><br>" + msg.message + "</div>");
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                });
            }

            function fetchAIMessages() {
                $.get("{{ route('chat.fetch-ai') }}", function(data) {
                    $('#chat-box').html('');
                    data.forEach(function(msg) {
                        if(msg.user == "Guest"){
                            css = "guest";
                        }else{
                            css = "ai";
                        }
                        $('#chat-box').append("<div class='bubble " + css + "'><strong>" + msg.user + "</strong><br>" + msg.message + "</div>");
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                });
            }

            fetchAIMessages();
            setInterval(fetchAIMessages, 5000); // Polling every 5 seconds

            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                let message = $('#message').val();

                $.ajax({
                    url: "{{ route('chat.send') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        message: message
                    },
                    success: function() {
                        $('#message').val('');
                        fetchMessages();
                    }
                });
            });
        });
    </script>
    </script>

</body>

</html>
