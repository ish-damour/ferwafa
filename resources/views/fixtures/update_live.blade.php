@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Update Live Results</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('fixtures.updateLive', $fixture->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="shots" class="form-label">Shots</label>
                        <input type="number" name="shots" class="form-control" value="{{ $fixture->stats->shots ?? 0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="shots_on_target" class="form-label">Shots on Target</label>
                        <input type="number" name="shots_on_target" class="form-control" value="{{ $fixture->stats->shots_on_target ?? 0 }}">
                    </div>
                    <!-- Add other fields similarly -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
