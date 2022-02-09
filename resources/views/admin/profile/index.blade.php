@extends('layouts.master')

@section('content')
@include('layouts.nav')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Change Your Name</h5>
                </div>
                <div class="card-body">
                    <form action="{{url('/name/update')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Your Name</label>
                            <input type="text" value="{{Auth::user()->name}}" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{url('/password/update')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Old Password</label>
                            <input type="text" name="old_password" class="form-control">
                            @if (session('old_password'))
                                <div class="alert alert-danger">
                                    {{session('old_password')}}
                                </div>
                            @endif
                            @error('old_password')
                                <div class="alert alert-danger mt-2">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <div class="alert alert-danger mt-2">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Change Your Photo</h5>
                </div>
                <div class="card-body">
                    <form action="{{url('/photo/update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Your Photo</label>
                            <input type="file" name="photo" class="form-control">
                            @error('photo')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('footer_script')
@if (session('name_update'))
    <script>
        Swal.fire({
        title: 'Sweet!',
        text: '{{session("name_update")}}',
        imageUrl: '{{asset("dashboard_asset/img/favicon.png")}}',
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: 'Custom image',
        })
    </script>
@endif
@endsection
