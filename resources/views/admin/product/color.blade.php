@extends('layouts.master')
@section('color')
active
@endsection
@section('title')
Add colort
@endsection
@section('content')
@include('layouts.nav')

<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Color Info</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Color Name</th>
                            <th>Color Code</th>
                        </tr>
                        @foreach ($colors as $color)

                        <tr>
                            <td>{{$color->color_name}}</td>
                            <td><p style="background: #{{$color->color_code}}; width:20px;height:10px;padding:10px;color:white"></p></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Color</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/color/insert')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label"> Color Name</label>
                            <input type="text" name="color_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Color Code</label>
                            <input type="text" name="color_code" class="form-control">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Add color</button>
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
