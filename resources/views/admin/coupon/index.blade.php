@extends('layouts.master')

@section('coupon')
active
@endsection
@section('title')
Coupon
@endsection

@section('content')
@include('layouts.nav')
<div class="container pt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
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
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Coupon Name</th>
                            <th>Discount %</th>
                            <th>Validity</th>
                            <th>Created at</th>
                        </tr>
                        @forelse($coupons as $coupon)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$coupon->coupon_name}}</td>
                            <td>{{$coupon->discount}}</td>
                            <td>{{$coupon->validity}}</td>
                            <td>{{$coupon->created_at->diffForHumans()}}</td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="4">No Coupon Available</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Coupon</h3>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{route('coupon.insert')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Coupon Name</label>
                            <input type="text" name="coupon_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Discount</label>
                            <input type="text" name="discount" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Validity</label>
                            <input type="date" name="validity" class="form-control">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Coupon</button>
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


