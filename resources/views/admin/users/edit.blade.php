@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">{{ $title }}</div>

    <div class="card-body">


        <form action="{{ route("admin.users.update", $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $user->name }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}:</label>

                <div class="col-md-6">
                    @foreach($status as $key => $value)
                        <label class="col-form-label text-md-right">{{ $value }}
                        <input type="radio" name="status" {{ ($user->status ==$key)?'checked':'' }} value={{ $key }} required></label>
                    @endforeach
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
            </div>
            <div class="form-group row">
                <label for="status" class="col-md-4 col-form-label text-md-right">Is Admin::</label>
                <div class="col-md-6">
                    <input type="checkbox" name="is_admin" {{ ($user->is_admin == 1)?'checked':'' }}>
                </div>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="Save">
            </div>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>

<script>
    $(document).ready(function () {
         $('[data-toggle="switch"]').bootstrapSwitch();
    });
</script>

@endpush