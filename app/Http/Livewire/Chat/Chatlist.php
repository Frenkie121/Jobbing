<?php

namespace App\Http\Livewire\Chat;

use App\Models\{Conversation, Message, User};
use Livewire\Component;

class Chatlist extends Component
{
    public $conversations;
    public $selectedConversation = null;

    protected $listeners = ['chatConversationSelected'];

    public function mount()
    {
        $auth_id = auth()->id();
        $this->conversations = Conversation::orderByDesc(Message::select('created_at')
                                    ->whereColumn('messages.conversation_id', 'conversations.id')
                                    ->latest()
                                    ->take(1)
                                )->where('sender_id', $auth_id)
                                ->orWhere('receiver_id', $auth_id)
                                ->with(['messages', 'receiver',])
                                ->get();
    }

    public function getUserInstance(Conversation $conversation)
    {
        return auth()->id() === $conversation->sender_id ?
                                $conversation->receiver
                                :
                                $conversation->sender;
    }

    public function chatConversationSelected(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;

        $this->emitTo('chat.chatbox', 'loadConversation', $this->selectedConversation, $receiver);
        $this->emitTo('chat.send-message', 'updateSendMessage', $this->selectedConversation, $receiver);
    }

    // public function selectionCleared()
    // {
    //     $this->reset($this->selectedConversation);
    // }

    public function render()
    {
        return view('livewire.chat.chatlist');
    }
}
