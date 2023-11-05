<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $usertype = Auth::user()->usertype;
        if ($usertype == '1') {
            $users = User::select('id', 'username', 'firstname', 'email', 'address')->get();
            return view('admin.home', ['users' => $users]);

        } else {
            return view('pages.dashboard');
        }
    }

}