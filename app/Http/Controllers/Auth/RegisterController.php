<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Invitation_code;
use Alert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator =  Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // 'kode_undangan' => ['required','exists:invitation_codes,code']
            'username' => ['required','string','min:4','max:16','unique:users'],
            'phone' => ['required','numeric','digits_between:5,15']
        ]);

        if($validator->fails()) {
            return $validator;
        }
        // $inv = Invitation_code::where('code',$data['kode_undangan'])->first();
        // if($inv->remains == 0) {
        //     Alert::error('Kode undangan sudah dipakai');
        //     session()->flash('danger','Kode undangan sudah dipakai');
        //     return redirect()->back();
        // }else{
        //     $update = Invitation_code::find($inv->id);
        //     $update->remains -= 1;
        //     if($inv->remains == 1) {
        //         $update->status = "Redeemed";
        //     }
        //     $update->save();


        Alert::success('Sukses daftar!','Sukses');
        session()->flash('success','Sukses daftar! Silahkan login');
            
        // }
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['first_name']." ".$data['last_name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'balance' => 0,
            'level' => 'Member',
            'status' => 'Active',
            'api_key' => Hash::make(Str::random(5)),
            'uplink' => 'Server',
        ]);
    }
}
