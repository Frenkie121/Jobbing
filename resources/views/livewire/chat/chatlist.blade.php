<div class="col-xl-4 col-xxl-3 chat-list">
    <div class="app-chat-sidebar border-right border-md-n h-100">
        <div class="app-chat-sidebar-search px-4 pb-4 pt-4 border-bottom">
            <div class="input-group">
                <input aria-describedby="basic-addon1" class="form-control border-right-0" placeholder="Search..." type="text">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="app-chat-sidebar-user scrollbar scroll_dark">
            @foreach ($conversations as $conversation)
                @php
                    $last_message = $conversation->messages->last();
                @endphp
                <div wire:key="{{ time() . $conversation->id }}" class="app-chat-sidebar-user-item">
                    <a href="javascript:void(0)" wire:click="$emit('chatConversationSelected', {{ $conversation }}, {{ $this->getUserInstance($conversation)->id }})">
                        <div class="d-flex {{ ($selectedConversation && $selectedConversation->id === $conversation->id) ? 'active' : '' }} conv-item">
                            <div>
                                <div class="bg-img">
                                    <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ $this->getUserInstance($conversation)->name }}" alt="user">
                                    <i class="bg-img-status bg-success"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $this->getUserInstance($conversation)->name }}</h5>
                                <p class="{{ (!$selectedConversation || $selectedConversation && $selectedConversation->id !== $conversation->id) ? 'text-dark' : 'text-white' }}">
                                    @if ($last_message->sender_id === auth()->id())
                                        <span><i class="zmdi zmdi-check{{ $last_message->read ? '-all text-primary' : '' }} ml-2"></i></span>
                                    @endif
                                    @if ($conversation->messages->isNotEmpty())
                                        <span title="{{ $last_message->content }}">{{ $last_message->last_message }}</span>
                                    @else
                                        <i>No message yet.</i>
                                    @endif
                                </p>
                                <div class="d-xl-none">
                                    <small>{{ $last_message?->last_time }}</small>
                                    <span class="badge badge-success">5</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right d-none d-xl-block">
                                <small>{{ $last_message?->last_time }}</small>
                                <span class="badge badge-success">5</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
