<!-- resources/views/fixtures/generate.blade.php -->
@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Generate Fixtures</h1>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('fixtures.generate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" id="startDate" name="startDate" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="matchTimes" class="form-label">The first time match can start on per day like 14:00: </label>
                    <input type="time" id="matchTimes" name="firsttime" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="matchTimes" class="form-label"> 2 Match Times </label>
                    <input type="time" id="matchTimes" name="secondtime" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="matchTimes" class="form-label"> 3 Match Times</label>
                    <input type="time" id="matchTimes" name="thirdtime" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="matchDayInterval" class="form-label">Match Day Interval (in days)</label>
                    <input type="number" id="matchDayInterval" name="matchDayInterval" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Generate Fixtures</button>
            </form>
        </div>
    </div>
</div>
<script>
    // JavaScript to set the min attribute to tomorrow's date
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('startDate');
        const today = new Date();
        today.setDate(today.getDate() -30); // Add one day to the current date
        const tomorrow = today.toISOString().split('T')[0];
        dateInput.setAttribute('min', tomorrow);
    });
</script>

@endsection
