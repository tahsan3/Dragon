<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
    </style>
</head>
<body>
<div class="mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-12">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-uppercase">Invoice</h1>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Billed:</span><span class="ml-1">
                            {{App\Models\Order_billing_details::where('order_id', $order_id)->first()->name}}
                        </span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Date:</span><span class="ml-1">{{App\Models\Order_billing_details::where('order_id', $order_id)->first()->created_at}}</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Order ID:</span><span class="ml-1">#{{$order_id}}</span></div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="table-responsive" style="background:#fb5d5d">
                        <table class="table">
                            <thead>
                                <tr style="color:white">
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders_info as $order_details)
                                <tr style="color:white">
                                    <td>{{$order_details->product_name}}</td>
                                    <td>{{$order_details->quantity}}</td>
                                    <td>{{$order_details->product_price}}</td>
                                    <td>{{$order_details->product_price * $order_details->quantity}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive" style="background:#fb5d5d;margin-top:50px">
                        <table class="table">
                            <thead>
                                <tr style="color:white">
                                    <th>Sub Total</th>
                                    <th>Discount</th>
                                    <th>Delivery Charge</th>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="color:white">
                                    <td>{{$order_amount->first()->sub_total}}</td>
                                    <td>{{$order_amount->first()->discount}}</td>
                                    <td>{{$order_amount->first()->delivery_charge}}</td>
                                    <td>{{$order_amount->first()->grand_total}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
