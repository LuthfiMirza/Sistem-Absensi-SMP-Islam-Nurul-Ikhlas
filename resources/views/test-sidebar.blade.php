@extends('layouts.home')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Test Sidebar</h5>
                </div>
                <div class="card-body">
                    <h6>Debugging Sidebar Issues</h6>
                    <p>This page is used to test if the sidebar is working properly.</p>
                    
                    <div class="alert alert-info">
                        <h6>Current User Info:</h6>
                        <ul class="mb-0">
                            <li><strong>Name:</strong> {{ auth()->user()->name }}</li>
                            <li><strong>Role:</strong> {{ auth()->user()->role->name }}</li>
                            <li><strong>Position:</strong> {{ auth()->user()->position->name ?? 'No position' }}</li>
                            <li><strong>Is User:</strong> {{ auth()->user()->isUser() ? 'Yes' : 'No' }}</li>
                            <li><strong>Is Admin/Operator:</strong> {{ auth()->user()->isAdmin() || auth()->user()->isOperator() ? 'Yes' : 'No' }}</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-success">
                        <h6>Available Attendances:</h6>
                        @php
                            $availableAttendances = \App\Models\Attendance::whereHas('positions', function($query) {
                                $query->where('position_id', auth()->user()->position_id);
                            })->get();
                        @endphp
                        
                        @if($availableAttendances->count() > 0)
                            <ul class="mb-0">
                                @foreach($availableAttendances as $attendance)
                                    <li>{{ $attendance->title }} (ID: {{ $attendance->id }})</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mb-0">No attendances available for this user's position.</p>
                        @endif
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('home.index') }}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection