<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Exception;
use App\Payment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;



class StripeController extends Controller
{
    public function handleGet()
    {
        return view('client.stripe');
    }
  
    /**
     * handling payment with POST
     */
    public function handlePost2(Request $request)
    {
        
        // $pur_arr = json_decode($request->purchase_list);
        // $user_id = $request->userID;
        // $restaurant_id = $request->restaurantID;

        // echo $user_id;
        // echo $restaurant_id;

        // foreach ($pur_arr as $pur){
        //     echo $pur->itemID;
        // } 


        Stripe::setApiKey(env('STRIPE_SECRET'));
        Charge::create ([
                "amount" => 100 * $request->chargeAmount,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);
  
        Session::flash('success', 'Payment has been successfully processed.');
          
        return back();
    }

    public function handlePost(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'terms_conditions' => 'accepted'
        ]);

        /** I have hard coded amount. You may fetch the amount based on customers order or anything */
        $amount     = 1 * 100;
        $currency   = 'usd';

        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
        }
        
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {
            /** Add customer to stripe, Stripe customer */
            $customer = Customer::create([
                'email'     => request('email'),
                'source'    => request('stripeToken')
            ]);
        } catch (Exception $e) {
            $apiError = $e->getMessage();
        }

        if (empty($apiError) && $customer) {
            /** Charge a credit or a debit card */
            try {
                /** Stripe charge class */
                $charge = Charge::create(array(
                    'customer'      => $customer->id,
                    'amount'        => $amount,
                    'currency'      => $currency,
                    'description'   => 'Some testing description'
                ));
            } catch (Exception $e) {
                $apiError = $e->getMessage();
            }

            if (empty($apiError) && $charge) {
                // Retrieve charge details 
                $paymentDetails = $charge->jsonSerialize();
                if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {
                    /** You need to create model and other implementations */
                    /*
                    Payment::create([
                        'name'                          => request('name'),
                        'email'                         => request('email'),
                        'amount'                        => $paymentDetails['amount'] / 100,
                        'currency'                      => $paymentDetails['currency'],
                        'transaction_id'                => $paymentDetails['balance_transaction'],
                        'payment_status'                => $paymentDetails['status'],
                        'receipt_url'                   => $paymentDetails['receipt_url'],
                        'transaction_complete_details'  => json_encode($paymentDetails)
                    ]);
                    */
                    return redirect('/thankyou/?receipt_url=' . $paymentDetails['receipt_url']);
                } else {
                    session()->flash('error', 'Transaction failed');
                    return back()->withInput();
                }
            } else {
                session()->flash('error', 'Error in capturing amount: ' . $apiError);
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Invalid card details: ' . $apiError);
            return back()->withInput();
        }

    }

    public function thankyou()
    {
        return view('client.thankyou');
    }
}
