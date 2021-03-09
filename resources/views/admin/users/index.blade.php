@extends('layouts.admin')

@section('title', 'Users')

@section('pageheader')
    Users
@stop

@section('pageheader__actions')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-outline-primary">
            + Add User
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <table id="s_users" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->type }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="row">
                                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pen fa-sm"></i> {{ __('Edit') }}
                                </a>
                                <form class="ml-2" action="{{ route('admin.users.destroy', ['user' => $user->id]) }}"
                                    method="post" onsubmit="return confirm('Are you sure you want to remove this user?');">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#s_users').DataTable();
        });
    </script>
@stop
