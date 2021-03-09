@extends('layouts.admin')

@section('title', 'Users')

@section('pageheader')
    Add User
@stop

@section('pageheader__actions')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
            All User
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.users.store') }}" method="post" style="max-width: 480px" class="py-4" enctype="multipart/form-data">
            @csrf
    
            <div class="form-group">
                <label for="user_type">{{ __('User type') }}</label>
                <select name="type" id="user_type" class="form-control">
                    <option value="2" selected>{{ __('Sub-Admin') }}</option>
                </select>
            </div>
    
            <div class="my-4">
                <h4>{{ __('Admin Permissions') }}</h4>
    
                @php( $modules = \App\Consts\UserTypes::PERMISSIONS )
    
                @foreach ($modules as $module => $permissions)
                    @php( $_index = $loop->index )
    
                    <div class="d-block">
                        <label for="select_all_cb_{{ $loop->index }}">
                            <b>{{ $module }}</b>
                        </label>
                        <input type="checkbox" id="select_all_cb_{{ $_index }}" data-key="{{ $_index }}"  class="ml-2 select_all_cb">
                    </div>
    
                    <div class="pl-4 py-2">
                        @foreach ($permissions as $key => $permission)
                            <div class="d-block">
                                <input type="checkbox" class="select_all_cb_{{ $_index }} mr-2" data-parent="select_all_cb_{{ $_index }}" name="permissions[]" id="{{ $key }}" value="{{ $key }}">
                                <label for="{{ $key }}">{{ $permission }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
    
            <div class="form-group">
                <label for="first_name">{{ __('First Name') }} *</label>
                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required>
            </div>
    
            <div class="form-group">
                <label for="last_name">{{ __('Last Name') }} *</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required>
            </div>
    
            <div class="form-group">
                <label for="email">{{ __('Email') }} *</label>
                <div class="row align-items-center">
                    <div class="col-9">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-3">
                        <input type="checkbox" id="email_verified_at" name="email_verified_at" class="m-0">
                        <label for="email_verified_at" class="m-0">Verified</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="phone">{{ __('Phone') }}</label>
                <div class="row align-items-center">
                    <div class="col-9">
                        <input type="phone" id="phone" name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}">
                    </div>
                    <div class="col-3">
                        <input type="checkbox" id="phone_verified_at" name="phone_verified_at" class="m-0">
                        <label for="phone_verified_at" class="m-0">Verified</label>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="password">{{ __('Password') }} *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('Password') }}" required>
            </div>
    
            <div class="form-group">
                <label for="password_confirmation">{{ __('Password Repeat') }} *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{ __('Password Reapeat') }}" required>
            </div>
    
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".select_all_cb").change(function() {
                var self = $(this);

                var key   = self.data("key");
                var props = $(".select_all_cb_" + key);

                props.prop("checked", self.is(":checked"));
            });

            $("[class^=select_all_cb_]").change(function() {
                var classNm = $(this).data("parent");

                var checked = true;
                $("." + classNm).each(function()  {
                    if(! $(this).is(":checked") ) {
                        checked = false;
                    }
                });

                $("#" + classNm).prop("checked", checked);
            });
        });
    </script>
@stop
