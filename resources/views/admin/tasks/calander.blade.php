
@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')

    @php
        $currentDay = $currentDate->day;
    @endphp
 
 <h5>Calender View ({{ $user->name }})</h5>

<div class="row">

    @for ($day = 1; $day <= $currentDate->format('d'); $day++)

        @php
            $date = date('Y-m-d', strtotime("{$currentDate->year}-{$currentDate->month}-$day"));
            $dayName = date('l', strtotime($date));
        @endphp
        @if ($dayName !== 'Saturday' && $dayName !== 'Sunday')
            <div class="col-md-3">
                <a href="{{route('member_tasks', ['id' => $user->id, 'date' => $date])}}" class="calendar-box">    
                    <div class="card mt-2 text-center">
                        <div class="card-body">
                            {{-- <h5 class="card-text">
                                {{ $dayName }}
                            </h5>
                            <p>{{ $date }}</p> --}}
                            <div class="calender-view">
                                <div><span class='bx bx-calendar'></span></div>
                                <div class="card-text calendar-info">
                                   <div>{{ $dayName }}</div>
                                   <div> {{ $date }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
                
    @endfor
           
</div>
  
    




@endsection
