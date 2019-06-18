<?php

namespace App\Http\Controllers;

use DB;
use App\Transaction;
use Carbon\Carbon;
use Auth;
use Session;
use Validator;
use App\User;
use App\Deposit;
use App\Balance_history;
use App\Activity;
use App\PaymentMethod;
use App\PaymentLog;
use App\BankInvoice;
use App\Referral;
use CekmutasiBank;
use Illuminate\Http\Request;

class BankPaymentController extends Controller
{
    private $bank_payment_methods = ['201' => 'bri', '202' => 'bni', '203' => 'bca', '204' => 'mandiri']; // bank detail
    private $payment_method_id = 5; // bank
    
    public function showForm(Request $request)
    {
        $paymentMethod = PaymentMethod::where(['id' => $this->payment_method_id, 'status' => 'ACTIVE'])->first();
        if( is_null($paymentMethod) ){
            return redirect('payment/add-funds/bank')->with("error_msg", "Something went wrong");
        }
        if( empty(Auth::user()->enabled_payment_methods) ){
            abort(403);
        }
        
        $enabled_payment_methods = explode(',', Auth::user()->enabled_payment_methods);
        if (!in_array($this->payment_method_id, $enabled_payment_methods)) {
            abort(403);
        }
        
        $banks = PaymentMethod::whereIn('id', array_keys($this->bank_payment_methods))->where('status', 'ACTIVE')->get();
        $logo = PaymentMethod::where(['slug' => $paymentMethod->slug, 'config_key' => $this->payment_method_id.'_logo'])->first()->config_value;
        
        return view('payments.bank', compact('banks', 'logo'));
    }
    
    public function datatable()
    {
        $invs = BankInvoice::with('paymentMethod')
                            ->whereIn('payment_method_id', array_keys($this->bank_payment_methods))
                            ->where('user_id', Auth::user()->id);
                            
        return datatables()
            ->of($invs)
            ->editColumn('amount', function ($inv) {
                return number_format($inv->amount, 0, '', '.');
            })
            ->editColumn('status', function ($inv) {
                if( $inv->status == 'PENDING' ) {
                    return 'Menunggu Pembayaran';
                }
                elseif( $inv->status == 'VALIDATION' ) {
                    return 'Proses Validasi';
                }
                elseif( $inv->status == 'SUCCESS' ) {
                    return 'Berhasil';
                }
                elseif( $inv->status == 'EXPIRED' ) {
                    return 'Expired';
                }
                else {
                    return 'Unknown';
                }
            })
            ->editColumn('created_at', function ($inv) {
                return strftime('%d %b %Y %H:%M', (strtotime($inv->created_at) + (23*60*60)));
            })
            ->editColumn('paymentMethod.config_value', function ($inv) {
                $bank = json_decode($inv)->payment_method->config_value;
                $bank = json_decode($bank);
                return $bank->nama_bank.' '.$bank->no_rek.' / '.$bank->nama;
            })
            ->editColumn('action', function($inv) {
                return "<button onclick=\"javascript:window.open('".url('/payment/add-funds/bank/inv/'.$inv->id)."', '_blank');\" type=\"submit\" class=\"btn btn-primary\">Detail</button>";
            })
            ->toJson();
    }

    public function store(Request $request)
    {
        $minimum_deposit_amount = getOption('minimum_deposit_amount');
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $minimum_deposit_amount,
            'bank' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('payment/add-funds/bank')
                ->withErrors($validator)
                ->withInput();
        }

        if( PaymentMethod::where(['id' => $request->input('bank'), 'status' => 'ACTIVE'])->count() <= 0 )
        {
            return redirect('payment/add-funds/bank')
                    ->with("error_msg", "Something went wrong")
                    ->withInput();
        }

        $idr = $request->input('amount');
        if( substr($idr, -3) != '000' ) return redirect('payment/add-funds/bank')->with("error_msg", "Jumlah deposit harus dalam kelipatan 1000. Misal 10000, 50000, 51000, 100000")->withInput();
        $idr = $idr + mt_rand(10, 999);
        $idr = number_format($idr, 0, '', '');
        
        for( $i=1; $i<=10; $i++ )
        {
            $isExist = (BankInvoice::where(['amount' => $idr, 'payment_method_id' => $request->input('bank')])->whereIn('status', ['PENDING', 'VALIDATION'])->count() > 0 ? true : false);
    
            if( $isExist )
            {
                if( $i == 10 ) return redirect('payment/add-funds/bank')->with("error_msg", "Terjadi kesalahan sistem. Silahkan diulang")->withInput();
                
                $idr = $idr + mt_rand(1, 100);
                
                continue;
            }
            else
            {
                break;
            }
        }
        
