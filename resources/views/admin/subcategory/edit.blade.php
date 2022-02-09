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
                @if(session('updated'))
                    <div class="alert alert-success">
                        {{session('updated')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{url('/subcategory/update')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name='subcategory_id' value="{{$subcategories->id}}">
                            <label for="">Category Name</label>
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$subcategories->category_id == $category->id?'selected':''}}>{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">SubCategory Name</label>
                            <input type="text" name="subcategory_name" value="{{$subcategories->subcategory_name}}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update SubCategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
