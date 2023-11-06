@extends('admin.layouts.app')

@section('title', 'Teams')

@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <h4 class="mb-0">Teams</h4> 
            <small class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewTeamModal">Create New</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <!-- <div class="card-header d-flex align-items-center justify-content-between">
               {{-- <div class="custom_search_filter">
                    <form action="#" method="GET">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" value="">
                            <div class="custom_search_filter_inputMask"><i class="bx bx-search"></i></div>
                    </form>
                 </div> --}}
                 <h5 class="mb-0">Teams</h5> 
                <small class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewTeamModal">Create New</small>
            </div> -->
            <div class="card-body">
                <table class="table table-hover mb-3" id="teamsTable">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Lead</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                        <tr>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->lead->name }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm edit_team" data-team='{{ json_encode($team) }}'><i class='bx bx-edit'></i></button>
                                <a href="{{ route('teams-destroy', $team->id) }}" class="btn btn-danger btn-sm"><i class='bx bxs-trash'></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- add new user modal --}}

<div class="modal fade" id="addNewTeamModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Add New Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="new_team_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="name" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="col-md-12">
                            <label for="nameSmall" class="form-label">Lead</label>
                            <select class="form-control team_lead" name="team_lead" id="team_lead">
                                <option value="">Select Lead</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn">Create Team</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit team modal --}}
<div class="modal fade" id="editTeamModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Edit Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="edit_team_form">
                @csrf   
                <input type="hidden" name="" id="team_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="team_name_edit" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="col-md-12">
                            <label for="nameSmall" class="form-label">Lead</label>
                            <select class="form-control team_lead" name="team_lead" id="team_lead_edit">
                                <option value="">Select Lead</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_team">Update Team</button>
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

        // create team

        $('#new_team_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#name').val();
            let team_lead = $('#team_lead').val();
            let team_lead_name = $('#team_lead option:selected').text();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('teams-store') }}",
                type: "POST",
                data: {
                    name: name,
                    team_lead: team_lead,
                    _token: _token
                },
                success: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    if (response.status == 'success') {
                        $('#addNewTeamModal').modal('hide');
                        $('#new_team_form')[0].reset();
                        toast('Success', 'Team Created Successfully', 'success');
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

        $(".edit_team").on('click', function(e) {
            e.preventDefault();
            let team = $(this).data('team');
            $('#team_name_edit').val(team.name);
            $('#team_lead_edit').val(team.lead_id);
            $("#team_id").val(team.id);
            $('#editTeamModal').modal('show');
        });

        // update team

        $('#edit_team_form').on('submit', function(e) {
            e.preventDefault();
            $('.update_team').prop('disabled', true);
            let name = $('#team_name_edit').val();
            let team_lead = $('#team_lead_edit').val();
            let team_id = $('#team_id').val();
            let _token = $('input[name=_token]').val();

            $.ajax({
                url: "{{ route('teams-update') }}",
                type: "POST",
                data: {
                    name: name,
                    team_lead: team_lead,
                    team_id: team_id,
                    _token: _token
                },
                success: function(response) {
                    $('.update_team').prop('disabled', false);
                    if (response.status == 'success') {
                        $('#editTeamModal').modal('hide');
                        $('#edit_team_form')[0].reset();
                        toast('Success', 'Team Updated Successfully', 'success');
                    }

                },
                error: function(response) {
                    $('.update_team').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection