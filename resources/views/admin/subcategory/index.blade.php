@extends('layouts.master')


@section('subcategory')
active
@endsection
@section('title')
SubCategory
@endsection
@section('content')
@include('layouts.nav')
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>SubCategory List</h3>
                </div>
                @if(session('delete_subcat'))
                    <div class="alert alert-success">
                        {{session('delete_subcat')}}
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>SubCategory Name</th>
                            <th>Added By</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                        @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{App\Models\Category::find($subcategory->category_id)->category_name}}</td>
                            <td>{{$subcategory->subcategory_name}}</td>

                            <td>{{App\Models\User::find($subcategory->added_by)->name}}</td>
                            <td>{{$subcategory->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{url('/subcategory/edit')}}/{{$subcategory->id}}" class='btn btn-primary'>Edit</a>
                                <a href="{{url('/subcategory/delete')}}/{{$subcategory->id}}" class='btn btn-danger'>Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4">No SubCategory Available</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add SubCategory</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{url('/subcategory/insert')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Category List</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <small class="text-danger my-2">
                                {{$message}}
                            </small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">SubCategory Name</label>
                            <input type="text" name="subcategory_name" class="form-control">
                            @error('subcategory_name')
                            <small class="text-danger my-2">
                                {{$message}}
                            </small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Subcategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

@if(session('success'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{session('success')}}',
            showConfirmButton: false,
            timer: 1500
            })
    </script>
@endif

@if(session('exist_subcategory'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: '{{session('exist_subcategory')}}',
            showConfirmButton: false,
            timer: 1500
            })
    </script>
@endif
@endsection
