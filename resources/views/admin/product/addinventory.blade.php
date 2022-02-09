@extends('layouts.master')
@section('inventory')
active
@endsection
@section('title')
Add inventory
@endsection
@section('content')
@include('layouts.nav')

<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Inventory Info</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                        </tr>
                        @foreach ($inventories as $inventory)
                        <tr>
                            <td>{{App\Models\Product::find($inventory->product_id)->product_name}}</td>
                            <td>{{App\Models\Color::find($inventory->color_id)->color_name}}</td>
                            <td>
                                @php
                                    if($inventory->size_id){
                                        echo App\Models\Size::find($inventory->size_id)->size_name;
                                    }
                                    else{
                                        echo 'N/A';
                                    }
                                @endphp
                            </td>
                            <td>{{$inventory->quantity}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add inventory</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/insert/inventory')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="product_id" value="{{$product_id}}" class="form-control">
                            <input type="text" readonly value="{{$product_name}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="color_id" class="form-control">
                                <option value="">-- Select Color --</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{$color->color_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="size_id" class="form-control">
                                <option value="">-- Select Size --</option>
                                @foreach ($sizes as $size)
                                    <option value="{{$size->id}}">{{$size->size_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label"> Product Quantity </label>
                            <input type="text" name="quantity" class="form-control">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Add Inventory</button>
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
