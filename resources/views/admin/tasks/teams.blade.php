
@extends('admin.layouts.app')
@section('title', "Team's Todo")

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')

@foreach ($teams as $team)



<h4 class="py-3 mb-4"><span class="text-muted fw-light">Teams</span> </h4>
<!-- Cards with few info -->
        <div class="row">
         
                <div class="col-lg-3 col-sm-6 mb-4">
                    <a href="">
                        <div class="card">
                            <div class="card-body">
                                <div class="team-details">
                                    <div class="team-icons"><span class='bx bx-user'></span></div>
                                   <div class="d-block">
                                       <div class="card-info team-info">
                                            <h5 class="card-text team-employee-name">{{ $team->name}}</h5>
                                        </div>
                                        <div class="team-name mt-2">
                                            <span class="badge bg-primary"> {{ $team->name}}</span>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
           
        </div>
@endforeach

@endsection


