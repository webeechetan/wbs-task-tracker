@extends('admin.layouts.app')
@section('title', 'Activity List')

@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Activity List</h5>
        <a href="" class="btn btn-primary btn-sm">Add Activity</a>
    </div>
    <div class="table-responsive text-nowrap">
        <div class="container">
            <table class="table table-hover" id="datatable_tracker">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Activity</th>

                        <th>1st Due Date</th>
                        <th>2nd Due Date</th>
                        <th>Manager</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
              
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        //$('#datatable_tracker').DataTable();
    });
</script>
@endsection