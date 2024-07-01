@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Players</h1>
                
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search input -->
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for players...">

                <!-- Rows per page selection -->
                <form id="rowsPerPageForm" class="form-inline mb-3">
                    <label for="perPage" class="mr-2">Rows per page:</label>
                    <select id="perPage" name="perPage" class="form-control" onchange="document.getElementById('rowsPerPageForm').submit();">
                        @for ($i = 20; $i <= $players->total(); $i += 5)
                            <option value="{{ $i }}" {{ $i == $perPage ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <!-- Table for Authenticated Users -->
                @auth
                <h2>Authenticated Users</h2>
                <table class="table table-bordered" id="playersTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Team</th>
                            <th>Goals</th>
                            <th>Red Cards</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $loop->iteration + ($players->currentPage() - 1) * $players->perPage() }}</td>
                                <td class="player-name">{{ $player->name }}</td>
                                <td>{{ $player->team->name }}</td>
                                <td>{{ $player->goals }}</td>
                                <td>{{ $player->red_cards }}</td>
                                <td>
                                    <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this player record?')" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {{ $players->appends(['perPage' => $perPage])->links('vendor.pagination.custom') }}
                    </div>
                </div>
                <a href="{{ route('players.create') }}" class="btn btn-primary mt-3">Add New Player</a>
                @endauth

                <!-- Table for Guests -->
                @guest
                <h2>Guests</h2>
                <table class="table table-bordered" id="playersTableGuest">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Team</th>
                            <th>Goals</th>
                            <th>Red Cards</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $loop->iteration + ($players->currentPage() - 1) * $players->perPage() }}</td>
                                <td class="player-name">{{ $player->name }}</td>
                                <td>{{ $player->team->name }}</td>
                                <td>{{ $player->goals }}</td>
                                <td>{{ $player->red_cards }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {{ $players->appends(['perPage' => $perPage])->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#playersTable tbody tr, #playersTableGuest tbody tr');
        
        rows.forEach(row => {
            let playerName = row.querySelector('.player-name').textContent.toLowerCase();
            if (playerName.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
