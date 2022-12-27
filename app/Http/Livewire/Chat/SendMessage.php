<?php

namespace App\Http\Livewire\Chat;

use App\Models\{Conversation, Message, User};
use Livewire\Component;

class SendMessage extends Component
{
    public $selectedConversation;
    public $receiver;
    public $message;

    protected $listeners = ['updateSendMessage'];

    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
    }

    public function send()
    {
        if ($this->message == '') {
            return null;
        }

        $message = $this->selectedConversation->messages()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'content' => $this->message
        ]);

        $this->reset('message');

        $this->emitTo('chat.chatbox', 'pushNewMessage', $message->id);
        $this->emitTo('chat.chatlist', 'refresh');
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
