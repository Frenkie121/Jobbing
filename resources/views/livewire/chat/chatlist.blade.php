<div class="col-xl-4 col-xxl-3">
    <div class="app-chat-sidebar border-right border-md-n h-100">
        <div class="app-chat-sidebar-search px-4 pb-4 pt-4 border-bottom">
            <div class="input-group">
                <input aria-describedby="basic-addon1" class="form-control border-right-0" placeholder="Search..." type="text">
                <div class="input-group-prepend">
                    <span class="btn btn-success">
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
                <div class="app-chat-sidebar-user-item">
                    <a href="javascript:void(0)">
                        <div class="d-flex active">
                            <div>
                                <div class="bg-img">
                                    <img class="img-fluid" src="{{ asset('assets/images/avatar-placeholder.png') }}" alt="user">
                                    <i class="bg-img-status bg-success"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $this->getUserInstance($conversation) }}</h5>
                                <p class="text-white">
                                    <span><i class="zmdi zmdi-check-all mr-2"></i></span>
                                    @if ($conversation->messages->isNotEmpty())
                                        <span title="{{ $last_message->content }}">{{ $last_message->last_message }}</span>
                                    @else
                                        <i>No message yet.</i>
                                    @endif
                                </p>
                                <div class="d-xl-none">
                                    <small>Just now</small>
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
