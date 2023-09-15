@extends('admin.layouts.app')
@section('title', 'Tasks List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')

<form method="POST" action="{{ route('task-store') }}" id="todo_task_add_form">

    @csrf

    <div class="row mt-5" style="background-color: #E5E4E2; padding: 20px;" id="parent">

        <div class="form-group col-md-3">
            <input type="date" class="form-control" id="due_date" placeholder="Due Date" name="due_date" required>
        </div>

        <div class="form-group col-md-3">
            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Task Name" required>
        </div>

        <div class="form-group col-md-3">
            <select class="form-control" id="project_id" name="project_id">

                <option value="">Select Task</option>
                <option value="1">Acma</option>
                <option value="2">Swift</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <button type="submit" id="action_btn" class="btn btn-primary action_btn">Add Task</button>
        </div>
    </div>

</form>


<div class="row mt-5">
    <div class="table-responsive text-nowrap">
        <div class="container">
            <table class="table table-hover" id="tasksTable">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Project</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach ($tasks as $task)

                    <tr>
                        <td>{{$task->name}}</td>
                        <td>{{$task->project_id}}</td>
                        <td>{{$task->due_date}}</td>
                        <td>{{ $task->status }}</td>

                        <td>
                            <button class="btn btn-primary btn-sm edit_task" data-task='{{ json_encode($task) }}'><i class='bx bx-edit' ></i></button>
                            <form action="{{route('task-destroy',$task->id)}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bxs-trash' ></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr
    flatpickr('#due_date', {
        dateFormat: 'Y-m-d' // Customize date format as needed
    });


    $(document).ready(function() {

        let table = $('#tasksTable').DataTable({
            responsive: true,
        });

        $(".edit_task").on('click', function(e) {
            e.preventDefault();

            let task = $(this).data('task');

            // console.log(task);

            $('#due_date').val(task.due_date);
            $('#task_name').val(task.name);
            $('#project_id').val(task.project_id);

            $('.action_btn').html('Update');


        });

    });
</script>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const addTaskForm = document.getElementById('todo_task_add_form');
    //     const updateTaskForm = document.getElementById('todo_task_update_form');
    //     const showAddFormButton = document.getElementById('action_btn');
    //     const showUpdateFormButton = document.getElementById('action_btn_update');

    //     // Show the "Add Task" form and hide the "Update Task" form
    //     showAddFormButton.addEventListener('click', function() {
    //         addTaskForm.style.display = 'block';
    //         updateTaskForm.style.display = 'none';
    //     });

    //     // Show the "Update Task" form and hide the "Add Task" form
    //     showUpdateFormButton.addEventListener('click', function() {
    //         addTaskForm.style.display = 'none';
    //         updateTaskForm.style.display = 'block';
    //     });
    // });
</script>


@endsection