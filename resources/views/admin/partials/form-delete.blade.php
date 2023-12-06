<form class="d-inline-block" action="{{ $route }}" method="POST"
    onsubmit="return confirm('Are you sure you want to delete {{ $name }}?')">
    @csrf
    @method('DELETE')
    <button type="sumbit" class="btn btn-danger btn-custom"><i class="fa-solid fa-trash"></i></button>
</form>
