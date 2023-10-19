@php 
$user = auth()->user();
$userType = $user->type;

@endphp 

@extends('admin.layouts.app')
@section('title', 'Activities List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/css/rtl/core.css" class="template-customizer-core-css" />

{{--
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/tagify/tagify.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/select2/select2.css" />

<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/typeahead-js/typeahead.css" />
@endsection

@section('content')

<!-- Add Product -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    {{-- <div class="d-flex flex-column justify-content-center"> --}}
        <h4 class="d-flex align-items-center">
            All Activity
        </h4>
        
    {{-- </div> --}}
    <div class="d-flex align-content-center flex-wrap gap-3">

        <a class="btn btn-primary btn-sm" href="{{route('activity-index')}}">All</a>
        <a class="btn btn-primary btn-sm" href="{{route('activity-pending')}}">Pending</a>
        <a class="btn btn-primary btn-sm" href="{{route('activity-completed')}}">Completed</a>
   

        @if($userType == 1 || $userType ==2)
        <button class="btn btn-primary add_activity btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBoth"
            aria-controls="offcanvasBoth"><i class='bx bx-plus'></i> Add Activity</button>
            @endif
        <!-- Offcanvas -->

        <div class="offcanvas offcanvas-end " data-bs-scroll="true" tabindex="-1" id="offcanvasBoth"
            aria-labelledby="offcanvasBothLabel" style="visiblity: visible;">
            <div class="offcanvas-header border-bottom py-3 my-1">
                <h5 id="offcanvasBothLabel" class="offcanvas-title">Add Activity</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form action="{{ route('activity-store') }}" method="POST" id="activity_add_form">
                    @csrf
                    <input type="hidden" name="activityId" id="activityId">
                    <input type="hidden" name="cron_string" id="cron_string">

                    <div>
                        <label for="activity" class="form-label">Activity Name</label>
                        <input type="text" class="form-control" id="activity" name="activity" placeholder="Activity" required>
                        @error('activity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="team" class="form-label">Team</label>

                        <select class="form-control" id="team" name="team" required>
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
                        <label for="assign_to" class="col-form-label">Assign to</label>
                        <select class="form-control" id="assign_to" name="assign_to[]" multiple required>
                            <option value="">Assign to</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mt-3">
                        <label for="activity">Due Date</label>
                        <input type="date" class="form-control" id="first_due_date" name="first_due_date" required>
                        @error('first_due_date')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                   <div class="d-flex column-gap-2 justify-content-between">
                        <div class="mt-3">
                                <label for="activity">Recurring On</label>
                                <div class="input-group schedule">
                                    <select class="form-control" name="cron_day[]" id="cron_day" multiple required>
                                        @php
                                        $currentDate = now();
                                        $lastDay = $currentDate->daysInMonth;
                                        @endphp
                                        @for ($day = 1; $day <= $lastDay; $day++) <option value="{{ $day }}">{{ $day }}</option>
                                            @endfor
                                    </select>

                                </div>
                            </div>

                            @php
                            $months = ['All' => '*', 'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6,
                            'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
                            @endphp

                            <div class="mt-3">
                                <label for="month">Month</label>
                                <div class="input-group month">
                                    <select class="form-control mt-3" name="cron_month[]" id="cron_month" multiple>
                                        <option value="">Month</option>
                                        @foreach ($months as $key => $month)
                                        <option value="{{$month}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                   </div>
                    <b><span class="text-success cron_output"></span></b>
                    @error('cron_command')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    
                    {{-- <div class="reminders">
                        <div class="mt-3">
                            <label for="activity">Reminder Date</label>
                            <input type="date" class="form-control" id="reminder_dates" name="reminder_date">
                        </div>
                    </div> --}}

                    <div class="reminders">
                        <div class="mt-3">
                            <label for="activity">Reminder Date</label>
                            
                            <select class="form-control" name="reminder_date[]" id="reminder_dates" multiple required>
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

                    <!-- Additional form fields go here -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary action_btn">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<div class="card">
    <h5 class="card-header">Activities</h5>
    <div class="card-body">
        {{-- <div class="filter-form">
            <form action="" method="GET">
                <div class="input-group">
                    @foreach($teams as $team)
                        <label for="">{{ $team->name }}</label>
                        <input class="form-check-input" type="checkbox" name="team[]" value="{{ $team->id }}" @if(isset($_GET['team']) && in_array($team->id, $_GET['team'])) checked @endif>
                    @endforeach
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>
            </form>
        </div> --}}
        <div class="table-responsive text-nowrap">
            <table class="table mb-3 table-hover" id="activityTable">
                <thead>
                    <tr>
                        <th></th>
                       
                        <th>Activity</th>
                        <th>Team</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Reminders</th>
                        {{-- <th>Manager</th> --}}
                        <th>Status</th>
                        <th>Schedule On</th>
    
                        @if($userType == 1 || $userType == 2)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($activities as $activity)
                    <tr class=" @if($activity->status == 'completed') completed-task @endif ">
                        <td>
                            <input class="form-check-input mark_complete_activity"
                                data-activity='{{ json_encode($activity)}}' type="checkbox" @checked($activity->status ==
                            'completed')>
                        </td>
                       
                        <td>{{ $activity->name }}</td>
                        <td>
                            {{ $activity->team->name }}
                        </td>
                        <td>
                            @foreach ($activity->assignedUsers as $user)
                            <span class="badge bg-primary">{{ $user->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $activity->first_due_date }}</td>
                        <td>
                            @foreach ($activity->reminders as $reminder)
                                <span class="badge bg-primary">
                                    {{ \Carbon\Carbon::parse($reminder->reminder_date)->format('d') }}
                                </span>
                            @endforeach
                        </td>
                        {{-- <td>{{ $activity->team->lead->name }}</td> --}}
                        <td>
                            @if ($activity->status == 'pending')
                            <span class="badge bg-danger">Pending</span>
                            @elseif($activity->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                            @endif
                        </td>
                        <td> <small> {{ $activity->cron_string }}</small></td>
    
                        @if($userType == 1 || $userType == 2)
                        <td>
                            <button class="btn btn-primary btn-sm edit_activity"
                                data-activity='{{ json_encode($activity)}}'><i class='bx bx-edit'></i></button>
                            <form action="{{route('activity-destroy', $activity->id)}}" method="POST"
                                class="d-inline delete_form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                            </form>
                        </td>
                        @endif
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
<script src="https://unpkg.com/cronstrue@latest/dist/cronstrue.min.js" async></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>





<script src="{{ asset('admin') }}/vendor-pro/libs/select2/select2.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/tagify/tagify.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/typeahead-js/typeahead.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/bloodhound/bloodhound.js"></script>
<script src="{{ asset('admin') }}/js/pro/forms-selects.js"></script>
{{-- <script src="{{ asset('admin') }}/js/pro/forms-tagify.js"></script>
<script src="{{ asset('admin') }}/js/pro/forms-typeahead.js"></script> --}}



<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://momentjs.com/downloads/moment.js" ></script>

{{--
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    let flatDate = flatpickr('#first_due_date', {
        dateFormat: 'Y-m-d'
    });

    $(document).ready(function () {

        $(".add_activity").click(function(){
            let activity = $('#activity').val();
            $('#offcanvasBothLabel').text('Add Activity');
            if(activity.length >= 1){
                $('#activity_add_form').trigger("reset");
                $('#team').val([]).trigger('change');
                $('#assign_to').val([]).trigger('change');
                $('#cron_month').val([]).trigger('change');
                $('#cron_day').val([]).trigger('change');
                $('#reminder_dates').val('').trigger('change');
            }

        });

        $(".select2").select2();

        let table = $('#activityTable').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">'
        });

        $('#cron_month').select2({
            placeholder: "Select Month",
            allowClear: true,
        });

        $("#cron_day").select2({
            placeholder: "Select Day",
            tags: true,
            tokenSeparators: [',', ' ']
        });

        let reminder_dates = $("#reminder_dates").select2({
            placeholder: "Select Day",
            tags: true,
            tokenSeparators: [',', ' ']
        });
        

        $('#cron_month').change(function () {
            generateCronStringFromCommand();
        });

        $('#cron_day').change(function () {
            generateCronStringFromCommand();
        });

        function generateCronStringFromCommand() {
            let cron_month = $('#cron_month').val();
            let cron_day = $('#cron_day').val();
            if(cron_month.length == 0 || cron_month == '' || cron_month == null ){
                cron_month = '*';
            }
            if(cron_day.length == 0 || cron_day == '' || cron_day == null){
                cron_day = '*';
            }
            let cron_command = `30 10 ${cron_day} ${cron_month} *`;
            let cron_output = cronstrue.toString(cron_command);
            $('.cron_output').text(cron_output);
            $('#cron_string').val(cron_output);
        }


        let team = $('#team').select2({
            placeholder: "Team",
            allowClear: true,
            height: '100%',
        });

        let assignTo = $('#assign_to').select2({
            placeholder: "Assign To",
            tags: true,
            allowClear: true
        });

        $(".edit_activity").on('click', function (e) {
            e.preventDefault();
            let activityData = $(this).data('activity');

            $('#offcanvasBoth').offcanvas('show');
            $('#activityId').val(activityData.id);
            $('#cron_string').val(activityData.cron_string);
            $('#activity').val(activityData.name);
            $('#team').val(activityData.team_id).trigger('change');
            $('#first_due_date').val(activityData.first_due_date);

            let assignedUsers = activityData.assigned_users;
            let assignedUsersArray = [];
            assignedUsers.forEach(user => {
                assignedUsersArray.push(user.id);
            });
            $('#assign_to').val(assignedUsersArray).trigger('change');

            let reminders = activityData.reminders;
            let reminders_dates_array = [];

            reminders.forEach(reminder => {
                let reminder_date = moment(reminder.reminder_date).format('D');
                reminders_dates_array.push(reminder_date);
            });

            $('#reminder_dates').val(reminders_dates_array).trigger('change');

            let cron_day = activityData.cron_expression;
            let cron_day_array = cron_day.split(' ');
            let cron_days = cron_day_array[2];
            let cron_days_array = cron_days.split(',');

            let cron_month = activityData.cron_expression;
            let cron_month_array = cron_month.split(' ');
            let cron_months = cron_month_array[3];
            let cron_months_array = cron_months.split(',');
            $('#cron_day').val(cron_days_array).trigger('change');
            $('#cron_month').val(cron_months_array).trigger('change');

            $('.action_btn').text('Update');
            $('#offcanvasBothLabel').text('Update Activity');
            $('#activity_add_form').attr('action', '{{ route("activity-update") }}');



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



    function generateDayOptions() {
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-based
        const daysInMonth = new Date(currentDate.getFullYear(), currentMonth, 0).getDate();
        const daySelect = $('#reminder_dates');

        // Clear existing options
        daySelect.empty();

        // Populate with day options
        for (let day = 1; day <= daysInMonth; day++) {
            daySelect.append(new Option(day, day));
        }
    }

    // delete reminder on click

    $('.reminders').on('click', '.delete_reminder', function () {
        $(this).parent('div').remove();
    });




    $(".delete_form").submit(function (e) {
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


    $('.mark_complete_activity').change(function () {
        var activityData = ($(this).data('activity'));
        console.log(activityData);
        let activity_status = activityData.status;
        console.log(activity_status);
        $.ajax({
            type: 'POST',
            url: '/activities/status_update/' + activityData.id,
            data: {
                "_token": "{{ csrf_token() }}",
                activityId: activityData.id,
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

});

    


</script>


@endsection