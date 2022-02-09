
@extends('frontend.main')

@section('content')
<!-- breadcrumb-area start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 text-center">
                <h2 class="breadcrumb-title">Product Details</h2>
                <!-- breadcrumb-list start -->
                <ul class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active">SSLCommerz</li>
                </ul>
                <!-- breadcrumb-list end -->
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-area end -->
<div class="container">
    <div class="py-5 text-center">
        <h2>Payment - SSLCommerz</h2>
    </div>

    <div class="row">
        <div class="col-md-8 order-md-2 mb-4 m-auto">
            <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" />
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your payment details</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Total</h6>
                    </div>
                    <span class="text-muted">{{App\Models\Order::where('user_id', Auth::id())->latest()->first()->sub_total}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Discount</h6>
                    </div>
                    <span class="text-muted">{{App\Models\Order::where('user_id', Auth::id())->latest()->first()->discount}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Delivery charge</h6>
                    </div>
                    <span class="text-muted">{{App\Models\Order::where('user_id', Auth::id())->latest()->first()->delivery_charge}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Grand Total (BDT)</span>
                    <input type="hidden" name="grand_total" value="{{App\Models\Order::where('user_id', Auth::id())->latest()->first()->grand_total}}">
                    <strong>{{App\Models\Order::where('user_id', Auth::id())->latest()->first()->grand_total}}</strong>
                </li>
            </ul>
             <div class="text-center">
                 <button class="btn btn-primary btn-lg btn-block m-auto" type="submit">Checkout</button>
             </div>
        </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2019 Company Name</p>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
    </footer>
</div>
@endsection
