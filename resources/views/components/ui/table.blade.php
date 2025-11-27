<div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
    <table {{ $attributes->merge(['class' => 'table']) }}>
        {{ $slot }}
    </table>
</div>
