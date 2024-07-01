<!-- resources/views/registration.blade.php -->

@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <div class="container">
                    <form class="p-4" action="{{ route('registration.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Picture</label>
                            <input type="file" class="form-control" name="picture" required>
                        </div>                        
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
