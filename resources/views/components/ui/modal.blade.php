@props(['id'])
<dialog class="modal" id="{{ $id }}">
    @isset($modal_box)
        <div class="modal-box">
            @isset($card_title)
                <h1 class="card-title">{{ $card_title }}</h1>
            @endisset
            {{ $modal_box ?? 'x-slot:modal_box' }}
        </div>
    @endisset
    @isset($modal_actions)
        <div class="modal-action">
            {{ $modal_action ?? 'x-slot:modal_action' }}
        </div>
    @endisset
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
