@extends('frontend.main')
@section('content')
<!-- breadcrumb-area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Checkout</h2>
                    <!-- breadcrumb-list start -->
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

<!-- checkout area start -->
@auth
<div class="checkout-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="billing-info-wrap">
                    <h3>Billing Details</h3>
                    <form action="{{url('/order')}}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Full Name</label>
                                <input readonly type="text" name="name" value="{{Auth::user()->name}}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Email Address</label>
                                <input readonly type="text" name="email" value="{{Auth::user()->email}}" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Phone</label>
                                <input name="phone" type="text" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <label>Postcode / ZIP</label>
                                <input name="zip" type="text" />
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="billing-select mb-4">
                                <label>Country</label>
                                <select name="country_id" class="select_country">
                                    <option>Select a country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="billing-select mb-4">
                                <label>City</label>
                                <select name="city_id" class="select_city">
                                    <option>Select a City</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <label>Address</label>
                                <input name="address" placeholder="Apartment, suite, unit etc." type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="additional-info-wrap">
                        <div class="additional-info">
                            <label>Order notes</label>
                            <textarea  placeholder="Notes about your order, e.g. special notes for delivery. "
                                name="notes"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-5 mt-md-30px mt-lm-30px ">
                <div class="your-order-area">
                    <h3>Your order</h3>
                    <div class="your-order-wrap gray-bg-4">
                        <div class="your-order-product-info">
                            <div class="your-order-top">
                                <ul>
                                    <li>Product</li>
                                    <li>Sub Total</li>
                                </ul>
                            </div>
                            <div class="your-order-middle">
                                <ul>
                                    @foreach ($carts as $cart_product)
                                    <li>
                                        <span class="order-middle-left">{{$cart_product->relation_to_products->product_name}} X {{$cart_product->quantity}}</span>
                                        <span class="order-price"> {{$cart_product->relation_to_products->discount_price * $cart_product->quantity}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="your-order-bottom">
                                <ul>
                                    <li class="your-order-shipping">Discount</li>
                                    <li><input type="hidden" name="discount" value="{{session('discount')}}"></li>
                                    <li>{{session('discount')}}%</li>
                                </ul>
                            </div>

                            <div class="your-order-total">
                                <ul>
                                    <li class="order-total">Total</li>
                                    <li><input id="product_total" type="hidden" name="product_total" value="{{session('product_total')}}"></li>
                                    <li><input id="total" type="hidden" name="total" value="{{session('total')}}"></li>
                                    <li>{{session('total')}}</li>
                                </ul>
                            </div>

                            <div class="payment-method pt-5">
                            <p class="pb-3">Delivery Charge</p>
                            <ul class="d-flex justify-content-between">
                                <li>
                                    <div class="form-check">
                                        <input id="deliver1" class="form-check-input px-0" type="radio" name="delivery_charge" id="flexRadioDefault01" value="60">
                                        <label class="form-check-label" for="flexRadioDefault01">
                                            Dhaka
                                        </label>
                                    </div>
                                </li>
                                <li>60</li>
                            </ul>
                            <ul class="d-flex justify-content-between">
                                <li>
                                    <div class="form-check">
                                        <input id="deliver2" class="form-check-input px-0" type="radio" name="delivery_charge" id="flexRadioDefault02" value="100">
                                        <label class="form-check-label" for="flexRadioDefault02">
                                            Outside Dhaka
                                        </label>
                                    </div>
                                </li>
                                <li>100</li>
                            </ul>

                        </div>

                            <div class="your-order-total">
                                <ul>
                                    <li class="order-total">Grand Total</li>
                                    <li><input type="hidden" value="{{session('total')}}"></li>
                                    <li><span id="grand_total">
                                    @php
                                        $money = session('total') - session('total')*$discount/100;
                                        echo number_format($money)
                                    @endphp
                                    </span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="payment-method">
                            <h5 class="pb-3">Select Delivery Method</h5>
                            @error('payment_method')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                            @enderror
                            <div class="form-check">
                                <input class="form-check-input px-0" type="radio" name="payment_method" id="flexRadioDefault1" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Cash on Delivery
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input px-0" type="radio" name="payment_method" id="flexRadioDefault2" value="2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Pay with SSLcommerz
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input px-0" type="radio" name="payment_method" id="flexRadioDefault3" value="3">
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Pay with Stripe
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="Place-order mt-25">
                        <button type="submit" class="btn form-control" style="background:tomato;color:#fff">Place Order</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout area end -->
@else
<div class="container py-5">
    <div class="row my-5">
        <div class="col-lg-12 bg-light">
            <div class="row">
                <div class="col-lg-6 py-5 text-end">
                    <h3>Please Login to Checkout</h3>
                </div>
                <div class="col-lg-6 py-4">
                    <a class="btn btn-primary" href="{{url('login')}}">Login Here</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection
@section('footer_script')
    <script>
        $(document).ready(function() {
            $('.select_country').select2();
            $('.select_city').select2();
        });
    </script>

     <script>
        $('.select_country').change(function(){
            var country_id = $(this).val();

           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getCityList',
                data:{country_id:country_id},
                success: function(data){
                    $('.select_city').html(data);
                },
                error:function(xhr){
                    console.log(xhr.responseText)
                }
            })

        });
    </script>

<script>
$('#deliver1').click(function(){
    var total = parseInt($('#total').val());
    var delivery_charge = parseInt($('#deliver1').val());
    var grand_total =total+delivery_charge;
    $('#grand_total').html(grand_total);
});
$('#deliver2').click(function(){
    var total = parseInt($('#total').val());
    var delivery_charge = parseInt($('#deliver2').val());
    var grand_total =total+delivery_charge;
    $('#grand_total').html(grand_total);
});
</script>



@endsection
