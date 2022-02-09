@extends('layouts.master')
@section('size')
active
@endsection
@section('title')
Add size
@endsection
@section('content')
@include('layouts.nav')

<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>size Info</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Size Name</th>
                        </tr>
                        @foreach ($sizes as $size)

                        <tr>
                            <td>{{$size->size_name}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add size</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('/size/insert')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="size_name" class="form-control">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Add Size</button>
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
