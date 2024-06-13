@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Edit Team</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('teams.update', $team->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Team Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Team</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
