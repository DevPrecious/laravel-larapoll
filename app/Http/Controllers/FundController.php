<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;

class FundController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('fund.deposit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required'
        ]);

        $curl = curl_init();
        $user = User::find(auth()->id());

        $email = $user['email'];
        $amount = $request->amount * 100;  //the amount in kobo. This value is actually NGN 300

        // Store sessions
        $ses_store = [
            'user_id' => auth()->id(),
            'amount' => $amount
        ];

        $request->session()->put('ses_store', $ses_store);
        // dd(session()->get('ses_store'));

        // url to go to after payment
        $callback_url = '/callback';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'email' => $email,
                'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer sk_test_2b810b3656e15df277a22ff2ecff66f8183f2f12", //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if (!$tranx['status']) {
            // there was an error from the API
            print_r('API returned error: ' . $tranx['message']);
        }

        // comment out this line if you want to redirect the user to the payment page
        // print_r($tranx);
        // redirect to page so User can pay
        // uncomment this line to allow the user redirect to the payment page
        // header('Location: ' . $tranx['data']['authorization_url']);
        return redirect($tranx['data']['authorization_url']);
    }

    public function callback()
    {
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            die('No reference supplied');
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_test_2b810b3656e15df277a22ff2ecff66f8183f2f12",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if (!$tranx->status) {
            // there was an error from the API
            die('API returned error: ' . $tranx->message);
        }

        if ('success' == $tranx->data->status) {
            $ses = session()->get('ses_store');
            $get_balance = wallet::where('user_id', auth()->id())->first();
            // dd($get_balance);
            $wallet_data = [
                'user_id' => auth()->id(),
                'amount' => $ses['amount']
            ];
            if (empty($get_balance)) {
                wallet::create($wallet_data);
            } else {
                $wallet = new wallet();
                $newamount = $get_balance['amount'] + $ses['amount'];
                $wallet_data['amount'] = $newamount;
                $wallet->where('id', $get_balance['id'])->update($wallet_data);
            }
            return redirect()->route('fund')->with('success', 'Account funded');
        } else {
            return redirect()->route('fund')->with('error', 'Error funding account');
        }
    }
}
