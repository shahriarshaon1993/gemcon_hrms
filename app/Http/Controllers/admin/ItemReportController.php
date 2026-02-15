<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\InventoryCategoryModel;
use App\Model\Vendor;
use App\Model\InventoryItemModel;
use App\Model\InventoryPosModel;
use App\Model\InventoryPosDetailsModel;
use App\Model\SalesPersonModel;
use App\Model\Customer;
use DB;
use DateTime;
use Auth;

class ItemReportController extends Controller
{

	public function index(Request $request)
    {

    }

    public function itemList(Request $request)
    {

        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Inventory Product list-Shorted By";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $query =InventoryItemModel::valid()
            ->select('inv_product.*','inv_product_category.category_name','inv_vendor.vendor_name','inv_product_category.id as inv_p_c')
            ->join('inv_product_category','inv_product.category_id','=','inv_product_category.id')
            ->join('inv_vendor','inv_product.vendor_id','=','inv_vendor.id');
        if($id){
          $query->where($order,$id); 
        }
        $data['reports_result'] = $query->orderBy($order,'asc')->get();
        return view('report.item-list-report',$data);
    }

    public function bestSeller(Request $request){

        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $colum = $request->input('colum');
        $data['id'] = $id;
        $data['colum'] = $colum;
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Inventory List";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $current_date=$year_end_date= date('Y-m-d');
        $date_explode= explode('-', $current_date);
        $year_start_date = $date_explode[0]."-"."01"."-"."01";

        $inv_query =InventoryItemModel::valid();
        if($colum == "category_id" && !empty($id)){
            $data['category_info'] =InventoryCategoryModel::valid()->find($id);
            $inv_query->where('category_id',$id);
        }else{
            if(!empty($id)){
                $data['vendor_info'] =Vendor::valid()->find($id);
                $inv_query->where('vendor_id',$id);   
            }
        }
        $inventory_list =$inv_query->get();
        $data['inventory_list'] =$inventory_list->keyBy('id')->all();
        $inv_codes = $inventory_list->pluck('id')->all();
        $sales_query =InventoryPosDetailsModel::valid()
        ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'))
        ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id');

        if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
            $sales_query->whereIn("product_id",$inv_codes);  
        }

        $sales_query->whereBetween('inv_pos.date', [$year_start_date, $year_end_date]);


        $data['reports_result'] =  $sales_query->orderBy('total_qty','desc')->groupBy('product_id')->get();

