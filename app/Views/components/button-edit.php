@props(['url' => '#', 'class' => ''])

{{-- Button to edit an item --}}

<a class="rounded iq-bg-primary {{ $class }}" href="{{ $url }}"
    style=" width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; ">
    <i class="las la-pencil-alt" style="font-size: 20px;"></i>
</a>
