<div class="app-chat-type">
    @if ($selectedConversation)
        <form wire:submit.prevent="send()">
            <div class="input-group mb-0 ">
                <div class="input-group-prepend d-none d-sm-flex">
                    <button class="btn btn-success">
                        <i class="fa fa-smile-o">
                        </i>
                    </button>
                </div>
                <input wire:model.defer="message" class="form-control" placeholder="Type message here..." type="text">
                <div class="input-group-prepend">
                    <button class="btn btn-success">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
