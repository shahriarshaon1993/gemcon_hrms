<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Model\CompanyConfigur;
use Auth;
use Session;
use DB;
use DateTime;
use App\Model\InventoryCategoryModel;
use App\Model\BranchModel;
use App\Model\InventoryPosModel;

class customerController extends Controller
{
    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =Customer::valid()->project()->when($search_key, function($query, $search_key){
                $query->where(function($query2) use ($search_key){
                    $query2->where('name','LIKE','%'.$search_key.'%')
                      ->orWhere('email','LIKE', '%'.$search_key.'%');
                });
                return $query;

        })->orderBy($sort,$order)->paginate($paginate_num);
        $data['formData']=['codeVisible' => false,'texcheck' => 0];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validation = [
            'customer_name' => 'required',
            'customer_contact' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required'
        ];
        $data = $request->only('customer_name','customer_contact','customer_address','customer_phone','customer_number','customer_fax','customer_email','customer_last_date_purchage','customer_comment','customer_credit_limit','allow_ar','charge_interest','allow_layaway','ar_blance_forward','total_ar_charges','customer_price_code','customer_sales_tax_number','non_taxable_customer','item_tax_code_1','item_tax_code_2','item_tax_code_3','customer_purchage_1','customer_purchage_2','customer_purchage_3');
        if(!empty($request->id)){
            $save =  Customer::valid()->project()->findOrFail($request->id)->update($data);
        }else{
            $save =   Customer::create($data);
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

        $customer = Customer::valid()->project()->findOrFail($request->id);
        $item_tex_codes = CompanyConfigur::first();
        $customer->items_tax_code_1 = $item_tex_codes->sales_tax_a;
        $customer->items_tax_code_2 = $item_tex_codes->sales_tax_b;
        $customer->items_tax_code_3 = $item_tex_codes->sales_tax_c;
        $customer->items_tax_code_4 = $item_tex_codes->sales_tax_d;
        if($customer->item_tax_code_1){
            $customer->non_taxable_customer = 1;
        }
        return response($customer);
    }

    public function destroy(Request $request)
    {

        $vendor = Customer::valid()->project()->findOrFail($request->id);

        if($vendor->delete()){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }

    public function home_des(){
        // $branch_list=BranchModel:: all()->toArray();
        // $data['labels']=BranchModel::orderBy('branch_name')->select('branch_name')
        // ->get()->toArray();
        // $data['amounts']=BranchModel::join('inv_pos','branch_info.id','=','inv_pos.branch_id')->orderBy('branch_name') ->groupBy('branch_name')
        // ->selectRaw('sum(total_pay) as totalSales, branch_name')
        // ->get()->toArray();

        $labels=BranchModel::orderBy('branch_name')->get()->toArray();
        $amounts=InventoryPosModel::groupBy('branch_id')
        ->selectRaw('sum(total_pay) as totalSales, branch_id')
        ->get()->toArray();
        foreach ($labels  as $key => $value) {
            $labels[$key]['totalSales']=collect($amounts)->where('branch_id','=',$value['id'])->sum('totalSales');
        }   
        $data['labels']=$labels;

        $data['catagory']=InventoryCategoryModel::join('inv_product','inv_product_category.id','=','inv_product.category_id')
        ->join('inv_pos_details','inv_product.id','=','inv_pos_details.product_id')
        ->join('inv_pos','inv_pos_details.pos_id','=','inv_pos.id')
        ->groupBy('category_name')
        ->selectRaw('sum(total_pay) as totalAmounts,category_name')
        ->get()->toArray();

        $query_date = date('Y-m-d',strtotime(date("Y-m-d")));
        $date = new DateTime($query_date);
        $date->modify('first day of this month');
        $firstday= $date->format('Y-m-d');
        $date->modify('last day of this month');
        $lastday= $date->format('Y-m-d');

        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));

      
        // return response()->json($thisYearsFristday);
        $totalSales=InventoryPosModel::where('date','>=',$thisYearsFristday)->where('date','<=',$lastday)->get()->toArray();
        $thislSales=collect($totalSales)->where('date','>=',$firstday)->where('date','<=',$lastday)->toArray();


        $data['ThisTotalCustomer']=collect($thislSales)->count('invoice_number');
        $data['ThisTotalSalese']=collect($thislSales)->sum('total_pay');
        $data['ThisTotaldiscount']=collect($thislSales)->sum('total_discount');
        $data['ThisTotalavg']=( $data['ThisTotalSalese']/ $data['ThisTotalCustomer']);

        $data['TotalCustomer']=collect($totalSales)->count('invoice_number');
        $data['TotalSalese']=collect($totalSales)->sum('total_pay');
        $data['Totaldiscount']=collect($totalSales)->sum('total_discount');
        $data['Totalavg']=( $data['TotalSalese']/ $data['TotalCustomer']);
        

        return response()->json($data);
      }


    public function create()
    {
        $item_tex_codes = CompanyConfigur::first();
        $data['items_tax_code_1'] = $item_tex_codes->sales_tax_a;
        $data['items_tax_code_2'] = $item_tex_codes->sales_tax_b;
        $data['items_tax_code_3'] = $item_tex_codes->sales_tax_c;
        $data['items_tax_code_4'] = $item_tex_codes->sales_tax_d;
        $data['texcheck'] = 0;
        return response($data);
    }
    
}