        return view('report.best-seller-report',$data);
    }

    public function worstSeller(Request $request){
        
        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $colum = $request->input('colum');
        $data['id'] = $id;
        $data['colum'] = $colum;
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Inventory List";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $current_date=$year_end_date= date('Y-m-d');
        $date_explode= explode('-', $current_date);
        $year_start_date = $date_explode[0]."-"."01"."-"."01";

        $inv_query =InventoryItemModel::valid();
        if($colum == "category_id" && !empty($id)){
            $data['category_info'] =InventoryCategoryModel::valid()->find($id);
            $inv_query->where('category_id',$id);
        }else{
            if(!empty($id)){
                $data['vendor_info'] =Vendor::valid()->find($id);
                $inv_query->where('vendor_id',$id);   
            }
        }
        $inventory_list =$inv_query->get();
        $data['inventory_list'] =$inventory_list->keyBy('id')->all();
        $inv_codes = $inventory_list->pluck('id')->all();
        $sales_query =InventoryPosDetailsModel::valid()
        ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'))
        ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id');

        if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
            $sales_query->whereIn("product_id",$inv_codes);  
        }

        $sales_query->whereBetween('inv_pos.date', [$year_start_date, $year_end_date]);


        $data['reports_result'] =  $sales_query->orderBy('total_qty','asc')->groupBy('product_id')->get();
        return view('report.worst-seller-report',$data);
    }

    public function invoiceHistory(Request $request)
    {
        $start_date = $request->input('start_date');
        $eding_date = $request->input('ending_date');
        $invoice_status = $request->input('invoice_status');
        $data['invoice_status'] = $invoice_status;
        $data['report_name'] = "Invoice History";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $data['csuromer_list'] =Customer::valid()->get()->keyBy('id')->all();
        $data['salesperson_list'] =SalesPersonModel::valid()->get()->keyBy('id')->all();
        if( $invoice_status =='invoice_number'){
            $query =InventoryPosModel::valid()->whereBetween('date', [$start_date,$eding_date])->orderBy($invoice_status,'asc')->get();
        }else{
            $query =InventoryPosModel::valid()->whereBetween('date', [$start_date,$eding_date])->get()->groupBy($invoice_status)->all();
        }
       /* echo "<pre>";
        print_r($query);
        exit();*/
        //$data['reports_result'] = $query->orderBy($order,'asc')->get();
        $data['reports_result'] =$query;
        return view('report.invoice-history-report',$data);
    }

    public function intemOnOrder(Request $request){
        
        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $colum = $request->input('colum');
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Inventory List";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');

        $query =InventoryItemModel::valid()
            ->select('inv_product.*','inv_product_category.category_name','inv_vendor.vendor_name')
            ->join('inv_product_category','inv_product.category_id','=','inv_product_category.id')
            ->join('inv_vendor','inv_product.vendor_id','=','inv_vendor.id');

        if($id){
            $query->where($colum,$id); 
        }
        $data['reports_result'] = $query->get();
        return view('report.items-on-order-report',$data);
    }

    public function pricelist(Request $request){
        
        $data['price_code'] = $request->input('item_value');
        $id = $request->input('by_id');
        $colum = $request->input('colum');
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        if($data['price_code']){
            $data['price_code_name'] = $request->input('price_code_name');
            $data['report_name'] = "Pirce List For Category";
        }else{
            $data['report_name'] = "Pirce List Items On Sale";
        }
        $query =InventoryItemModel::valid()
            ->select('inv_product.*','inv_product_category.category_name')
            ->join('inv_product_category','inv_product.category_id','=','inv_product_category.id');

        if($id){
          $query->where($colum,$id); 
        }

        $data['reports_result'] = $query->get();
        return view('report.pricelist-report',$data);

    }

    public function physicalInventory(Request $request){
        
        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $data['id'] = $id;
        $data['colum'] = $order;
        $item_list_type = $request->input('shorting_list_item');
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Physical Inventory List";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $current_date=$year_end_date= date('Y-m-d');
        $date_explode= explode('-', $current_date);
        $year_start_date = $date_explode[0]."-"."01"."-"."01";
        $query =InventoryItemModel::valid();
        if($id){
          $query->where($order,$id);
          $data['category_info'] =InventoryCategoryModel::valid()->find($id); 
        }

        if($item_list_type == 2){
            $query->where('qty_hand','>',0);
        }
        $sales_query =InventoryPosDetailsModel::valid()
        ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'))
        ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id');
        $sales_query->whereBetween('inv_pos.date', [$year_start_date, $year_end_date]);
        $data['sales_query'] =$sales_query->groupBy('product_id')->get()->keyBy('product_id')->all();
        $data['reports_result'] = $query->orderBy($order,'asc')->get();
        return view('report.physicainventory-report',$data);

    }


    public function itemValueByCategory(Request $request){
        
        $data['value_by'] = $request->input('item_value');
        $id = $request->input('by_id');
        $data['item_list_type'] = $request->input('shorting_list_item');
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Inventory Value By Category";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $inv_query=InventoryItemModel::valid();
        $inv_cat_query = InventoryCategoryModel::valid();
        if($id){
          $inv_query->where('category_id',$id);
          $inv_cat_query->where('id',$id);
        }
        $data['reports_result']=$inv_query->get()->groupBy('category_id')->all();
        $data['category_name'] =$inv_cat_query->get()->keyBy('id')->all();
        return view('report.item-value-by-category-report',$data);

    }

    public function itemValueByVendor(Request $request){
        
        $id = $request->input('by_id');
        $data['shorting_name'] = "Average Cost";
        $data['report_name'] = "Inventory Value By Vendor Using";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $inv_query=InventoryItemModel::valid();
        $inv_cat_query = Vendor::valid();
        if($id){
          $inv_query->where('vendor_id',$id);
          $inv_cat_query->where('id',$id);
        }
        $data['reports_result']=$inv_query->get()->groupBy('vendor_id')->all();
        $data['vendor_name'] =$inv_cat_query->get()->keyBy('id')->all();
        return view('report.item-value-by-vendor-report',$data);

    }

    public function itemBelowReorder(Request $request){
        
        $order = $request->input('item_value');
        $id = $request->input('by_id');
        $data['shorting_name'] = $request->input('shorting_name');
        $data['report_name'] = "Item Below Reorder Level";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('F d, Y');
        $query =InventoryItemModel::valid();

        if($id){
          $query->where($order,$id); 
        }

        $data['reports_result'] = $query->orderBy($order,'asc')->get();
        return view('report.item-below-reorder-report',$data);

    }

    public function iventorySales(Request $request){
        
        $period_status = $request->input('period_status');
        $data['period_status'] = $period_status;
        $id = $request->input('by_id');
        $colum = $request->input('colum');
        $data['id'] = $id;
        $data['colum'] = $colum;
        $data['report_name'] = "Inventory Sales Report";
        $data['report_title'] = "Inventory Report";
        $data['reportDate'] = date('Y-m-d');

        $current_date =$month_end_date=$year_end_date= date('Y-m-d');
        $date_explode= explode('-', $current_date);
        $data['priod'] = 'Daily';
        if($period_status > 0){
            if($period_status == 2){
                $data['priod'] = 'Monthly';
                $month_start_date = $date_explode[0]."-".$date_explode[1]."-"."01";
            }elseif ($period_status == 3) {
                $data['priod'] = 'Year-To-Date';
               $year_start_date = $date_explode[0]."-"."01"."-"."01"; 
            }
        }else{
            $month_start_date = $date_explode[0]."-".$date_explode[1]."-"."01";
            $year_start_date = $date_explode[0]."-"."01"."-"."01";
        }

        //$inv_query =InventoryItemModel::valid()->get()->keyBy('inv_code')->all();
        $inv_query =InventoryItemModel::valid();
        if($colum == "category_id" && !empty($id)){
            $data['category_info'] =InventoryCategoryModel::valid()->find($id);
            $inv_query->where('category_id',$id);
        }else{
            if(!empty($id)){
                $data['vendor_info'] =Vendor::valid()->find($id);
                $inv_query->where('vendor_id',$id);   
            }
        }

        $inventory_list =$inv_query->get();
        $data['inventory_list'] =$inventory_list->keyBy('id')->all();
        $inv_codes = $inventory_list->pluck('id')->all();
        if($period_status > 0){
            $sales_query =InventoryPosDetailsModel::valid()
            ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'), DB::raw('SUM(inv_pos_details.product_price*inv_pos_details.product_qty) as total_sales'))
            ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id');

            if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
                $sales_query->whereIn("product_id",$inv_codes);
            }

            if($period_status == 1){
                $sales_query->where('inv_pos.date', $current_date);
            }else if($period_status == 2){
                $sales_query->whereBetween('inv_pos.date', [$month_start_date, $current_date]);
            }else{
                $sales_query->whereBetween('inv_pos.date', [$year_start_date, $current_date]);
            }

            $data['sales_list'] =  $sales_query->groupBy('product_id')->get(); 
        }else{
            
            $sales_daily_query_d =InventoryPosDetailsModel::valid()
                ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'), DB::raw('SUM(inv_pos_details.product_price*inv_pos_details.product_qty) as total_sales'))
                ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id')
                ->where('inv_pos.date', $current_date);
            if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
                $sales_daily_query_d->whereIn("product_id",$inv_codes);  
            }
            $sales_daily_query = $sales_daily_query_d->groupBy('product_id')->get()->keyBy('product_id')->all();
            $sales_monthly_query_m =InventoryPosDetailsModel::valid()
                ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'), DB::raw('SUM(inv_pos_details.product_price*inv_pos_details.product_qty) as total_sales'))
                ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id')
                ->whereBetween('inv_pos.date', [$month_start_date, $current_date]);
            if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
                $sales_monthly_query_m->whereIn("product_id",$inv_codes);  
            }
            $sales_monthly_query=$sales_monthly_query_m->groupBy('product_id')->get()->keyBy('product_id')->all();
            $sales_yearly_query_y =InventoryPosDetailsModel::valid()
                ->select('inv_pos_details.product_id', DB::raw('SUM(inv_pos_details.product_qty) as total_qty'), DB::raw('SUM(inv_pos_details.product_price*inv_pos_details.product_qty) as total_sales'))
                ->join('inv_pos', 'inv_pos_details.pos_id', '=', 'inv_pos.id')
                ->whereBetween('inv_pos.date', [$year_start_date, $current_date]);
            if(!empty($id) && ($colum == "category_id" || $colum == "vendor_id")){
                $sales_yearly_query_y->whereIn("product_id",$inv_codes); 
            }
            $sales_yearly_query=$sales_yearly_query_y->groupBy('product_id')->get()->keyBy('product_id')->all();
            $sales_data = [];
            foreach ($data['inventory_list'] as $k => $v){
                if(array_key_exists($v->id, $sales_daily_query) || array_key_exists($v->id, $sales_monthly_query) || array_key_exists($v->id, $sales_yearly_query)){
                    // daily 
                    if(array_key_exists($v->id, $sales_daily_query)){
                        $dailyPosInfo = $sales_daily_query[$v->id]; 
                        $daily_sold_qty = $dailyPosInfo->total_qty; 
                        $daily_total_sale = $dailyPosInfo->total_sales;
                        $daily_total_avg_cost = $dailyPosInfo->total_qty*$v->avg_cost;
                        $daily_total_profit = $daily_total_sale-$daily_total_avg_cost;
                    }else{
                        $daily_sold_qty = 0; $daily_total_sale = 0; $daily_total_avg_cost = 0; $daily_total_profit = 0;
                    }
                    // monthly 
                    if(array_key_exists($v->id, $sales_monthly_query)){
                        $monthlyPosInfo = $sales_monthly_query[$v->id]; 
                        $monthly_sold_qty = $monthlyPosInfo->total_qty; 
                        $monthly_total_sale = $monthlyPosInfo->total_sales;
                        $monthly_total_avg_cost = $monthlyPosInfo->total_qty*$v->avg_cost;
                        $monthly_total_profit = $monthly_total_sale-$monthly_total_avg_cost;
                    }else{
                        $monthly_sold_qty = 0; $monthly_total_sale = 0; $monthly_total_avg_cost = 0; $monthly_total_profit = 0;
                    }
                    // yearly 
                    if(array_key_exists($v->id, $sales_yearly_query)){
                        $yearlyPosInfo = $sales_yearly_query[$v->id]; 
                        $yearly_sold_qty = $yearlyPosInfo->total_qty; 
                        $yearly_total_sale = $yearlyPosInfo->total_sales;
                        $yearly_total_avg_cost = $yearlyPosInfo->total_qty*$v->avg_cost;
                        $yearly_total_profit = $yearly_total_sale-$yearly_total_avg_cost;
                    }else{
                        $yearly_sold_qty = 0; $yearly_total_sale = 0; $yearly_total_avg_cost = 0; $yearly_total_profit = 0;
                    }

                    $sales_data[] = (object)[
                        'inv_code' => $v->inv_code,
                        'inv_product_name' => $v->inv_product_name,
                        'inv_product_name' => $v->inv_product_name,
                        'daily_sold_qty' => $daily_sold_qty,
                        'daily_total_sale' => $daily_total_sale,
                        'daily_total_avg_cost' => $daily_total_avg_cost,
                        'daily_total_profit' => $daily_total_profit,
                        'monthly_sold_qty' => $monthly_sold_qty,
                        'monthly_total_sale' => $monthly_total_sale,
                        'monthly_total_avg_cost' => $monthly_total_avg_cost,
                        'monthly_total_profit' => $monthly_total_profit,
                        'yearly_sold_qty' => $yearly_sold_qty,
                        'yearly_total_sale' => $yearly_total_sale,
                        'yearly_total_avg_cost' => $yearly_total_avg_cost,
                        'yearly_total_profit' => $yearly_total_profit
                    ];
                }
            }

            $data['sales_list'] = $sales_data;             
            
        }

        return view('report.inventory-sales-report',$data);

    }

    public function arAsingReport(Request $request){
        $order = $request->input('report_value');
        $data['report_name'] = "Ar Aging Report";
        $data['report_title'] = "Account Receiveable";
        $data['reportDate'] = date('Y-m-d');
        $current_date =$month_end_date=$year_end_date= date('Y-m-d');
        $date_explode= explode('-', $current_date);
        $month_start_date = $date_explode[0]."-".$date_explode[1]."-"."01";
        $year_start_date = $date_explode[0]."-"."01"."-"."01";
        $second_date = new DateTime($current_date);

        /*$customer_list = Customer::valid()->get()->keyBy('id')->all();
        $pos_query = InventoryPosModel::valid()->get()->groupBy('customer_name')->all();*/

        $pos_query = InventoryPosModel::valid()
        ->join('inv_customer','inv_customer.id', '=', 'inv_pos.customer_name')
        ->select('inv_customer.customer_name as customer_order','inv_customer.*','inv_pos.*')
        ->orderBy($order,'asc')->get()->groupBy('customer_order')->all();

        $data['due_info'] = [];
        $curent = 0;
        $days_30_60 = 0;
        $days_60_90 = 0;
        $days_plus_90 = 0;

        foreach ($pos_query as $key => $result) {
            foreach ($result as $value) {

                $first_date = new DateTime($value['date']);
                $interval = $first_date->diff($second_date);
                $days = $interval->format('%a');

                if($days > 30){
                   $days_30_60 += $value['total_due'];
                }elseif($days > 60){
                    $days_60_90 += $value['total_due'];
                }elseif($days > 90){
                    $days_plus_90 += $value['total_due'];
                }else{
                    $curent += $value['total_due'];
                }
            }

            array_push($data['due_info'],['customer' => $key,
                                  'current'  => $curent,
                                  'days_30_60'  => $days_30_60,
                                  'days_60_90'  => $days_60_90,
                                  'days_plus_90'  => $days_plus_90
                                ]);

            $curent = 0;
            $days_30_60 = 0;
            $days_60_90 = 0;
            $days_plus_90 = 0;

        }
        //return $data['due_info'];
        return view('report.account-receiveable',$data);
         
    }

    public function create()
    {
        $data['item_value'] = "";
        $data['categories'][0]=['id'=>'','text'=>"--All--"];
        $data['category_value'] = ['id'=>'','text'=>"--All--"];
        $categories = InventoryCategoryModel::valid()->get();
        foreach ($categories as $value) {
            array_push($data['categories'],['id'=>$value['id'],'text'=>$value['category_name']]);
        }

        $data['vendors'][0]=['id'=>'','text'=>"--All--"];
        $data['vendor_value'] =['id'=>'','text'=>"--All--"];
        $vendors = Vendor::valid()->get();
        foreach ($vendors as $value) {
            array_push($data['vendors'],['id'=>$value['id'],'text'=>$value['vendor_name']]);
        }

        return response($data);
    }
    
    public function store(Request $request)
    {
        
    }

    public function edit(Request $request)
    {

    }

    public function destroy(Request $request)
    {
    

    }
    
    
}
