@extends('layouts.master')

@section('content')
@include('layouts.nav')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    Edit Category
                </div>
                <div class="card-body">
                    <form action="{{url('/category/update')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Category Name</label>
                            <input type="hidden" name='category_id' value="{{$category_info->id}}">
                            <input type="text" name="category_name" value="{{$category_info->category_name}}" class="form-control">
                            @error('category_name')
                            <small class="text-danger my-2">
                                {{$message}}
                            </small>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
