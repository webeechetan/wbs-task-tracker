@extends('admin.layouts.app')
@section('title', "Calendar View")

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection
<style>
    .completed-task {
        color: black;
        text-decoration: line-through;
        text-decoration-thickness: 2px;
    }
</style>

@section('content')

<div class="d-flex main-title">
    <h3 class="title">Calendar View</h3>
</div>

<div class="row">
    @foreach($calanderData as $data)
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body text-center">
                    <h5>
                        <b>
                            <div>{{ date('D d M Y', strtotime($data['date'])) }}</div> 
                            @php
                                $today = \Carbon\Carbon::now()->format('Y-m-d');
                                $card_date = \Carbon\Carbon::parse($data['date'])->format('Y-m-d');
                            @endphp
                            @if($today == $card_date)
                                <small>Today</small>
                            @endif
                        </b>
                    </h5>
                    <h6>Total Task:-{{ $data['tasks']->count() }}</h6>
                    <p>Pending : {{ $data['pendingCount'] }} / Completed : {{ $data['completedCount'] }}</p>
                    <a href="{{route('task-index',['date'=> $data['date']])}}"><button class="btn btn-action btn-primary btn-sm">View</button></a>
                </div>
            </div>
        </div>
    @endforeach
</div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@endsection