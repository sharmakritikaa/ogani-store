<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\orderItem;
use App\Models\paymentGetway;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use Jackiedo\Cart\Facades\Cart;

class CheckoutController extends Controller
{
    public function show()
    {
        $shoppingCart=Cart::name('shopping');
        $items = $shoppingCart->getItems();
        $subTotal = $shoppingCart->getSubTotal();
        $total = $shoppingCart->getTotal();
        return view('checkout',[
            'items'=>$items,
            'total'=>$total,
            'subTotal' => $subTotal
        ]);

    }
    public function store(Request $request)
    {
        
        $shoppingCart=Cart::name('shopping');
        $items = $shoppingCart->getItems();
        $total = $shoppingCart->getTotal();

        $data= $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'province' => 'required',
            'district' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'payment_getway' => 'required',

        ]);
        //Create order
        $address = Address::create([
            'country' => $data['country'],
            'province' => $data['province'],
            'district' => $data['district'],
            'streetAddress' => $data['address'],
            'zipcode' => $data['zip'],

        ]);

        $paymentGetway = paymentGetway::where('code',$data['payment_getway'])->first();

        //create payment
        $payment = Payments::create([
            'payment_gateway_id' => $paymentGetway->id,
            'payments_status' => "NOT PAID",
            'price_paid' => 0

        ]);

        //create order
        $order = Order::create([
            'tracking_id'=>"ORG-" . uniqid(),
            'total'=>$total,
            'full_name'=> $data['first_name']. " " . $data['last_name'],
                       'email'=> $data['email'],
                       'phone_number'=> $data['phone'],
                       'biling_id'=> $address->id,
                       'shipping_id'=> $address->id,
                       'payment_id'=> $payment->id,

        ]);

        foreach($items as $item) {
            $orderItem = orderItem::create([
                               'order_id' => $order->id,
                               'name'=> $item->getTitle(),
                               'product_id' => $item->getId(),
                               'quantity' => $item->getQuantity(),
                               'price' => $item->getPrice(),
                               

            ]);
        }
        $shoppingCart->destroy();
        return redirect()->route('payment.show',['paymentGetway'=>$data ['payment_getway']]);

        
    }
}