        $inv = new BankInvoice;
        $inv->user_id = Auth::user()->id;
        $inv->amount = $idr;
        $inv->rates = 1;
        $inv->payment_method_id = $request->input('bank');
        $inv->status = 'PENDING';
        $inv->save();
        
        if( isset($inv->id) )
        {
            if( $inv->id > 0 )
            {
                return redirect('payment/add-funds/bank/inv/'.$inv->id);
            }
            return redirect('payment/add-funds/bank')->with("error_msg", "Something went wrong")->withInput();
        }
        return redirect('payment/add-funds/bank')->with("error_msg", "Something went wrong")->withInput();
    }
    
    public function showInvoice(Request $request, $id)
    {
        $invoiceID = $id;
        
        if( $invoiceID > 0 )
        {
            $inv = BankInvoice::where(['id' => $invoiceID, 'user_id' => Auth::user()->id])->first();
            $bank = PaymentMethod::where('id', @$inv->payment_method_id)->first();
            if( is_null($inv) || is_null($bank) )
            {
                return redirect('payment/add-funds/bank')->with("error_msg", "Something went wrong");
            }
            $bank = json_decode($bank->config_value);
        }
        else
        {
            return redirect('payment/add-funds/bank')->with("error_msg", "Invalid invoice ID");
        }
        
        return view('payments.bank_invoice', compact('inv', 'bank'));
    }
    
    public function confirm(Request $request, $id)
    {
        $invoiceID = $id;
        
        $inv = BankInvoice::where('id', $invoiceID)
                            ->where('user_id', Auth::user()->id)
                            ->where('status', 'PENDING')
                            ->first();
        if( !$inv ) return redirect('payment/add-funds/bank')->with("error_msg", "Invoice tidak ditemukan / sudah dikonfirmasi / expired / sukses");
            
        $inv->status = 'VALIDATION';
        $inv->save();
        
        return redirect()->back()->with('success_msg', 'Pembayaran berhasil dikonfirmasi. Selanjutnya sistem akan melakukan pengecekan dan validasi pembayaran secara berkala. Mohon menunggu max 60 menit kedepan');
    }
    
    public function cron()
    {
        $apikey = env('CEKMUTASI_API_KEY');
        $today = Carbon::today()->format('Y-m-d H:i:s');
        $todayLastMinute = date('Y-m-d')." 23:59:59";
        $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name as method_name','deposit_methods.data','deposit_methods.code')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->whereNotIn('deposit_methods.name',['pulsa'])
                                ->where('deposit_methods.type','AUTO')
                                ->whereBetween('deposits.created_at',[$today,$todayLastMinute])
                                ->get();
        foreach($deposits as $deposit) {
                $norek = $deposit->data;

                $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::parse($deposit->created_at)->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(12)->format('Y-m-d H:i:s')
                                        ),
                                'type' => 'credit',
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );
                if($deposit->code == 'gopay') {
                    $endpoint = "https://api.cekmutasi.co.id/v1/gopay/search";
                } else if($deposit->code == 'ovo') {
                    $endpoint = "https://api.cekmutasi.co.id/v1/ovo/search";
                    $data['search']['account_number'] = $norek;
                } else {
                    $endpoint = "https://api.cekmutasi.co.id/v1/bank/search";
                    $data['search']['service_code'] = $data->code;
                }
                
                // dd($data);
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL             => $endpoint,
                    CURLOPT_POST            => true,
                    CURLOPT_POSTFIELDS      => http_build_query($data),
                    CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                    CURLOPT_SSL_VERIFYHOST  => 0,
                    CURLOPT_SSL_VERIFYPEER  => 0,
                    CURLOPT_RETURNTRANSFER  => true,
                    CURLOPT_HEADER          => false
                ));
                $chresult = curl_exec($ch);
                curl_close($ch);

                $json_result = json_decode($chresult, true);
                // dd($json_result);

                if( $json_result['success'] === true )
                {
                    if( count($json_result['response']) > 0 )
                    {
                        $firstResponse = $json_result['response'][0];
                        $log = $firstResponse;
                        
                        if( number_format($firstResponse['amount'], 0, '', '') == $deposit->quantity )
                        {   
                            $update = Deposit::find($deposit->id);
                            $update->status = 'Success';
                            $update->save();

                            $balance_history = new Balance_history;
                            $balance_history->user_id = $deposit->user_id;
                            $balance_history->action = "Add Balance";
                            $balance_history->quantity = $deposit->get_balance;
                            $balance_history->desc = "Deposit Sukses Melalui ".$deposit->method_name." Rp ".$deposit->get_balance." (ID: $deposit->id)";
                            $balance_history->save();

                            echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                        }
                    }
                }
        }
    }
}