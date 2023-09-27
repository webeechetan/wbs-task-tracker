@extends('admin.layouts.app')
@section('title', 'Activities List')

@section('styles')
<!-- Include Flatpickr CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')


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
                            <div class="form-group col-md-6 mt-2">
                                <label for="activity">Schedule On</label>
                                <div class="input-group">
                                    <span class="input-group-text">Day Month</span>
                                    <input type="text"  class="form-control" placeholder="Day" name="cron_day" id="cron_day">
                                    <input type="text"  class="form-control" placeholder="Month" name="cron_month" id="cron_month">
                                </div>
                                <b><span class="text-success cron_output"></span></b>
                                @error('cron_command')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <label for="assign_to" class="col-form-label">Assign to</label>
                                <select class="form-control" id="assign_to" name="assign_to[]" required multiple>
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
                        <td>{{ $activity->team->name }}</td>
                        <td>{{ $activity->name }}</td>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    let flatDate = flatpickr('#due_date', {
        dateFormat: 'Y-m-d' 
    });


    $(document).ready(function() {
        let table = $('#activityTable').DataTable({
            responsive: true,
        });

        $('#cron_month').keyup(function(){
            generateCronStringFromCommand();
        });

        $('#cron_day').keyup(function(){
            generateCronStringFromCommand();
        });

       function generateCronStringFromCommand(){
            let cron_month = $('#cron_month').val();
            let cron_day = $('#cron_day').val();
            let cron_command = `0 0 ${cron_day} ${cron_month} *`;
            let cron_output = cronstrue.toString(cron_command);
            $('.cron_output').text(cron_output);
            $('#cron_string').val(cron_output);
       }

       $('#assign_to').select2({
            placeholder: "Assign To",
            allowClear: true
        });

    });
</script>


@endsection

