@props(['url' => '#', 'class' => ''])

{{-- Button to edit an item --}}

<form action="{{ $url }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')">
    @csrf
    @method('DELETE')
    <button class="border-0 p-0 m-0 bg-danger rounded {{ $class }}" type="submit"
        style=" width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; ">
        <i class="las la-trash-alt" style="color: white; font-size: 20px;"></i>
    </button>
</form>
