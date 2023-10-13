
@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')
<div class="container">
    @php
        $currentDay = $currentDate->day;
    @endphp
 


 <div class="container">
    @for ($day = 1; $day <= $currentDate->format('d'); $day++)
        @php
            $date = date('Y-m-d', strtotime("{$currentDate->year}-{$currentDate->month}-$day"));
            $dayName = date('l', strtotime($date));
        @endphp
        @if ($dayName !== 'Saturday' && $dayName !== 'Sunday')
        
        <a href="{{route('member_tasks', ['id' => $id, 'date' => $date])}}">    
            <div class="card">
                <div class="card-body">
                    <h3 class="card-text">
                        {{ $dayName }}
                        {{ $date }}
                    </h3>
                </div>
            </div>
        </a>
            <br>
        @endif
    @endfor
</div>




@endsection
