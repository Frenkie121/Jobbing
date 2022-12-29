<div class="app-chat-msg">
    <div class="d-flex align-items-center justify-content-between p-3 px-4 border-bottom">
        @if ($selectedConversation)
            <div class="app-chat-msg-title">
                <div class="row">
                    <a class="mt-3 mr-3 back" href="javascript:void(0)">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                    <div class="bg-img">
                        <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ $receiver->name }}" alt="user">
                    </div>
                    <div>
                        <h4 class="mb-0 mt-2 ml-2">{{ $receiver->name }}</h4>
                        <p class="text-success ml-2">Online</p>
                    </div>
                </div>
            </div>
            <div class="app-chat-msg-btn">
                <a class="font-20 text-muted btn" href="javascript:void(0)">
                    <i class="fa fa-video-camera"></i>
                </a>
                <a aria-expanded="false" aria-haspopup="true" class="font-20 text-muted btn pr-0" data-toggle="dropdown" href="javascript:void(0)">
                    <i class="fa fa-gear"></i>
                </a>
                <div class="dropdown-menu custom-dropdown dropdown-menu-right p-4">
                    <h6>Action</h6>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-pencil pr-2"></i>Rename
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-announcement pr-2"></i>Mark as Unread
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-close pr-2"></i>Close
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-trash pr-2"></i>Delete
                    </a>
                </div>
            </div>
        @else
            <span class="badge badge-secondary">No conversation selected.</span>
        @endif
    </div>
    <div class="scrollbar scroll_dark app-chat-msg-chat p-4">
        @if ($selectedConversation)
            @forelse ($messages as $date => $messagePerDay)
                <div class="text-center py-1">
                    <h6>{{ $date }}</h6>
                </div>
                @foreach ($messagePerDay as $message)
                    <div class="chat {{ $message->sender_id === auth()->id() ? 'chat-left justify-content-end' : '' }}"
                        {{-- style="width: 80%; max-width: 80%; max-width: max-content" --}}
                    >
                        <div class="chat-msg">
                            <div class="row chat-msg-content d-flex">
                                <div class=""><p>{{ $message->content }}</p></div>
                                <div class="mx-3"></div>
                                <div class="ml-auto text-right mt-1 {{ $message->sender_id === auth()->id() ? 'text-white' : '' }}">
                                    <span style="font-size: 9pt;">{{ $message->created_at->format('m:i A') }}</span>
                                    @if ($message->sender_id === auth()->id())
                                        <span><i class="zmdi zmdi-check-all ml-1 "></i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
            <div class="alert alert-secondary text-center">
                <span>No message yet.</span>
            </div>
            @endforelse
        @else
            <div class="alert alert-secondary text-center">
                <span>No conversation selected.</span>
            </div>
        @endif
    </div>

    @push('js')
        <script>
            window.addEventListener('rowChatToBottom', event => {
                $('.app-chat-msg-chat').scrollTop($('.app-chat-msg-chat')[0].scrollHeight);
            });

            $('.app-chat-msg-chat').on('scroll', function () { 
                var top = $('.app-chat-msg-chat').scrollTop();
                if (top === 0) {
                    window.livewire.emit('loadmore');
                }
            });
        </script>

        <script>
            window.addEventListener('updatedHeight', event => {
                let oldHeight = event.detail.height;
                let newHeight = $('.app-chat-msg-chat').scrollTop(newHeight - oldHeight);

                window.livewire.emit('updateHeight', {
                    height: height,
                });
            });
        </script>

        <script>    
            $(document).on('click', '.back', function () {
                window.livewire.emit('selectionCleared');
            });
        </script>
    @endpush

</div>