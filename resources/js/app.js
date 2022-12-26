import axios from 'axios';
import './bootstrap';

const message = document.getElementById('message');
const sendButton = document.getElementById('sendButton');
const chatDiv = document.getElementById('chat');

sendButton.addEventListener('click', () => {
    axios.post('/chat', {
        message: message.value,
    });
});

window.SpeechRecognitionAlternative.channel('chat')
    .listen('chat-message', (event) => {
        chatDiv.innerHTML += `<div class="chat-msg">
        <div class="chat-msg-content ">
            <p>${event.message}</p>
        </div>
    </div>`
    });