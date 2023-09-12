@extends('admin.layouts.app')

@section('title', 'Clients')

@section('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Clients</h5> <small class="float-end btn btn-primary btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#addNewClientModal">Create New</small>
                  </div>
                <div class="card-body">
                    <table class="table table-hover mb-0" id="clientsTable">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit_client" data-client='{{ json_encode($client) }}'>Edit</button>
                                        <a href="{{ route('clients-destroy', $client->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
                        <div class="col-md-12">
                            <label for="nameSmall" class="form-label">Name</label>
                            <input type="text" required id="name" name="name" class="form-control" placeholder="Enter Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit_btn">Create Client</button>
                </div>
            </form>
          </div>
        </div>
      </div>

      {{-- edit team modal --}}
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update_client">Update Client</button>
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

        let table = $('#clientsTable').DataTable({
            responsive: true,
        });

        // create team

        $('#new_client_form').on('submit', function(e) {
            e.preventDefault();
            $('.submit_btn').prop('disabled', true);
            let name = $('#name').val();
            let _token = $('input[name=_token]').val();
            
            $.ajax({
                url: "{{ route('clients-store') }}",
                type: "POST",
                data: {
                    name: name,
                    _token: _token
                },
                success: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    if(response.status=='success') {
                        $('#addNewClientModal').modal('hide');
                        $('#new_client_form')[0].reset();
                        toast('Success', 'Client Created Successfully', 'success');
                        $("#clientsTable").prepend('<tr><td>'+name+'</td><td><a href="" class="btn btn-primary btn-sm">Edit</a><a href="" class="btn btn-danger btn-sm">Delete</a></td></tr>');
                    }
                   
                },
                error: function(response) {
                    $('.submit_btn').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });

        // edit team

        $(".edit_client").on('click', function(e) {
            e.preventDefault();
            let client = $(this).data('client');
            $('#client_id').val(client.id);
            $('#client_name_edit').val(client.name);
            $('#editClientModal').modal('show');
        });

        // update team

        $('#edit_client_form').on('submit', function(e) {
            e.preventDefault();
            $('.update_client').prop('disabled', true);
            let name = $('#client_name_edit').val();
            let id = $('#client_id').val();
            let _token = $('input[name=_token]').val();
            
            $.ajax({
                url: "{{ route('clients-update') }}",
                type: "POST",
                data: {
                    name: name,
                    id: id,
                    _token: _token
                },
                success: function(response) {
                    $('.update_client').prop('disabled', false);
                    if(response.status=='success') {
                        $('#editClientModal').modal('hide');
                        $('#edit_client_form')[0].reset();
                        toast('Success', 'Team Updated Successfully', 'success');
                    }
                   
                },
                error: function(response) {
                    $('.update_client').prop('disabled', false);
                    toast('Error', 'Something Went Wrong', 'error');
                }
            });
        });
    });
</script>
@endsection