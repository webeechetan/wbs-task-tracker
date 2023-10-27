@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('content')

<div class="card">
    <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover mb-3" id="member_tasks">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Client</th>
                            <th>Project</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

           
                        @foreach ($tasks as $task)
                            <tr class=" @if($task->status == 'completed') completed-task @endif ">
                                
                                <td>{{$task->name}}</td>
                                <td>{{$task->client->name}}</td>
                                <td>{{$task->project->name}}</td>
                                <td>
                                    @if($date->isPast())
                                    <span class="text-danger">{{ $date->format('d-m-Y') }}</span>
                                    @else
                                    <span class="text-success">{{ $date->format('d-m-Y') }}</span>
                                    @endif
                                </td>
                                <td>{{ $task->status }}</td>

                                
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function () {
        let table = $('#member_tasks').DataTable({
            responsive: true,
           
        });

        // seclect2 for client
    });
</script>




@endsection