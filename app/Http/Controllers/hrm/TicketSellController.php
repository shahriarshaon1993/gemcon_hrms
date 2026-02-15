<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\TicketOpen;
use Auth;
use Session;
use App\Model\TicketSell;
use App\Model\TicketSellDetails;
use Cache;
use Illuminate\Support\Facades\DB;
use permission;
// use App\Model\UserRoleAccess;

class TicketSellController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function useticket(Request $request)
  {
    // update
    try {
      DB::beginTransaction();
      $updatedata = TicketSellDetails::find($request->id);
      $updatedata->ticket_status = 1;
      $updatedata->save();
      $getdata = TicketSell::find($updatedata->sell_id);
      $getdata->used_ticket = $getdata->used_ticket + 1;
      $getdata->save();
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return response($message = ['status' => 0, 'message' => 'Something went wrong. Please try again.']);
    }
    return response($message = ['status' => 1, 'message' => 'Ticket used successfully']);
  }
  public function unusedticket(Request $request)
  {
    $getdata = TicketSellDetails::valid()->project()
      ->where('ticket_number', 'like', '%' . $request->ticket_number . '%')
      ->where('ticket_status', 0)
      ->with('jointicketsell')
      ->limit(10)
      ->get();
    return response()->json($getdata);
  }
  public function index(Request $request)
  {

    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'TicketSell')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
    foreach ($permission as $child) {
      if ($child['link_uid'] == 'add') {
        $data['add'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'edit') {
        $data['edit'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'delete') {
        $data['delete'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'use') {
        $data['use'] = $child['link_uid'];
      } else {
        $data['approve'] = $child['link_uid'];
      }
    }
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    if ($request->input('sort') == 'id') {
      $order = 'ASC';
      $sort = 'id';
    } else {
      $order = $request->input('order');
      $sort = $request->input('sort');
    }

    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $paginate_data = TicketSell::valid()->project()->when($search_key, function ($query, $search_key) {
      $query->where(function ($query2) use ($search_key) {
        $query2->where('total_ticket', 'LIKE', '%' . $search_key . '%');
      });
      return $query;
    })->where('project_id', $project_id)->orderBy($sort, $order);
    // ->orderBy($sort,$order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;

    $data['employee_data'] = array();
    $employee_data = Employee::valid()->project()->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }
    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('ticket_status', 2)->toArray());
    $data['active_data'] = count(collect($sortGetData)->where('ticket_status', 1)->toArray());
    $data['paginate_data'] = $sortData->paginate($paginate_num);

    return response()->json($data);
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
    // echo "ok_now"; die();
    $validate = [
      'emp_id' => 'required',
      'total_ticket' => 'required',
      // 'ticket_price_per' => 'required'
    ];
    $ticket_last_data = TicketOpen::valid()->project()->orderBy('id', 'DESC')->first();
    $ticket_sell_data = TicketSell::valid()->project()->where('open_id', $ticket_last_data->id)->sum('total_ticket');
    // dd($ticket_sell_data);
    if (!$ticket_last_data) {
      return response($message = ['status' => 0, 'message' => 'Please open ticket']);
    }
    if ($ticket_sell_data >= $ticket_last_data->total_ticket) {
      return response($message = ['status' => 0, 'message' => 'Ticket Empty, Please open ticket' . $ticket_sell_data . '/' . $ticket_last_data->total_ticket]);
    }
    $request->validate($validate);
    $data['total_ticket'] = $request->input('total_ticket');
    $data['total_price'] = $request->input('total_ticket') * $ticket_last_data->ticket_price_per;
    $data['ticket_price_per'] = $ticket_last_data->ticket_price_per;
    $data['open_id'] = $ticket_last_data->id;
    $data['date'] = $request->date;
    $data['emp_id'] = $request->emp_id;
    // $data = $request->only('total_ticket', 'ticket_price_per', 'date');
    if (!empty($request->id)) {
      $update_data = TicketSell::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->branch_id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {

      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['ticket_status'] = 0;
      $save_data = TicketSell::create($data);
      for ($i = 0; $i < $request->input('total_ticket'); $i++) {
        $dtldata['project_id'] = Auth::guard('user')->user()->project_id;
        $dtldata['branch_id'] = Auth::guard('user')->user()->branch_id;
        $dtldata['created_by'] = Auth::guard('user')->user()->id;
        $dtldata['sell_id'] = $save_data->id;
        $dtldata['ticket_status'] = 0;
        $dtldata['ticket_number'] = time() + $i;
        TicketSellDetails::create($dtldata);
      }
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $edit_data = TicketSell::valid()->project()->findOrFail($id);
    return response($edit_data);
  }

  public function destroy($id)
  {

      $delete_data = TicketSell::valid()->project()->findOrFail($id);
      if($delete_data->used_ticket > 0){
        $message = ['status' => 0, 'message' => 'This ticket is already sold'];
        if ($delete_data->delete()) {
          $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
      }
  }
}
