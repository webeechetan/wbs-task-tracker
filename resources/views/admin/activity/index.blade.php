@extends('admin.layouts.app')
@section('title', 'Activities List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/css/rtl/core.css" class="template-customizer-core-css" />

{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/tagify/tagify.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/select2/select2.css" />

<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.css" />
<link rel="stylesheet" href="{{ asset('admin') }}/vendor-pro/libs/typeahead-js/typeahead.css" />
@endsection


<style>
    .completed-task {
        color: black;
        text-decoration: line-through;
        text-decoration-thickness: 2px;
    }
</style>

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('activity-store') }}" method="POST" class="form_activity">
                    @csrf
                    <input type="hidden" name="activityId" id="activityId">

                    <input type="hidden" name="cron_string" id="cron_string">
                    <div class="activities">
                        <!-- Activity Title -->
                        <div class="activities_title">
                            <label for="activity">Activity</label>
                            <input type="text" class="form-control" id="activity" name="activity" placeholder="Activity">
                            @error('activity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Activity Team -->
                        <div class="activities_team">
                            <label for="team">Team</label>
                            <select class="form-control" id="team" name="team">
                                <option value="">Select Team</option>
                                @foreach ($teams as $team)
                                
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Due Date -->
                        <div class="activities_dueDate">
                            <label for="activity">Due Date</label>
                            <input type="date" class="form-control" id="first_due_date" name="first_due_date">
                            @error('first_due_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Schedule On -->
                        <div class="activities_sch">
                            <label for="activity">Schedule On</label>
                            <div class="activities_sch-group">
                                <div>
                                    <select class="select2 form-select" name="cron_day[]" id="cron_day" multiple>
                                        @php
                                            $currentDate = now();
                                            $lastDay = $currentDate->daysInMonth;
                                        @endphp
                                        @for ($day = 1; $day <= $lastDay; $day++)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endfor
                                    </select>

                                    @php 
                                        $months = ['All' => '*', 'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
                                    @endphp
                                </div>

                                <div>
                                    <select class="form-control" name="cron_month[]" id="cron_month" multiple>
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
                        </div>
                        <!-- Assign to -->
                        <div class="activities_assign">
                            <label for="assign_to" class="col-form-label">Assign to</label>
                            <select class="form-control" id="assign_to" name="assign_to[]"  multiple>
                                <option value="">Assign to</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="activity">Reminder Date</label>
                            <input type="date" class="form-control" id="second_due_date" name="second_due_date" class="reminder_date">
                            @error('second_due_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                        <button type="button" class="btn btn-primary add-more mt-3"><b>+</b></button>
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
                        <th>Reminder Date</th>
                        <th>Manager</th>
                        <th>Status</th>
                        <th>Schedule On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($activities as $activity)

                    {{-- // $activity = Activity::find($activity->id); // Replace $activityId with the actual activity ID
                    // $assignedUsers = $activity->assignedUsers; // This returns a collection of related users

                    // $userNames = $activity->assignedUsers->pluck('name')->toArray(); --}}

                    {{-- {{count($activity->assignedUsers)}} --}}
                    
                        <tr class=" @if($activity->status == 'completed') completed-task @endif ">
                            <td>
                                <input class="form-check-input mark_complete_activity" data-activity='{{ json_encode($activity)}}' type="checkbox" @checked($activity->status == 'completed')>
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
                            <td> <button class="btn btn-primary btn-sm edit_activity" data-activity='{{ json_encode($activity)}}'><i class='bx bx-edit'></i></button>
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





<script src="{{ asset('admin') }}/vendor-pro/libs/select2/select2.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/tagify/tagify.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/typeahead-js/typeahead.js"></script>
<script src="{{ asset('admin') }}/vendor-pro/libs/bloodhound/bloodhound.js"></script>
<script src="{{ asset('admin') }}/js/pro/forms-selects.js"></script>
<script src="{{ asset('admin') }}/js/pro/forms-tagify.js"></script>
<script src="{{ asset('admin') }}/js/pro/forms-typeahead.js"></script>
<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    let flatDate = flatpickr('#first_due_date', {
        dateFormat: 'Y-m-d'
    });


    $(document).ready(function() {
         $(".select2").select2();
      
        let table = $('#activityTable').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">'
        });



        $('#cron_month').select2({
            placeholder: "Select Month",
            allowClear: true,
            // seap
        });

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


        var cloneCount = 0;

         // Clone the div when clicking the plus button
        $(document).on('click', '.add-more', function () {
            var $originalDiv = $(this).prev('.form-group');
            var $clonedDiv = $originalDiv.clone();
            $originalDiv.after($clonedDiv);
            cloneCount++;

            // Add a class to the cloned div to distinguish it
            $clonedDiv.addClass('cloned-div');
            $clonedDiv.find('input[type="date"]').val('');
            


        
        
        });

        //Remove the nearest cloned div when clicking the minus button
        $(document).on('click', '.remove', function () {

            if ($('.form_activity .reminder_date').length > 1) {
            
            alert("yes");
        }else{
            alert("no");
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

        
   



    $(".edit_activity").on('click', function (e) {
            e.preventDefault();

            let activityData = $(this).data('activity');
            console.log(activityData);

            flatDate.setDate(activityData.first_due_date);
            $('#activity').val(activityData.name);
            $('#second_due_date').val(activityData.second_due_date);
          
            // $('#assign_to').select2().val(activityData.assignTo).trigger('change');
            // $('#team').select2().val(task.team).trigger('change');
            $('#activityId').val(activityData.id);
            $('.action_btn').html('Update');
            let activityID = $('#activityId').val();

            if($activityID) {
                var url = "{{ route('activity-update')}}";
                url = url.replace(':id',activityID);

            }else {
                var url = "{{ route('activity-store')}}";
            }

        });
       

</script>


@endsection

