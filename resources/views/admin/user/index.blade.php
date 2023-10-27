@extends('admin.layouts.app')
@section('title', 'Employees List')

@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')

    <div class="row">

        <div class="col-12">
            <div class=" mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Employees List</h4>
                    <a href="{{ route('user-create')}}" class="btn btn-primary btn-sm">Add Employee</a>
                
                </div>
            </div>
        </div>
    </div>

    <div class="card">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover mb-3" id="datatable_users">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Slack ID</th>
                                <th>Teams</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}} 
                                    {{-- {{ count($user->activities) }}  --}}
                                </td>
                                <td>{{$user->email}}</td>
                                <td> 
                                    @if ($user->type == 1) Admin
                                        @elseif ($user->type == 2) Manager
                                    @else 
                                        Employee
                                    @endif
                                </td>
                                <td>{{$user->slack_id}}</td>
                                <td>
                                    @foreach ($user->teams as $team)
                                    <span class="badge bg-primary">{{$team->name}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('user-edit', $user->id)}}" class="btn btn-primary btn-sm edit_team"><i class='bx bx-edit'></i></a>
                                    <form action="{{route('user-destroy',$user->id)}}" method="POST" class="d-inline">
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
    </div>

@endsection

@section('scripts')
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
     let table =  $('#datatable_users').DataTable({
            responsive: true,
            dom: '<"top"f>rt<"bottom"lip><"clear">'
        });
       
    });
</script>
@endsection