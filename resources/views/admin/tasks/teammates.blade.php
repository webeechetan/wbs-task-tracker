
@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')

@foreach ($teammates as $team)

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Webee Social /</span> {{ $team->name}}</h4>
<!-- Cards with few info -->
    @foreach ($team->members as $member)
        <div class="row">
            <a href="{{ route('member-calander',['id'=>$member->id])}}">
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="card-info">
                                    <h3 class="card-text">{{$member->name}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endforeach

@endsection
