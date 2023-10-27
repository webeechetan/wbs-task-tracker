
@extends('admin.layouts.app')
@section('title', "Team's Todo")

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Teams</span> </h4>
<div class="row">
    @foreach ($teams as $team)

    <div class="col-lg-3 col-sm-6 mb-4">
        <a href="">
            <div class="card">
                <div class="card-body">
                    <div class="team-details">
                        <div class="team-icons"><span class='bx bx-user'></span></div>
                        <div class="d-block">
                            <div class="card-info team-info">
                                <h5 class="card-text team-employee-name">{{ $team->name}} ({{ucfirst($team->lead->name)}})</h5>
                            </div>
                            <div class="mt-2">
                                @foreach($team->members as $member)
                                    <a href="{{ route('member-calander',$member->id) }}">
                                        <span class="badge bg-primary badge-sm">
                                            {{ $member->name }} :
                                            {{ $member->tasks->count() }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <h6>Activities</h6>
                                <a href="{{ route('activity-pending') }}"><span class="text-danger">Pending : {{ $team->activities->where('status', 'pending')->count()}} </span></a>
                                <a href="{{ route('activity-completed') }}"><span class="">Completed : {{ $team->activities->where('status', 'completed')->count() }} </span></a>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    @endforeach
</div>

@endsection


