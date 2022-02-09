@extends('layouts.master')

@section('allproduct')
active
@endsection
@section('title')
all product
@endsection

@section('content')
@include('layouts.nav')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>All Products</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>SubCategory</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Discount Price</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Thumbnail</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($all_products as $index=>$product)
                        <tr>
                            <td>{{$all_products->firstItem()+$index}}</td>
                            <td>{{App\Models\Category::find($product->category_id)->category_name}}</td>
                            <td>{{App\Models\SubCategory::find($product->subcategory_id)->subcategory_name}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_price}}</td>
                            <td>
                                @if ($product->discount_percentage)
                                    {{$product->discount_percentage}}
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{$product->discount_price}}</td>
                            <td>{{$product->product_desp}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>
                                <img width="50" src="{{asset('/uploads/product')}}/{{$product->product_thumbnail}}" alt="">
                            </td>
                            <td>
                                <a href="{{url('add/inventory')}}/{{$product->id}}" class="btn btn-primary">Inventory</a>
                                <a href="#" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{$all_products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
