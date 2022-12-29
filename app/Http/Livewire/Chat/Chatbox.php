<?php

namespace App\Http\Livewire\Chat;

use App\Events\{ChatMessageEvent, MessageReadEvent};
use Livewire\Component;
use App\Models\{Conversation, Message, User};

class Chatbox extends Component
{
    public $selectedConversation = null;
    // public $onSelect = false;
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
            "echo-private:chat.{$auth_id},MessageReadEvent" => 'broadcastedMessageRead',
            'broadcastMessageRead',
            // 'selectionCleared',
            // 'updateHeight',
        ];
    }

    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
        
        $this->messages = $this->messages($this->perPage);

        $this->dispatchBrowserEvent('chatSelected');

        Message::query()
                ->where('conversation_id', $this->selectedConversation->id)
                ->where('receiver_id', auth()->id())
                ->update(['read' => true]);

        $this->emitSelf('broadcastMessageRead');
    }

    public function pushNewMessage($messageId)
    {
        $this->messages = $this->messages($this->perPage);

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

    public function broadcastedMessageReceived($event)
    {
        $this->emitTo('chat.chatlist', 'refresh');

        $brodcasted_message = Message::query()->find($event['message_id']);

        if ($this->selectedConversation && $this->selectedConversation->id === $event['conversation_id']) {
            $brodcasted_message->read = true;
            $brodcasted_message->save();

            $this->pushNewMessage($brodcasted_message->id);

            $this->emitSelf('broadcastMessageRead');
        }
    }

    public function broadcastMessageRead()
    {
        broadcast(new MessageReadEvent($this->selectedConversation->id, $this->receiver->id));
    }

    public function broadcastedMessageRead($event)
    {
        if ($this->selectedConversation && (int) $this->selectedConversation->id === (int) $event['conversation_id']) {
            $this->dispatchBrowserEvent('markMessageAsRead');
        }
    }
    
    public function selectionCleared()
    {
        // $this->selectedConversation = null;
        // $this->receiver = null;
        // $this->onSelect = false;
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

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
