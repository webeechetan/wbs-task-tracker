@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit User</h5>
                <small class="text-muted float-end">
                    <a href="{{ route('user-index') }}"><button class="btn btn-primary btn-sm">Users List</button></a>
                </small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user-update', $users->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="container">
                        <div class="form-group">
                            <label for="emp_name" class="col-form-label">Name</label>
                            <input type="text" class="form-control" id="emp_name" name="emp_name" value="{{$users->name}}">
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control" id="emp_email" name="emp_email" value="{{$users->email}}">
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{$users->password}}">
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-form-label">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="1" {{ $users->type == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $users->type == 2 ? 'selected' : '' }}>Manager</option>
                                <option value="3" {{ $users->type == 3 ? 'selected' : '' }}>Employee</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="designation" class="col-form-label">Slack Id</label>
                            <input type="text" class="form-control" id="emp_slack_id" name="emp_slack_id" value="{{$users->slack_id}}" required>
                        </div>
                    </div>




                    @error('image')
                    <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
            </div>



            <button type="submit" class="btn btn-primary">Update</button>
            </form>


        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {

        $('#lfm').filemanager('file');
        $('#og_image').filemanager('file');

    });

    var options = {
        filebrowserImageBrowseUrl: '/admin/filemanager',
    };

    CKEDITOR.replace('editor', options);
</script>
@endsection