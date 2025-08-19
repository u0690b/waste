<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Client\Provider\GenericProvider;
use Storage;

class OAuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function hook(Request $request)
    {
        // if($request->input("error")) {
        //     $request->session()->flash('error', 'Task was successful!');
        //     return redirect('login')->with("error", $request->input("error"));
        // }


        // $danUser = Socialite::driver('dan')->stateless()->user();
        //  $user =$danUser->user;

        // $image_name = md5($user['regnum']).'.png';

        // Storage::disk('public')->put($image_name, base64_decode($user['image']));
        // $customer =  Customer::updateOrCreate(
        //     ['regnum' => $user['regnum']],
        //     [
        //         'firstname' => $user['firstname'],
        //         'gender' => $user['gender'],
        //         'image' =>  'storage/'.$image_name,
        //         'lastname' => $user['lastname'],
        //         'nationality' => $user['nationality'],
        //         'passportAddress' => $user['passportAddress'],
        //         'passportExpireDate' => $user['passportExpireDate'],
        //         'passportIssueDate' => $user['passportIssueDate'],
        //         'soumDistrictCode' => $user['soumDistrictCode'],
        //         'soumDistrictName' => $user['soumDistrictName'],
        //         'surname' => $user['surname'],
        //     ]
        // );
        // Log in this customer
        // Auth::logout();
         $customer = Customer::first();
        Auth::login($customer, true);
        return  redirect('/');
    }

     public function save_token(Request $request)
    {
        $request->validate([
            'push_token' => 'required|string',
        ]);

        Auth::user()->push_token = $request->push_token;
        Auth::user()->save();

        return true;
    }

}
