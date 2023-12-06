@extends('layouts.admin')

@section('content')
    <h1 class="my-3">Technologies</h1>

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

    <form action="{{ route('admin.technologies.store') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="New Technology..."
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
                <th>Technology</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technologies as $technology)
                <tr>
                    <td>{{ $technology->id }}</td>
                    <td>
                        <form action="{{ route('admin.technologies.update', $technology) }}" method="POST"
                            id="form-edit-{{ $technology->id }}">
                            @csrf
                            @method('PUT')
                            <input class="custom-input" type="text" value="{{ $technology->name }}" name="name">
                        </form>
                    </td>
                    <td class="d-flex justify-content-end">
                        <button onclick="submitForm({{ $technology->id }})" class="btn btn-warning btn-custom me-2"><i
                                class="fa-solid fa-pencil"></i></button>
                        @include('admin.partials.form-delete', [
                            'route' => route('admin.technologies.destroy', $technology),
                            'name' => $technology->name,
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
