<?php

namespace App\Http\Controllers;

use App\Models\Order_product_details;
use App\Models\Order_billing_details;
use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    function invoice_download($order_id){
        $orders_info = Order_product_details::where('order_id', $order_id)->get();
        $order_id = $order_id;
        $order_amount = Order::where('id', $order_id)->get();
        $pdf = PDF::loadView('pdf.invoice', [
            'orders_info'=> $orders_info,
            'order_id'=> $order_id,
            'order_amount'=> $order_amount,
        ]);
        return $pdf->stream('invoice.pdf');
    }
}
