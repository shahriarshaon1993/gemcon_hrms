<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CompanyConfigur;
use Auth;

class CompanyConfigurController extends Controller
{

    public function index(Request $request)
    {   
        $custest = CompanyConfigur::first();
        return response()->json($custest);
    }

    public function store(Request $request)
    {
        $custest = CompanyConfigur::first();

        $data = $request->only('company_name','company_address','company_city','next_trade_number','sales_tax_a','sales_tax_b','sales_tax_c','sales_tax_d','account_header_a','account_header_b','account_header_c','account_header_d','calculate_profit_type');

        if($custest){
            $save =  CompanyConfigur::valid()->findOrFail($custest->id)->update($data);
        }else{ 
            $save =   CompanyConfigur::create($data);
        }
        
        if($save){
            $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }else{
            $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
        }        
        return response()->json($output);
    }

    public function edit(Request $request)
    {

        $vedor = CompanyConfigur::valid()->findOrFail($request->id);
        return response($vedor);
    }

    public function destroy(Request $request)
    {
        

    }

    public function create()
    {
        return response();
    }

}
