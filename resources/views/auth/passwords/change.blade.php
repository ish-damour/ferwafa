@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Change Password') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.change.post') }}">
                        @csrf

                        <div class="form-group">
                            <label for="current_password">{{ __('Current Password') }}</label>
                            <input id="current_password" type="password" class="form-control" name="current_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password">{{ __('New Password') }}</label>
                            <input id="new_password" type="password" class="form-control" name="new_password" required>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Change Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
