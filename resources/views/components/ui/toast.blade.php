@props(['message', 'type'])
<div class="toast toast-top toast-center z-50 shadow-xl">
    <div class="alert {{ "alert-$type" }}">
        <span>
            {{ $message ?? 'Pesan notifikasi.' }}
        </span>
        <x-lucide-x class="w-4 cursor-pointer" onclick="this.parentElement.hidden=true" />
    </div>
</div>
