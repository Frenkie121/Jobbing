<?php

namespace App\Http\Livewire\Chat;

use App\Events\ChatMessageEvent;
use Livewire\Component;
use App\Models\{Conversation, Message, User};

class Chatbox extends Component
{
    public $selectedConversation = null;
    public $receiver;
    public $messages;
    public $perPage = 10;
    public $height;

    public function getListeners()
    {
        $auth_id = auth()->id();
        return [
            'loadConversation',
            'pushNewMessage',
            'loadmore',
            "echo-private:chat.{$auth_id},ChatMessageEvent" => 'broadcastedMessageReceived',
            // 'updateHeight',
        ];
    }

    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
        
        $this->messages = $this->messages($this->perPage);

        $this->dispatchBrowserEvent('chatSelected');
    }

    public function pushNewMessage($messageId)
    {
        $this->loadConversation($this->selectedConversation, $this->receiver);

        $this->dispatchBrowserEvent('rowChatToBottom');
    }

    public function loadmore()
    {
        $this->perPage += 10;
        $this->messages = $this->messages($this->perPage);

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }

    public function messages(int $perPage)
    {
        $messages_count = $this->selectedConversation->messages->count();
        return Message::query()
                        ->where('conversation_id', $this->selectedConversation->id)
                        ->get()
                        ->skip($messages_count - $perPage)
                        ->take($perPage)
                        ->groupBy(function($message) {
                            return $message->created_at->format('Y-m-d');
                        })
                        ->all();
    }

    public function broadcastedMessageReceived($event)
    {
        dd($event);
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
