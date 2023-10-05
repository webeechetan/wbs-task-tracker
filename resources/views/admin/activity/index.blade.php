@extends('admin.layouts.app')
@section('title', 'Activities List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection


<style>
    .completed-task {
        color: black;
        text-decoration: line-through;
        text-decoration-thickness: 2px;
    }
</style>

@section('content')

<!-- Add Product -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="d-flex align-items-center">
            <div class="avatar me-2">
                <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-task'></i></span>
            </div>
            All Activity
        </h4>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBoth" aria-controls="offcanvasBoth"><i class='bx bx-plus'></i> Add Activity</button>
        <!-- Offcanvas -->
   
        <div class="offcanvas offcanvas-end show" data-bs-scroll="true" tabindex="-1" id="offcanvasBoth" aria-labelledby="offcanvasBothLabel" style="visiblity: visible;">
            <div class="offcanvas-header border-bottom py-3 my-1">
                <h5 id="offcanvasBothLabel" class="offcanvas-title">Add Activity</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                    <form action="{{ route('activity-store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cron_string" id="cron_string">
                        <div>
                            <label for="activity" class="form-label">Activity Name</label>
                            <input type="text" class="form-control" id="activity" name="activity" placeholder="Activity">
                            @error('activity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="team" class="form-label">Team</label>
                            <select class="form-select" id="team" name="team">
                                <option value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>                      
                        <div class="mt-3">
                            <label for="activity">First Due Date</label>
                            <input type="date" class="form-control" id="first_due_date" name="first_due_date">
                            @error('first_due_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                      
                                      
                        <div class="mt-3">
                            <label for="activity">Schedule On</label>
                            <div class="input-group">                                      
                                <select class="form-control" name="cron_day[]" id="cron_day" multiple>
                                    @php
                                        $currentDate = now();
                                        $lastDay = $currentDate->daysInMonth;
                                    @endphp
                                    @for ($day = 1; $day <= $lastDay; $day++)
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endfor
                                </select>
                                
                            </div>
                        </div>

                        @php 
                        $months = ['All' => '*', 'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
                        @endphp

                        <div class="mt-3">
                            <label for="month">Month</label>
                            <div class="input-group">
                                <select class="form-control mt-3" name="cron_month[]" id="cron_month" multiple>
                                    <option value="">Month</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{$month}}">{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <b><span class="text-success cron_output"></span></b>
                        @error('cron_command')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="mt-3">
                            <label for="assign_to" class="col-form-label">Assign to</label>
                            <select class="form-control" id="assign_to" name="assign_to[]"  multiple>
                                <option value="">Assign to</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3 reminder_date_div first-div">
                            <label for="activity">Reminder Date</label>
                            <input type="date" class="form-control" name="second_due_date[]">
                            @error('second_due_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                                <button type="button" class="btn btn-primary add-more">+</button>
                                <button type="button" class="btn btn-danger remove">-</button>
                        </div>

                       
                        <!-- Additional form fields go here -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                {{-- </div> --}}
            </div>
        </div>
        
    </div>
</div>





<div class="card">
    <h5 class="card-header">Activities</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover" id="activityTable">
            <thead>
                <tr>
                    <th></th>
                    <th>Team</th>
                    <th>Activity</th>
                    <th>Assigned To</th>
                    <th>First Due Date</th>
                    <th>Second Due Date</th>
                    <th>Manager</th>
                    <th>Status</th>
                    <th>Schedule On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($activities as $activity)
                    <tr>
                        <td>
                            <input class="form-check-input mark_complete_activity" data-task='{{ json_encode($activity)}}' type="checkbox" @checked($activity->status == 'completed')>
                        </td>
                        <td>
                            {{ $activity->team->name }}
                        </td>
                        <td>{{ $activity->name }}</td>
                        <td>
                            @foreach ($activity->assignedUsers as $user)
                                <span class="badge bg-primary">{{ $user->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $activity->first_due_date }}</td>
                        <td>{{ $activity->second_due_date }}</td>
                        <td>{{ $activity->team->lead->name }}</td>
                        <td>
                            @if ($activity->status == 'pending')
                                <span class="badge bg-danger">Pending</span>
                            @elseif($activity->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                        <td> <small> {{ $activity->cron_string }}</small></td>
                        <td> <button class="btn btn-primary btn-sm edit_task"><i class='bx bx-edit'></i></button>
                            <form action="{{route('activity-destroy', $activity->id)}}" method="POST" class="d-inline delete_form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>


@endsection

@section('scripts')

<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/cronstrue@latest/dist/cronstrue.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    let flatDate = flatpickr('#due_date', {
        dateFormat: 'Y-m-d' 
    });


    $(document).ready(function() {

        
         $(".select2").select2();
      
        let table = $('#activityTable').DataTable({
            responsive: true,
        });

        // $('#cron_month').select2({
        //     placeholder: "Select Month",
        //     allowClear: true,
        //     // seap
        // });

        $('#cron_month').change(function(){
            generateCronStringFromCommand();
        });

        $("#cron_day").select2({
            placeholder: "Select Day",
             tags: true,
            tokenSeparators: [',', ' ']
        });

        $('#cron_day').change(function(){
            generateCronStringFromCommand();
        });

       function generateCronStringFromCommand(){
            let cron_month = $('#cron_month').val();
            console.log(cron_month);
            let cron_day = $('#cron_day').val();
            let cron_command = `30 10 ${cron_day} ${cron_month} *`;
            let cron_output = cronstrue.toString(cron_command);
            $('.cron_output').text(cron_output);
            $('#cron_string').val(cron_output);
       }

        $('#assign_to').select2({
            placeholder: "Assign To",
            allowClear: true
        });

    });

    function generateDayOptions() {
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-based
        const daysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        const daySelect = $('#cron_day');

        // Clear existing options
        daySelect.empty();

        // Populate with day options
        for (let day = 1; day <= daysInMonth; day++) {
            daySelect.append(new Option(day, day));
        }
    }

    // Initialize the day dropdown based on the current month
    generateDayOptions();

    $('.mark_complete_activity').change(function () {

       
           
            var activityData = ($(this).data('activity'));
            let activity_status = activityData.status;
            console.log(activity_status);
            $.ajax({
                type: 'POST',
                url: '/activity/activity-statusupdate/' + activityData.id,
                data: {
                    "_token": "{{ csrf_token() }}",
                    taskId: activityData.id,
                    status: activity_status
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





        $(document).on('click', '.add-more', function() {
            var clonedDiv = $(this).closest('.reminder_date_div').clone();
            clonedDiv.find('input[type="date"]').val('');
            clonedDiv.find('.add-more').remove();
            clonedDiv.find('.remove').css('display', 'inline-block'); // Show the minus button
            $(this).closest('.reminder_date_div').after(clonedDiv);
        });

        // Handler for the minus button
        $(document).on('click', '.remove', function() {
            if ($(this).closest('.reminder_date_div').index() > 0) {
        $(this).closest('.reminder_date_div').remove();
    }
    
        });




        $(".delete_form").submit(function(e) {
            e.preventDefault();
            let form = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this Activity!",
                icon: 'warning',
                iconColor: '#1fb37a',
                showCancelButton: true,
                confirmButtonColor: '#1fb37a',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.unbind('submit').submit();
                }
            });

        });
       

</script>


@endsection

