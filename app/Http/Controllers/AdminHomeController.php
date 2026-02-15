<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\AdminModel;

class AdminHomeController extends Controller
{
    /***
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::guard('admin')->user()->id;
        $admin = AdminModel::findOrFail($id);
        return view('admin.app',compact('admin'));
    }
}
