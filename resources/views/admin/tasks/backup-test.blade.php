@extends('admin.layouts.app')
@section('title', "Todo's List")

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
    <h3 class="title">Todo's</h3>
</div>


{{-- //////////Test/////////////// --}}
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h4><b>Wed, 04-10-2023</b></h4>
                <b>Total Task : </b><br>
                <b>Pending Task: </b><br>
                <a href=""><button class="btn btn-action btn-primary btn-sm">View</button></a>
            </div>
        </div>
    </div>
</div>


{{-- //////////////Test////////////////// --}}

{{-- ////////Calander view/////////// --}}

<div class="row">
    <div class="col-md-4">
        <div class="row">
            @foreach($calanderData as $data)
                <div class="col-md-6 MB-3">
                    <a href="{{route('task-index',['date'=> $data['date']])}}" class="calendar-box">
                        <div class="card mt-2 text-center">
                            <div class="card-body calendar-card">
                                <div class="calender-view">
                                    <div><span class='bx bx-calendar'></span></div>
                                    <div class="card-text calendar-info">
                                        <div>{{ $data['date'] }}</div>
                                      
                                    </div>
                                </div>
                                <div class="badge bg-primary mt-2"> Total Task:-{{ $data['tasks']->count() }}</div>
                                {{-- <div class="badge bg-primary mt-2"> P Task:{{ $data['tasks']->count() }}</div> --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
        <div class="card-header client-project-header">
            <form method="POST" action="{{ route('task-store') }}" id="todo_task_add_form">
                @csrf
                <input type="hidden" name="taskId" id="taskId">
                <div class="d-flex justify-content-between align-items-center task-form">

                    <div class="mb-3 mb-md-0 task-group">
                        <div class="form-group">
                            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name"
                                required>
                        </div>
                    </div>

                    <div class="mb-3 mb-md-0 task-group">
                        <div class="form-group">
                            <select class="form-control select-control" id="project_name" name="project_name">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="task-group">
                        <div class="form-group">
                            <button type="submit" id="action_btn" class="btn btn-primary action_btn">Add Task</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
        <div class="card task-table">
            
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover mb-3" id="tasksTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Task</th>
                                <th>Client</th>
                                <th>Project</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($tasks as $task)
                            <tr class=" @if($task->status == 'completed') completed-task @endif   task-id-{{ $task->id }}">
                                <td>
                                    @if($task->status == 'completed')
                                        <i class='toggle-icon bx bxs-checkbox-checked icon-id-{{ $task->id }}' onclick="changeStatus({{$task->id}})"></i>  
                                    @else
                                        <i class='toggle-icon bx bxs-checkbox icon-id-{{ $task->id }}' onclick="changeStatus({{$task->id}})"></i>  
                                    @endif          
                                </td>
                                <td>{{$task->name}}</td>
                                <td>{{$task->client->name}}</td>
                                <td>{{$task->project->name}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit_task edit_team"
                                        data-task='{{ json_encode($task) }}'><i class='bx bx-edit'></i></button>
                                    <form action="{{route('task-destroy',$task->id)}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class='bx bxs-trash'></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row">
    @foreach($calanderData as $data)
        <div class="col-md-3">
            <a href="{{route('task-index',['date'=> $data['date']])}}" class="calendar-box">
                <div class="card mt-2 text-center">
                    <div class="card-body">
                        <div class="calender-view">
                            <div><span class='bx bx-calendar'></span></div>
                            <div class="card-text calendar-info">
                                <div>{{ $data['date'] }}</div>
                                <div>{{ $data['tasks']->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

</div> -->

{{--Calander view//////////////// --}}

<!-- <div class="card mt-5">
    <div class="card-header">

        <form method="POST" action="{{ route('task-store') }}" id="todo_task_add_form">
            @csrf
            <input type="hidden" name="taskId" id="taskId">
            <div class="d-flex justify-content-between align-items-center task-form">

                <div class="mb-3 mb-md-0 task-group">
                    <div class="form-group">
                        <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name"
                            required>
                    </div>
                </div>

                <div class="mb-3 mb-md-0 task-group">
                    <div class="form-group">
                        <select class="form-control select-control" id="project_name" name="project_name">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="task-group">
                    <div class="form-group">
                        <button type="submit" id="action_btn" class="btn btn-primary action_btn">Add Task</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-3" id="tasksTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Task</th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($tasks as $task)
                    <tr class=" @if($task->status == 'completed') completed-task @endif   task-id-{{ $task->id }}">
                        <td>
                            @if($task->status == 'completed')
                                <i class='toggle-icon bx bxs-checkbox-checked icon-id-{{ $task->id }}' onclick="changeStatus({{$task->id}})"></i>  
                            @else
                                <i class='toggle-icon bx bxs-checkbox icon-id-{{ $task->id }}' onclick="changeStatus({{$task->id}})"></i>  
                            @endif          
                        </td>
                        <td>{{$task->name}}</td>
                        <td>{{$task->client->name}}</td>
                        <td>{{$task->project->name}}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit_task edit_team"
                                data-task='{{ json_encode($task) }}'><i class='bx bx-edit'></i></button>
                            <form action="{{route('task-destroy',$task->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class='bx bxs-trash'></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> -->
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


   function changeStatus(id){
        $(".task-id-"+id).addClass('blur-table-row');

        $.ajax({
            type: 'POST',
            url: '{{ route("task-statusupdate") }}/'+id,
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
            },
            success: function (response) {
                if(response.success){

                    if(response.data.status == 'completed'){
                        $(".task-id-"+id).addClass('completed-task');
                        $(".icon-id-"+id).removeClass('bxs-checkbox');
                        $(".icon-id-"+id).addClass('bxs-checkbox-checked');
                    }else{
                        $(".task-id-"+id).removeClass('completed-task');
                        $(".icon-id-"+id).removeClass('bxs-checkbox-checked');
                        $(".icon-id-"+id).addClass('bxs-checkbox');
                    }

                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
        $(".task-id-"+id).removeClass('blur-table-row');
   }


    $(document).ready(function () {

        $('.card').click(function () {
            $(this).find('.card-body').toggleClass('active');
        });

        $('#iconCell').click(function () {
        $('#myIcon').toggleClass('fa-star fa-check');
    });
        let table = $('#tasksTable').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">'
        });

        // seclect2 for client

        let client = $('#client').select2({
            placeholder: "Select Client",
            allowClear: true,
            tags: true,
            height: '100%',
        });

        $(".edit_task").on('click', function (e) {
            e.preventDefault();
            let task = $(this).data('task');
            console.log(task);

            $('#task_name').val(task.name);
            $('#client').select2().val(task.client).trigger('change');
            $('#project_name').val(task.project_id);
            $('#taskId').val(task.id);
            $('.action_btn').html('Update');
            let taskId = $('#taskId').val();
            if (taskId) {
                var url = "{{ route('task-update') }}";
                url = url.replace(':id', taskId);
            } else {
                var url = "{{ route('task-store') }}";
            }
            let todoForm = $('#todo_task_add_form');
            todoForm.attr('action', url);
        });

        $('.mark_complete_task').change(function () {
            // $(this).closest('tr').toggleClass('completed-task');
            var taskData = ($(this).data('task'));
            let task_status = taskData.status;
            console.log(task_status);
            $.ajax({
                type: 'POST',
                url: '/tasks/status_update/' + taskData.id,
                data: {
                    "_token": "{{ csrf_token() }}",
                    taskId: taskData.id,
                    status: task_status
                },
                success: function (response) {
                    location.reload();
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });


    });
</script>


@endsection