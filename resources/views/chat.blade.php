<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YSAN Chatbot</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            background: #edf2f7;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .chat-container {
            background: white;
            width: 100%;
            max-width: 520px;
            margin-top: 60px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .chat-header {
            background: #0d6efd;
            color: white;
            padding: 20px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .chat-header img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: #b02a37;
        }
        .chat-box {
            padding: 20px;
            max-height: 450px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            animation: fadeIn 0.3s ease-in-out;
        }
        .message.user {
            flex-direction: row-reverse;
        }
        .message .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 10px;
        }
        .message .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background-color: #ccc;
        }
        .message p, .message .bot-text {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 20px;
            line-height: 1.5;
        }
        .message.user p {
            background: #d1e7ff;
            border-radius: 20px 20px 0 20px;
        }
        .message.bot .bot-text {
            background: #f0f0f0;
            border-radius: 20px 20px 20px 0;
        }

        .chat-form {
            border-top: 1px solid #eee;
            padding: 15px 20px;
            display: flex;
            gap: 10px;
            background: #fff;
        }
        .chat-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-family: inherit;
        }
        .chat-form button {
            padding: 12px 20px;
            border: none;
            background: #0d6efd;
            color: white;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }
        .chat-form button:hover {
            background: #0b5ed7;
        }

        .typing {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .typing span {
            width: 6px;
            height: 6px;
            background: #888;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing span:nth-child(2) {
            animation-delay: 0.2s;
        }
        .typing span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0.6); }
            40% { transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .chat-box {
                padding: 15px;
            }
            .message p, .message .bot-text {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>

    <div class="chat-container">
        <div class="chat-header">
            <div class="chat-header-left">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" alt="bot">
                YSAN Chatbot
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <button id="toggle-history" style="margin: 15px; padding: 10px 20px; background: #0d6efd; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Lihat Riwayat Chat
        </button>

        <div class="chat-box" id="chat-box">
            <div id="chat-history" style="display: none;">
                @foreach($chats as $chat)
                    <div class="message {{ $chat->role }}">
                        <div class="avatar">
                            <img src="{{ $chat->role === 'user' 
                                ? 'https://i.pravatar.cc/35?u=user' 
                                : 'https://cdn-icons-png.flaticon.com/512/4712/4712109.png' }}" />
                        </div>
                        @if($chat->role === 'bot')
                            <div class="bot-text">{!! nl2br(e($chat->message)) !!}</div>
                        @else   
                            <p>{{ $chat->message }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <form class="chat-form" id="chat-form">
            <input type="text" name="message" id="message-input" placeholder="Tulis pesan..." required>
            <button type="submit">Send</button>
        </form>
        <audio id="notif-sound" src="{{ asset('sounds/ding.mp3') }}" preload="auto"></audio>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');
        const chatBox = document.getElementById('chat-box');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const message = input.value.trim();
            if (!message) return;

            chatBox.innerHTML += `
                <div class="message user">
                    <div class="avatar">
                        <img src="https://i.pravatar.cc/35?u=user" />
                    </div>
                    <p>${message}</p>
                </div>
            `;

            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'message bot';
            typingIndicator.innerHTML = `
                <div class="avatar">
                    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" />
                </div>
                <div class="typing">
                    <span></span><span></span><span></span>
                </div>
            `;
            chatBox.appendChild(typingIndicator);
            chatBox.scrollTop = chatBox.scrollHeight;
            input.value = '';
            input.disabled = true;

            const res = await fetch('{{ route("chat.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });

            const data = await res.json();
            typingIndicator.remove();

            chatBox.innerHTML += `
                <div class="message bot">
                    <div class="avatar">
                        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" />
                    </div>
                    <div class="bot-text">${data.reply}</div>
                </div>
            `;

            const audio = document.getElementById('notif-sound');
            audio.volume = 1;
            audio.play().catch(err => {
                console.warn("Autoplay diblokir oleh browser:", err);
            });

            chatBox.scrollTop = chatBox.scrollHeight;

            input.disabled = false;
            input.focus();
        });

        const toggleBtn = document.getElementById('toggle-history');
        const historyDiv = document.getElementById('chat-history');

        toggleBtn.addEventListener('click', () => {
            if (historyDiv.style.display === 'none') {
                historyDiv.style.display = 'block';
                toggleBtn.innerText = 'Sembunyikan Riwayat Chat';
            } else {
                historyDiv.style.display = 'none';
                toggleBtn.innerText = 'Lihat Riwayat Chat';
            }
        });
    </script>
</body>
</html>
