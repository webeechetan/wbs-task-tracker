@extends('admin.layouts.app')

@section('title', 'Client & Projects')

@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class=" mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Clients & Projects</h4> 
                <div class="d-flex align-items-center justify-content-between multiple-btn">
                    <button class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewClientModal">Create Client</button>
                    <button class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewProjectModal">Create Project</button>
                </div>
            </div>
        </div>
    </div>
    @foreach($clients as $client)

    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card client-card mb-4">
            <div class="card-body">
                <div class="client-heading">
                    <h5 class="card-title mb-0">{{ $client->name }}</h5>
                    <div class="dropdown-dots">
                        <span class="dropdown-trigger" id="dropdown-trigger">
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </span>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-trigger-menu" id="dropdown-menu">
                    <a href="javascript:void(0)" class="card-link edit_cleint dropdown-item edit" data-client='{{ $client }}'> <i class='bx bx-edit' ></i> Edit</a>
                    <a href="{{ route('client.destroy', $client->id) }}" class="card-link dropdown-item delete"><i class="bx bxs-trash" aria-hidden="true"></i> Delete</a>
                </div>
                <p class="card-text">
                    @foreach($client->projects as $project)
                        <a href="" class="edit_project" data-project='{{ $project }}'>
                            <span class="badge bg-primary badge-xs mb-2">
                                {{ $project->name }}
                            </span>
                        </a>
                        
                    @endforeach
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
{{-- add new cleint modal --}}

<div class="modal fade" id="addNewClientModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="new_client_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="client_name" name="name" class="form-control" placeholder="Enter Client Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn btn-sm">Create Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit client modal --}}
<div class="modal fade" id="editClientModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_client_form">
                @csrf   
                <input type="hidden" name="" id="client_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="client_name_edit" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_client btn-sm">Update Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- create project modal --}}

{{-- add new cleint modal --}}

<div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="new_project_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Client</label>
                            <select class="form-control" name="client_id" id="client_id_for_project" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="project_name" name="name" class="form-control" placeholder="Enter Project Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn btn-sm">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit project modal --}}

<div class="modal fade" id="editProjectModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Update Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_project_form">
                @csrf
                <input type="hidden" id="edit_project_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Client</label>
                            <select class="form-control" name="client_id" id="edit_client_id_for_project" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="edit_project_name" name="name" class="form-control" placeholder="Enter Project Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="delete_project_btn">
                        <button type="button" class="btn btn-outline-danger btn-sm" >Delete</button>
                    </a>
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn btn-sm">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {

        let table = $('#teamsTable').DataTable({
            responsive: true,
         dom: '<"top"f>rt<"bottom"lip><"clear">'

        });

        // create client

        $('#new_client_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#client_name').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('client.store') }}",
                type: "POST",
                data: {
                    name: name,
                    _token: _token
                },
                success: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    if (response.status == 'success') {
                        $('#addNewClientModal').modal('hide');
                        $('#new_client_form')[0].reset();
                        toast('Success', 'Client Created Successfully', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        $("#teamsTable").prepend('<tr><td>' + name + '</td><td>' + team_lead_name + '</td><td><a href="" class="btn btn-primary btn-sm">Edit</a><a href="" class="btn btn-danger btn-sm">Delete</a></td></tr>');
                    }

                },
                error: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });

        // edit team

        $(".edit_cleint").on('click', function(e) {
            e.preventDefault();
            let client = $(this).data('client');
            $('#client_name_edit').val(client.name);
            $("#client_id").val(client.id);
            $('#editClientModal').modal('show');
        });

        // update team

        $('#edit_client_form').on('submit', function(e) {
            e.preventDefault();
            $('.update_client').prop('disabled', true);
            let name = $('#client_name_edit').val();
            let client_id = $('#client_id').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('client.update') }}",
                type: "POST",
                data: {
                    name: name,
                    client_id: client_id,
                    _token: _token
                },
                success: function(response) {
                    $('.update_client').prop('disabled', false);
                    if (response.status == 'success') {
                        $('#editClientModal').modal('hide');
                        $('#edit_client_form')[0].reset();
                        toast('Success', 'Client Updated Successfully', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }

                },
                error: function(response) {
                    $('.update_client').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });

        // create new project

        $('#new_project_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#project_name').val();
            let client_id = $("#client_id_for_project").val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('project.store') }}",
                type: "POST",
                data: {
                    name: name,
                    client_id:client_id,
                    _token: _token
                },
                success: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    if (response.status == 'success') {
                        $('#addNewProjectModal').modal('hide');
                        $('#new_project_form')[0].reset();
                        toast('Success', 'Project Created Successfully', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        $("#teamsTable").prepend('<tr><td>' + name + '</td><td>' + team_lead_name + '</td><td><a href="" class="btn btn-primary btn-sm">Edit</a><a href="" class="btn btn-danger btn-sm">Delete</a></td></tr>');
                    }

                },
                error: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });

        // edit project

        $(".edit_project").click(function(e){
            e.preventDefault();
            
            $("#editProjectModal").modal('show');
            let project = $(this).data('project');
            $(".delete_project_btn").attr("href", '{{ route("project.destroy") }}/'+project.id);
            $("#edit_project_name").val(project.name);
            $("#edit_project_id").val(project.id);
            $("#edit_client_id_for_project").val(project.client_id).change();
        });

        // update project

        // update team

        $('#edit_project_form').on('submit', function(e) {
            e.preventDefault();
            let name = $('#edit_project_name').val();
            let client_id = $('#edit_client_id_for_project').val();
            let project_id = $("#edit_project_id").val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('project.update') }}",
                type: "POST",
                data: {
                    name: name,
                    client_id: client_id,
                    project_id:project_id,
                    _token: _token
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#editProjectModal').modal('hide');
                        $('#edit_project_form')[0].reset();
                        toast('Success', 'Project Updated Successfully', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }

                },
                error: function(response) {
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });

    });
</script>
<!-- <script>
    var dropdownTrigger = document.getElementById('dropdown-trigger');
    var dropdownMenu = document.getElementById('dropdown-menu');

    dropdownTrigger.addEventListener('click', function (event) {

        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }

        event.stopPropagation();
    });


    document.addEventListener('click', function (event) {
        if (event.target !== dropdownTrigger && event.target !== dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
    });
</script> -->
<!-- Add this script at the end of your HTML file, or in the <head> section -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
        var dropdownMenus = document.querySelectorAll('.dropdown-menu');
        var openDropdown = null;

        dropdownTriggers.forEach(function (dropdownTrigger, index) {
            dropdownTrigger.addEventListener('click', function (event) {
                // Get the dropdown menu associated with the clicked trigger
                var dropdownMenu = dropdownTrigger.closest('.card').querySelector('.dropdown-menu');

                // Close the currently open dropdown, if any
                if (openDropdown !== null && openDropdown !== dropdownMenu) {
                    openDropdown.style.display = 'none';
                }

                // Toggle the dropdown for the clicked card
                if (dropdownMenu.style.display === 'block') {
                    dropdownMenu.style.display = 'none';
                    openDropdown = null;
                } else {
                    dropdownMenu.style.display = 'block';
                    openDropdown = dropdownMenu;
                }

                event.stopPropagation();
            });
        });

        document.addEventListener('click', function (event) {
            // Close all dropdowns when clicking outside of any card
            dropdownMenus.forEach(function (dropdownMenu) {
                dropdownMenu.style.display = 'none';
            });
            openDropdown = null;
        });
    });
</script>

@endsection