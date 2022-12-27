<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\{Conversation, Message, User};

class Chatbox extends Component
{
    public $selectedConversation = null;
    public $receiver;
    public $messages;
    public $perPage = 10;

    protected $listeners = ['loadConversation'];

    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
        $messages_count = $conversation->messages->count();
        $this->messages = Message::query()
                            ->where('conversation_id', $this->selectedConversation->id)
                            ->get()
                            ->skip($messages_count - $this->perPage)
                            ->take($this->perPage)
                            ->groupBy('created_at')
                            ->all();

        $this->dispatchBrowserEvent('chatSelected');
    }

    // public function clearSelectedConversation()
    // {
    //     $this->reset('selectedConversation');
    //     $this->emitTo('chat.chatlist', 'selectionCleared', $this->selectedConversation);
    // }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
