@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endsection

<style>
    .completed-task {
        color: black;
        text-decoration: line-through;
        text-decoration-thickness: 3px;
    }
</style>

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('task-store') }}" id="todo_task_add_form">
            @csrf
            <input type="hidden" name="taskId" id="taskId">
            <div class="row " id="parent">
        
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" id="due_date" placeholder="Due Date" name="due_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
        
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name" required>
                </div>
        
                <div class="form-group col-md-3">
                    <select class="form-control" id="client" name="client">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{$client->client}}">{{$client->client}}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group col-md-3">
                    <button type="submit" id="action_btn" class="btn btn-primary action_btn">Add Task</button>
                </div>
            </div>
        
        </form>
    </div>
</div>


<div class="row mt-5">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="tasksTable">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Client</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
    
                        @foreach ($tasks as $task)
    
                        <tr>
                            <td>{{$task->name}}</td>
                            <td>{{$task->client}}</td>
                            <td>
                                @php 
                                    $date = Carbon\Carbon::parse($task->due_date);
                                @endphp
                                @if($date->isPast())
                                    <span class="text-danger">{{ $date->format('d-m-Y') }}</span>
                                @else
                                    <span class="text-success">{{ $date->format('d-m-Y') }}</span>
                                @endif
                            </td>
                            <td>{{ $task->status }}</td>
    
                            <td>
                                <button class="btn btn-primary btn-sm edit_task" data-task='{{ json_encode($task) }}'><i class='bx bx-edit' ></i></button>
                                <form action="{{route('task-destroy',$task->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class='bx bxs-trash' ></i></button>
                                </form>

                                <input class="form-check-input mark_complete_task" data-task='{{ json_encode($task) }}' type="checkbox" value="" id="flexCheckDefault">
                                <!-- <button type="checkbox" class="btn btn-primary btn-sm mark_complete_task" data-task='{{ json_encode($task) }}'>E</button> -->
                            </td>
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr
    let flatDate = flatpickr('#due_date', {
        dateFormat: 'Y-m-d' // Customize date format as needed
    });


    $(document).ready(function() {
        let table = $('#tasksTable').DataTable({
            responsive: true,
        });

        // seclect2 for client

        let client = $('#client').select2({
            placeholder: "Select Client",
            allowClear: true,
            tags: true,
            height: '100%',
        });

        $(".edit_task").on('click', function(e) {
            e.preventDefault();
            let task = $(this).data('task');
            console.log(task);
            flatDate.setDate(task.due_date);
            $('#task_name').val(task.name);
            $('#client').select2().val(task.client).trigger('change');
            $('#taskId').val(task.id);
            $('.action_btn').html('Update');
            let taskId = $('#taskId').val();
            if(taskId){
                var url = "{{ route('task-update') }}";
                url = url.replace(':id', taskId);
            }else{
                var url = "{{ route('task-store') }}";
            }
            let todoForm = $('#todo_task_add_form');
            todoForm.attr('action', url);
        });

        $('.mark_complete_task').change(function () {
            
            var taskData = ($(this).data('task'));

            if ($(this).is(':checked')) {
                // Checkbox is checked, handle accordingly
                // console.log('Task with ID ' + taskData.id + ' is checked.');
                 $(this).closest('tr').addClass('completed-task');

                $.ajax({
                    type: 'POST',
                    url: '/tasks/status_update/' + taskData.id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        taskId: taskData.id,
                        completed: true
                    },
                    success: function(response) {
                        if (response.success === 'true') {
                            console.log('Success:', response.message);
                          
                        } else {
                            console.log('Error:', response.message);
                       
                        }
                    },
                    error: function(xhr, status, error) {
                       
                        console.error('Error:', error);
                    }
                });


                
                // You can add additional code here to mark the task as complete.
            } else {
                // Checkbox is unchecked, handle accordingly
                console.log('Task with ID ' + taskData.id + ' is unchecked.');
                $(this).closest('tr').removeClass('completed-task');
                
                
                // You can add additional code here to mark the task as incomplete.
            }
        });


    });
</script>


@endsection