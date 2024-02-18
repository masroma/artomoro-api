<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutAdminController extends Controller
{
    protected $request;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $this->request = $request;
        // Set midtrans configuration

    }

    public function store()
    {
        DB::transaction(function() {

            /**
             * algorithm create no invoice
             */
            $length = 10;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'INV-'.Str::upper($random);
            $grandtotal = 0;
            foreach(Cart::where('customer_id', auth()->user()->id)->get() as $cart)
            {
                $grandtotal += $cart->price;
            }

            $invoice = Invoice::create([
                'invoice'       => $no_invoice,
                'customer_id'   => auth()->user()->id,
                'courier'       => 'jne',
                'service'       => 'OKE',
                'cost_courier'  => 0,
                'weight'        => $this->request->weight,
                'name'          => 'admin',
                'phone'         => '082299995502',
                'province'      => 9,
                'city'          => 78,
                'address'       => 'jln wijaya kusuoma rt 03 rw 05',
                'grand_total'   => $grandtotal,
                'status'        => 'success',
                'status_pengiriman'  => 'success',
                'paymentlocal_id' => 3
            ]);

            foreach (Cart::where('customer_id', auth()->user()->id)->get() as $cart) {

                //insert product ke table order
                $invoice->orders()->create([
                    'invoice_id'    => $invoice->id,
                    'invoice'       => $no_invoice,
                    'product_id'    => $cart->product_id,
                    'product_name'  => $cart->product->title,
                    'image'         => $cart->product->image,
                    'qty'           => $cart->quantity,
                    'price'         => $cart->price,
                ]);

            }

            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $invoice->invoice,
                    'gross_amount'  => $invoice->grand_total,
                ],
                'customer_details' => [
                    'first_name'       => $invoice->name,
                    'email'            => auth()->guard('api_admin')->user()->email,
                    'phone'            => $invoice->phone,
                    'shipping_address' => $invoice->address
                ]
            ];



        });

        return response()->json([
            'success' => true,
            'message' => 'Order Successfully'
            // $this->response
        ]);

    }
}
