@extends('frontend.main')

@section('content')
<!-- breadcrumb-area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Order Confirmation</h2>
                    <!-- breadcrumb-list start -->
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active">Order Confirmed</li>
                    </ul>
                    <!-- breadcrumb-list end -->
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->

  <section class="mt-5 mb-5">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card text-center">
                      <div class="card-header bg-danger">
                          <h3 class="text-white">Order Confirmation Message</h3>
                      </div>
                      <div class="card-body">
                          <h4>Congratulation {{Auth::user()->name}}, Your Order Has Been Placed!</h4>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
@endsection
