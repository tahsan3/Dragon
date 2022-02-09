@extends('layouts.master')

@section('category')
active
@endsection
@section('title')
Category
@endsection

@section('content')
@include('layouts.nav')
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                @if (session('mark_del'))
                    <div class="alert alert-success">
                        {{session('mark_del')}}
                    </div>
                @endif
                @if (session('limit_cross'))
                    <div class="alert alert-warning">
                        {{session('limit_cross')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{url('/mark/delete')}}" method="POST">
                        @csrf
                    <table class="table table-striped">
                        <tr>
                            <th><input type="checkbox" class="checkall"> Check All</th>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Added By</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                        @forelse($categories as $category)
                        <tr>
                            <td><input type="checkbox" name="mark[]" value="{{$category->id}}"></td>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$category->category_name}}</td>

                            <td>{{App\Models\User::find($category->added_by)->name}}</td>
                            <td>{{$category->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{url('/category/status')}}/{{$category->id}}" class='btn btn-{{($category->status==0)?'secondary':'success'}}'>{{($category->status==0)?'deactive':'active'}}</a>
                                <a href="{{url('/category/edit')}}/{{$category->id}}" class='btn btn-primary'>Edit</a>
                                <a href="{{url('/category/delete')}}/{{$category->id}}" class='btn btn-danger'>Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4">No Category Available</td>
                        </tr>
                        @endforelse
                    </table>
                    <button class="btn btn-danger">Mark Delete</button>
                    </form>
                </div>
            </div>


            <div class="card mt-5">
                <div class="card-header">
                    <h3>Trashed Category List</h3>
                </div>
                @if(session('restore'))
                    <div class="alert alert-success">
                        {{session('restore')}}
                    </div>
                @endif
                @if(session('perdelete'))
                    <div class="alert alert-success">
                        {{session('perdelete')}}
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Added By</th>
                            <th>Created_at</th>
                            <th>Action</th>
                        </tr>
                        @forelse($trashed_categories as $trashed_category)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$trashed_category->category_name}}</td>

                            <td>{{App\Models\User::find($trashed_category->added_by)->name}}</td>
                            <td>{{$trashed_category->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{url('/category/restore')}}/{{$trashed_category->id}}" class='btn btn-success'>Restore</a>
                                <a href="{{url('/category/permanent/delete')}}/{{$trashed_category->id}}" class='btn btn-danger'>Permanent Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4">No Category Available</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                @if(session('category_exist'))
                    <div class="alert alert-warning">
                        {{session('category_exist')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{url('/category/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="">Category Name</label>
                            <input type="text" name="category_name" class="form-control">
                            @error('category_name')
                            <small class="text-danger my-2">
                                {{$message}}
                            </small>
                        @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Category Image</label>
                            <input type="file" name="category_image" class="form-control">
                            @error('category_image')
                            <small class="text-danger my-2">
                                {{$message}}
                            </small>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')

@if(session('category_delete'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{session('category_delete')}}',
            showConfirmButton: false,
            timer: 1500
            })
    </script>
@endif

<script>
    $('.checkall').click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

</script>

@endsection


