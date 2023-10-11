@extends('admin.layouts.app')
@section('title', 'Registration')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">New User</h5>
                <small class="text-muted float-end">
                    <a href="{{ route('user-index')}}"><button class="btn btn-primary btn-sm">All Users</button></a>
                </small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user-store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="emp_name" class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="emp_name" name="emp_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="emp_email" name="emp_email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="department" class="col-form-label">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">Employee</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="department" class="col-form-label">Team</label>
                        <select class="form-control" id="team" name="team[]" multiple>
                            <option value="">Select Team</option>
                            @foreach ($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="designation" class="col-form-label">Slack Id</label>
                        <input type="text" class="form-control" id="emp_slack_id" name="emp_slack_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
       $('#team').select2({
            placeholder: "Select Team",
            allowClear: true
       });
    });
</script>
@endsection