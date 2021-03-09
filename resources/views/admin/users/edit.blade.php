@extends('layouts.admin')

@section('title', 'Edit User')

@section('pageheader')
    Edit User
@stop

@section('pageheader__actions')
    <div class="d-flex align-items-center">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
            All User
        </a>
    </div>
@stop

@section('content')
    <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post" style="max-width: 480px" class="py-4" enctype="multipart/form-data">
        @method('PATCH')
        @csrf

        <div class="form-group">
            <label for="user_type">{{ __('User type') }}</label>
            <select name="type" id="user_type" class="form-control">
                <option value="2" selected>{{ __('Sub-Admin') }}</option>
            </select>
        </div>

        <div class="my-4">
            <h4>{{ __('Permissions') }}</h4>

            @php( $sPermissions = $user->permissions )
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
                            <input type="checkbox" class="select_all_cb_{{ $_index }} mr-2" data-parent="select_all_cb_{{ $_index }}" name="permissions[]" id="{{ $key }}" value="{{ $key }}" {{ $sPermissions->contains('name', $key) ? 'checked':'' }}>
                            <label for="{{ $key }}">{{ $permission }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="first_name">{{ __('First Name') }}</label>
            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ $user->first_name }}" required>
        </div>

        <div class="form-group">
            <label for="last_name">{{ __('Last Name') }}</label>
            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ $user->last_name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
@stop

@section('scripts')
<script>
    $(document).ready(function() {

        $(".select_all_cb").change(function() {
            var self = $(this);

            var key   = self.data("key");
            var props = $(".select_all_cb_" + key);

            console.log("props: ", props);

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
@endsection
