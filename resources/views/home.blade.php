@extends('layouts.master')

@section('home')
active
@endsection
@section('title')
Home
@endsection
@section('content')
@include('layouts.nav')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome, {{$logged_user}} <span class="float-right">Total User ({{$total_user}})</span></div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                        </tr>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{$users->firstItem()+$index}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                    </table>
                    {{$users->links()}}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add User</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('insert_user')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                            <strong class="text-danger pt-3">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                            <strong class="text-danger pt-3">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                            <strong class="text-danger pt-3">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select name="role" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Mod</option>
                                <option value="3">Shopkeepr</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
