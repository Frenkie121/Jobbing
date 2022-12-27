<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Chatlist extends Component
{
    public $conversations;

    public function mount()
    {
        $auth_id = auth()->id();
        $this->conversations = Conversation::query()
                                ->where('sender_id', $auth_id)
                                ->orWhere('receiver_id', $auth_id)
                                ->with(['messages' => function($query) { 
                                    $query->orderBy('created_at');
                                },
                                'receiver',
                                ])
                                ->get();
    }

    public function getUserInstance(Conversation $conversation)
    {
        return auth()->id() === $conversation->sender_id ?
                                $conversation->receiver->name
                                :
                                $conversation->sender->name;
    }

    public function render()
    {
        return view('livewire.chat.chatlist');
    }
}
