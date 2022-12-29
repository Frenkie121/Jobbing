@extends('layouts.front')

@section('subtitle', 'Chat Room')

@section('content')

    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/chat/css/vendors.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/chat/css/style.css') }}" />

        @livewireStyles
    @endpush

    <div class="container">
        <!-- begin row -->
        <div class="row">
            <div class="col-md-12 m-b-30">
                <!-- begin page title -->
                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                    <div class="page-title mb-2 mb-sm-0">
                        <h1>Chat</h1>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <nav>
                            <ol class="breadcrumb p-0 m-b-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="ti ti-home"></i>
                                    </a>
                                </li>
                                <li aria-current="page" class="breadcrumb-item active text-primary">
                                    Chat
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- end page title -->
            </div>
        </div>
        <!-- end row -->
        <!--mail-read-contant-start-->
        <div class="row">
            <div class="col-12">
                <div class="card card-statistics">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            @livewire('chat.chatlist')
                            <div class="col-xl-8 col-xxl-9 border-md-t">
                                @livewire('chat.chatbox')
                                @livewire('chat.send-message')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--mail-read-contant-end-->
    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/chat/js/vendors.js') }}"></script>
    <script src="{{ asset('assets/chat/js/app.js') }}"></script>

    <script>
        window.addEventListener('chatSelected', event => {
            if (window.innerWidth < 768) {
                $('.chat-list').hide();
                $('.app-chat-type').hide();
                $('.app-chat-msg').show();
            }

            $('.app-chat-msg-chat').scrollTop($('.app-chat-msg-chat')[0].scrollHeight);

            let height = $('.app-chat-msg-chat')[0].scrollHeight;
            window.livewire.emit('updateHeight', {
                height: height,
            });
        });

        $(window).resize(function () { 
            if (window.innerWidth > 768) {
                $('.chat-list').show();
                $('.app-chat-msg').show();
                $('.app-chat-type').show();
            }
        });

        $(document).on('click', '.back', function () {
            $('.chat-list').show();
            $('.app-chat-msg').hide();
            $('.app-chat-type').hide();
            // $('.conv-item').removeClass('active');
        });

        
        $('.container').on('scroll', function () { 
                var top = $('.container').scrollTop();
                if (top === 0) {
                    window.livewire.emit('loadmore');
                }
            });
    </script>

    @livewireScripts
@endpush