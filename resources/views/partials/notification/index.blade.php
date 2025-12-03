@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Notifications</h2>

    <div class="card p-3">
        <ul class="list-group">

            {{-- Loop through newly added users --}}
            @forelse ($users as $user)
                <li class="list-group-item">
                    <strong>New User Registered:</strong> 
                    {{ $user->firstnametxt }} {{ $user->lastnametxt }}

                    <span class="text-muted float-end">
                        {{ $user->created_at->diffForHumans() }}
                    </span>
                </li>
            @empty
                <li class="list-group-item text-center text-muted">
                    No recent notifications.
                </li>
            @endforelse

        </ul>
    </div>
</div>
@endsection
