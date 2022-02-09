@extends('layouts.master')
@section('add_product')
active
@endsection
@section('title')
Add Product
@endsection
@section('content')
@include('layouts.nav')

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Add Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/product/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="subcategory_id" class="form-control">
                                <option value="">-- Select Sub Category --</option>
                                @foreach ($sub_categories as $sub_category)
                                    <option value="{{$sub_category->id}}">{{$sub_category->subcategory_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Product Price</label>
                            <input type="text" name="product_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Discount Percentage</label>
                            <input type="text" name="discount_percentage" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Product Description</label>
                            <textarea name="product_desp" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Product Photo Thumbnail</label>
                          <input type="file" name="product_thumbnail" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Product Photo Multiple</label>
                          <input type="file" name="product_multiple[]" class="form-control" multiple>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    @if(session('product_added'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{session('product_added')}}',
            showConfirmButton: false,
            timer: 1500
            })
    </script>
@endif
@endsection
