@extends('admin.layouts.app')
@section('title', 'Activities List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

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
                <div>
                    <label for="defaultFormControlInput" class="form-label">Activity Name</label>
                    <input type="text" class="form-control" id="defaultFormControlInput" placeholder="John Doe" aria-describedby="defaultFormControlHelp" fdprocessedid="a5svo">
                    <div id="defaultFormControlHelp" class="form-text">We'll never share your details with anyone else.</div>
                </div>
                <div class="mt-3">
                    <label for="" class="form-label">Team</label>
                    <select id="xyz12" class="select2 form-select" multiple>
                        <optgroup label="Alaskan/Hawaiian Time Zone">
                        <option value="AK">Alaska</option>
                        <option value="HI">Hawaii</option>
                        </optgroup>
                        <optgroup label="Pacific Time Zone">
                        <option value="CA">California</option>
                        <option value="NV">Nevada</option>
                        <option value="OR">Oregon</option>
                        <option value="WA">Washington</option>
                        </optgroup>
                        <optgroup label="Mountain Time Zone">
                        <option value="AZ">Arizona</option>
                        <option value="CO" selected>Colorado</option>
                        <option value="ID">Idaho</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NM">New Mexico</option>
                        <option value="ND">North Dakota</option>
                        <option value="UT">Utah</option>
                        <option value="WY">Wyoming</option>
                        </optgroup>
                        <optgroup label="Central Time Zone">
                        <option value="AL">Alabama</option>
                        <option value="AR">Arkansas</option>
                        <option value="IL">Illinois</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="OK">Oklahoma</option>
                        <option value="SD">South Dakota</option>
                        <option value="TX">Texas</option>
                        <option value="TN">Tennessee</option>
                        <option value="WI">Wisconsin</option>
                        </optgroup>
                        <optgroup label="Eastern Time Zone">
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL" selected>Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="IN">Indiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="OH">Ohio</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WV">West Virginia</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-5">
            <div class="card-body">
                <form action="{{ route('activity-store') }}" method="POST">
                    @csrf
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
                                    {{-- <input type="text"  class="form-control" placeholder="Day" name="cron_day" id="cron_day"> --}}

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
                                
                                {{-- <input type="text"  class="form-control" placeholder="Month" name="cron_month" id="cron_month"> --}}
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
                        <!-- Submit -->
                        <div class="activities_submit">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create New Activity</h5>
                <small class="text-muted float-end"></small>
            </div>
            <div class="card-body">
                <div class="com-md-12">
                    <form action="{{ route('activity-store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cron_string" id="cron_string">
                        <div class="row">
                            <div class="form-group col-md-3">
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
                            <div class="form-group col-md-3">
                                <label for="activity">Activity</label>
                                <input type="text" class="form-control" id="activity" name="activity" placeholder="Activity">
                                @error('activity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="activity">First Due Date</label>
                                <input type="date" class="form-control" id="first_due_date" name="first_due_date">
                                @error('first_due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="activity">Second Due Date</label>
                                <input type="date" class="form-control" id="second_due_date" name="second_due_date">
                                @error('second_due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 
                            <div class="form-group col-md-9 mt-2">
                                <label for="activity">Schedule On</label>
                                <div class="input-group">
                                    <span class="input-group-text">Day</span>
                                    {{-- <input type="text"  class="form-control" placeholder="Day" name="cron_day" id="cron_day"> --}}


                                     <select class="form-control" name="cron_day[]" id="cron_day" multiple>
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

                                    <span class="input-group-text">Month</span>
                                    <select class="form-control" name="cron_month[]" id="cron_month" multiple>
                                        <option value="">Month</option>
                                        @foreach ($months as $key => $month)
                                            <option value="{{$month}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                    
                                    {{-- <input type="text"  class="form-control" placeholder="Month" name="cron_month" id="cron_month"> --}}
                                </div>
                                <b><span class="text-success cron_output"></span></b>
                                @error('cron_command')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 mt-2">
                                <label for="assign_to" class="col-form-label">Assign to</label>
                                <select class="form-control" id="assign_to" name="assign_to[]"  multiple>
                                    <option value="">Assign to</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                    <th>Team</th>
                    <th>Activity</th>
                    <th>Assigned To</th>
                    <th>First Due Date</th>
                    <th>Second Due Date</th>
                    <th>Manager</th>
                    <th>Status</th>
                    <th>Schedule On</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($activities as $activity)
                    <tr>
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

<!-- Include Flatpickr JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script>
    let flatDate = flatpickr('#due_date', {
        dateFormat: 'Y-m-d' 
    });


    $(document).ready(function() {
        $("#xyz12").select2();
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
            // tags: true,
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

</script>


@endsection

