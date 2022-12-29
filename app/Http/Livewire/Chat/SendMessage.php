<?php

namespace App\Http\Livewire\Chat;

use App\Events\ChatMessageEvent;
use App\Models\{Conversation, User};
use Livewire\Component;

class SendMessage extends Component
{
    public $selectedConversation;
    public $receiver;
    public $message;
    public $newMessage;

    protected $listeners = [
        'updateSendMessage',
        'dispatchMessageSent',
        // 'selectionCleared',
    ];

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

        $this->newMessage = $this->selectedConversation->messages()->create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'content' => $this->message
        ]);

        $this->emitTo('chat.chatbox', 'pushNewMessage', $this->newMessage->id);
        $this->emitTo('chat.chatlist', 'refresh');

        $this->emitSelf('dispatchMessageSent');
    }

    public function dispatchMessageSent()
    {
        broadcast(new ChatMessageEvent(auth()->user(), $this->newMessage, $this->selectedConversation, $this->receiver));
        
        $this->reset('message');
    }
    
    // public function selectionCleared()
    // {
    //     $this->selectedConversation = null;
    //     $this->receiver = null;
    // }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
