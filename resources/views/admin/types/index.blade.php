@extends('layouts.admin')

@section('content')
    <h1 class="my-3">Types</h1>

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.types.store') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="New type..."
                id="name" name="name">
            <button class="btn btn-primary btn-custom" type="sumbit" id="button-addon2">Add</button>
        </div>
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>
                        <form action="{{ route('admin.types.update', $type) }}" method="POST"
                            id="form-edit-{{ $type->id }}">
                            @csrf
                            @method('PUT')
                            <input class="custom-input" type="text" value="{{ $type->name }}" name="name">
                        </form>
                    </td>
                    <td class="d-flex justify-content-end">
                        <button onclick="submitForm({{ $type->id }})" class="btn btn-warning btn-custom me-2"><i
                                class="fa-solid fa-pencil"></i></button>
                        @include('admin.partials.form-delete', [
                            'route' => route('admin.types.destroy', $type),
                            'name' => $type->name,
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function submitForm(id) {
            const form = document.getElementById('form-edit-' + id);
            form.submit();
        }
    </script>
@endsection
