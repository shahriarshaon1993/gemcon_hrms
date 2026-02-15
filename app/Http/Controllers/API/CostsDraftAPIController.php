<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCostsDraftAPIRequest;
use App\Http\Requests\API\UpdateCostsDraftAPIRequest;
use App\Models\CostsDraft;
use App\Repositories\CostsDraftRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController; 
use App\Models\Product;
use App\Models\Cost;
use App\Imports\CostsDraftImport; 
use App\Models\CostGl;
use App\Models\Factory;
use App\Models\CostCenter;
use App\Http\Resources\CostDraftResource;
use Illuminate\Support\Facades\Storage; 
use Maatwebsite\Excel\Facades\Excel;
use Auth ;
use Response;
  
/**
 * Class CostsDraftController
 * @package App\Http\Controllers\API
 */

class CostsDraftAPIController extends AppBaseController
{
    /** @var  CostsDraftRepository */
    private $costsDraftRepository;

    public function __construct(CostsDraftRepository $costsDraftRepo)
    {
        $this->costsDraftRepository = $costsDraftRepo;
    }

    /**
     * Display a listing of the CostsDraft.
     * GET|HEAD /costsDrafts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $costsDrafts = $this->costsDraftRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        $items = CostsDraft::orderBy('id', 'desc')->limit(1500)->get();    
        $items = CostDraftResource::collection($items);    

        return $this->sendResponse($items, 'Costs Drafts retrieved successfully');
    }

    public function fileUpload(Request $request){ 
        if ($request->hasFile('csvFile')) { 
            $data = Excel::import(new CostsDraftImport, request()->file('csvFile'));
            return $this->sendResponse($data, 'Costs Drafts retrieved successfully'); 
        }else{
            return $this->sendResponse(0, 'Cost error '); 
        } 
    }

    public function sync(){
        $items = CostsDraft::where('status',0)->orderBy('id', 'desc')->get(); 
      
        foreach ($items as $key => $value) {   
            $costgl = CostGl::where('gl_code',$value['gl_code'])->first();
            if($costgl){
                $cost_center = CostCenter::where('cost_code',$value['cost_center'])->first();
                if($cost_center){
                    $factory = Factory::where('fac_code',$value['factory_code'])->first();  
                        if($factory){

                            $data =  Cost::create([
                                'cost_center_id' =>  $cost_center ?  $cost_center->id : 0, 
                                'cost_gl_id' =>  $costgl['id'] ? $costgl['id'] : '0', 
                                'summary_group_id' =>  $cost_center ? $cost_center->summary_group_id : 0 ,  
                                'cost'  => $value['cost'], 
                                'factory_code' => $value['factory_code'],
                                'date' => date('Y-m-d H:i:s', strtotime($value['date']))  , 
                                'factory_id' => $factory['id'] ? $factory['id'] : '' , 
                                'remarks' => $value['remarks'], 
                                'created_by' => Auth::guard('user')->user()->id ,  
                                'updated_by' => Auth::guard('user')->user()->id ,
                            ]);  
                            if($data){
                                CostsDraft::where('id',$value['id']) 
                                ->update(['status' => 1]); 
                            }  

                        }else{
                            CostsDraft::where('id',$value['id']) 
                            ->update(['error_note' => 'Factory not found']); 
                        } 
                }else{ 
                    CostsDraft::where('id',$value['id']) 
                    ->update(['error_note' => 'Cost center not found']);    
                }


            }else{ 
                CostsDraft::where('id',$value['id']) 
                ->update(['error_note' => 'Cost GL not found']);    
            }
             

        } 
        return $this->sendResponse(1, 'Costs Drafts sync successfully'); 
       // return redirect('/costs_draft');

    }

    /**
     * Store a newly created CostsDraft in storage.
     * POST /costsDrafts
     *
     * @param CreateCostsDraftAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCostsDraftAPIRequest $request)
    {
        $input = $request->all();

        $costsDraft = $this->costsDraftRepository->create($input);

        return $this->sendResponse($costsDraft->toArray(), 'Costs Draft saved successfully');
    }

    /**
     * Display the specified CostsDraft.
     * GET|HEAD /costsDrafts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CostsDraft $costsDraft */
        $costsDraft = $this->costsDraftRepository->find($id);

        if (empty($costsDraft)) {
            return $this->sendError('Costs Draft not found');
        }

        return $this->sendResponse($costsDraft->toArray(), 'Costs Draft retrieved successfully');
    }

    /**
     * Update the specified CostsDraft in storage.
     * PUT/PATCH /costsDrafts/{id}
     *
     * @param int $id
     * @param UpdateCostsDraftAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCostsDraftAPIRequest $request)
    {
        $input = $request->all();

        /** @var CostsDraft $costsDraft */
        $costsDraft = $this->costsDraftRepository->find($id);

        if (empty($costsDraft)) {
            return $this->sendError('Costs Draft not found');
        }

        $costsDraft = $this->costsDraftRepository->update($input, $id);

        return $this->sendResponse($costsDraft->toArray(), 'CostsDraft updated successfully');
    }

    /**
     * Remove the specified CostsDraft from storage.
     * DELETE /costsDrafts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CostsDraft $costsDraft */
        $costsDraft = $this->costsDraftRepository->find($id);

        if (empty($costsDraft)) {
            return $this->sendError('Costs Draft not found');
        }

        $costsDraft->delete();

        return $this->sendSuccess('Costs Draft deleted successfully');
    }
}
