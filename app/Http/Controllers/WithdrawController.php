<?php

namespace App\Http\Controllers;

use App\Models\UserBank;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $getbank = UserBank::where('user_id', auth()->id())->first();
        if(empty($getbank)){
            return redirect()->route('addbank');
        }
        
        return view('withdraw.withdraw');
    }

    public function process(Request $request)
    {
    
    $url = "https://api.paystack.co/transferrecipient";

    $fields = [
        'type' => "nuban",
        'name' => auth()->user()->bank->acc_name,
        'account_number' => auth()->user()->bank->acc_number,
        'bank_code' => auth()->user()->bank->bank_code,
        'currency' => "NGN"
    ];
    // dd($fields);
    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer sk_test_2b810b3656e15df277a22ff2ecff66f8183f2f12",
        "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    // echo $result;
    $res = json_decode($result);
    // dd($res);
    if($res->status){
        // dd($res->data->recipient_code);
        $ses_store['recipient_code'] = $res->data->recipient_code;
        // dd($ses_store);
        $url = "https://api.paystack.co/transfer";
        $fields = [
            'source' => "balance",
            'amount' => $request->amount,
            'recipient' => $res->data->recipient_code,
            'reason' => "Holiday Flexing"
        ];
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_2b810b3656e15df277a22ff2ecff66f8183f2f12",
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $result = curl_exec($ch);
        echo $result;


        session()->remove('withdraw');
    }
    }


    public function add_bank()
    {
        $bank = UserBank::where('user_id', auth()->id())->first();
        return view('withdraw/addbank', compact('bank'));
    }


    public function verify_bank(Request $request)
    {
        $acc_number = $request->acc_number;
        $bank_code = $request->bank_code;


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".rawurldecode($acc_number)."&bank_code=".rawurldecode($bank_code),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_2b810b3656e15df277a22ff2ecff66f8183f2f12",
            "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $verify = json_decode($response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            if($verify->status == "true")
            {
                $getbank = UserBank::where('user_id', auth()->id())->first();
                $acc_name = $verify->data->account_name;
                $data = [
                    'acc_number' => $acc_number,
                    'acc_name' => $acc_name,
                    'bank_code' => $bank_code,
                    'user_id' => auth()->id()
                ];
                UserBank::create($data);
                if(empty($getbank)){

                }else{
                    $acc_name = $verify->data->account_name;
                    $data = [
                        'acc_number' => $acc_number,
                        'acc_name' => $acc_name,
                        'bank_code' => $bank_code,
                        'user_id' => auth()->id()
                    ];
                    $userbank = new UserBank();
                    $userbank->where('user_id', auth()->id())->update($data);
                }
                return redirect()->route('addbank.add')->with('success', 'Account added' . $verify->data->account_name);
            } else {
                return redirect()->route('addbank.add')->with('error', 'Error adding account');
            }
        }
    }

}
