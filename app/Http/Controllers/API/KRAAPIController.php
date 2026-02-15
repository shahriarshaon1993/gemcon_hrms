<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKRAAPIRequest;
use App\Http\Requests\API\UpdateKRAAPIRequest;
use App\Models\KRA;
use App\Models\KPI;
use App\Models\MOS; 
use App\Models\MosData; 
use App\Models\Department;
use App\Http\Resources\KraTreeResource;
use App\Repositories\KRARepository;
use App\Repositories\MosDataRepository;
use App\Http\Resources\KraResource;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth ;

/**
 * Class KRAController
 * @package App\Http\Controllers\API
 */

class KRAAPIController extends AppBaseController
{
    /** @var  KRARepository */
    private $kRARepository;
    private $mosDataRepository;

    public function __construct(KRARepository $kRARepo , MosDataRepository $mosDataRepo)
    {
        $this->kRARepository = $kRARepo;
        $this->mosDataRepository = $mosDataRepo;
    }

    /**
     * Display a listing of the KRA.
     * GET|HEAD /kRAS
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
            $request['dept_id'] = $user_data->department ; 
        }

        if($request->year ){
            $request['year'] = $request->year; 
        }


        $kRAS = $this->kRARepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($kRAS->toArray(), 'KRA retrieved successfully');
    }

    /**
     * COPY KRA KPI MOS DATA FROM PREVIOUS YEAR TO NEXT YEAR
     */
    public function copy_kra_kpi_mos(Request $request){
        $year = $request->fromYear; //'2021' ; 
        $to_year = $request->toYear; //'2022';

        try {

             //CHECK ALREADY COPY DATA
            if(KRA::where(['year'=>$to_year, 'dept_id'=>Auth::guard('user')->user()->department])->get()->count() > 0){
                return $this->sendResponse(0, 'Data already copyied');
            }else{
                $kras  = KRA::where(['year'=>$year, 'dept_id'=>Auth::guard('user')->user()->department])->get();

                //IF GET KRA FOR REQUESTED DEPARTMENT
                if($kras->count() > 0){
                    foreach ($kras as $key_kra => $kra) {
                        $kra->year =  $to_year ;
                        $kra->created_at =  date('Y-m-d');

                        $kra_new =  KRA::create($kra->toArray());

                        $kpis  = KPI::where('kra_id',$kra->id)->get();

                        foreach ($kpis as $key_kpi => $kpi) {
                            $kpi->kra_id =  $kra_new->id ; 
                            $kpi->created_at =  date('Y-m-d');
                            $kpi->year =  $to_year ;
                            $kpi_new  = KPI::create($kpi->toArray());

                            $moss = MOS::where('kpi_id',$kpi->id)->get();

                            foreach ($moss as $key => $mos) {
                                $mos->kra_id =  $kra_new->id ; 
                                $mos->kpi_id =  $kpi_new->id ; 
                                $mos->year =  $to_year ;
                                $mos->created_at =  date('Y-m-d');
                                $mos_new  = MOS::create($mos->toArray());

                                $target['mos_id'] = $mos_new->id;
                                $target['type'] ='target';
                                $target['year'] =$to_year ;
                                $target['dept_id'] =$mos_new->dept_id;
                                $target['created_at'] = date('Y-m-d');
                                
                                MosData::create($target);
                    
                                $module['mos_id'] = $mos_new->id;
                                $module['type'] ='module';
                                $module['year'] =$to_year ;
                                $module['dept_id'] = $mos_new->dept_id;
                                $module['created_at'] = date('Y-m-d');
                                MosData::create($module); 
                    
                                $achievement['mos_id'] = $mos_new->id;
                                $achievement['type'] ='achievement';
                                $achievement['year'] =$to_year ;
                                $achievement['dept_id'] = $mos_new->dept_id;
                                $achievement['created_at'] = date('Y-m-d');
                                MosData::create($achievement);
                            }
                        }                    
                    }
                    return $this->sendResponse(1, 'Successfully data copy');
                }else{
                    return $this->sendResponse(0, 'DATA NOT FOUND FOR COPY');
                }
            }
          
          } catch (\Exception $e) {
          
              return $e->getMessage();
          }

              
    }

    public function kra_kpi_mos_tree(Request $request){
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
            $request['dept_id'] = $user_data->department ; 
        }
        $kRAS = $this->kRARepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $result = KraTreeResource::collection($kRAS);
        return $this->sendResponse($result, 'KRA retrieved successfully');
    }
    public function kra_delete($id , Request $request){
        $mos = MOS::where('kra_id',$id)->get();
        foreach ($mos as $key => $value) { 
            $deletedRows = MosData::where('mos_id', $value->id)->delete();
        }
//         use App\Models\KRA;
// use App\Models\KPI;
        $deletedRows = MOS::where('kra_id', $id)->delete();
        $deletedRows = KPI::where('kra_id', $id)->delete();
        $deletedRows = KRA::where('id', $id)->delete();
        return $this->sendResponse($deletedRows, 'KRA deleted successfully');
    }
    public function kpi_delete($id , Request $request){
        $mos = MOS::where('kpi_id',$id)->get();
        foreach ($mos as $key => $value) { 
            $deletedRows = MosData::where('mos_id', $value->id)->delete();
        }
//         use App\Models\KRA;
// use App\Models\KPI;
        $deletedRows = MOS::where('kpi_id', $id)->delete();
        $deletedRows = KPI::where('id', $id)->delete();
       // $deletedRows = KRA::where('id', $id)->delete();
        return $this->sendResponse($deletedRows, 'KPI deleted successfully');
    }
    public function mos_delete($id , Request $request){
        //$mos = MOS::where('kra_id',$id)->get();
        $deletedRows = MosData::where('mos_id',$id)->delete(); 
        $deletedRows = MOS::where('id', $id)->delete();
        //$deletedRows = KPI::where('kra_id', $id)->delete();
       // $deletedRows = KRA::where('id', $id)->delete();
        return $this->sendResponse($deletedRows, 'MOD deleted successfully');
    }
    public function kra_details( $id ,Request $request)
    {
        $kRA = $this->kRARepository->find($id);
        
        $returnResult = new KraResource($kRA);
        return $this->sendResponse($returnResult, 'K P I S retrieved successfully');
    }
    public function kra_kpi_mos(Request $request)
    { 
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
            $request['dept_id'] = $user_data->department ; 
        }

        $kRAS = $this->kRARepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        $data_return  =   KraResource::collection($kRAS);
        return $this->sendResponse($data_return, 'K P I S retrieved successfully');
    }
    public function bpt_report(Request $request)
    { 
        $task =KRA::all();
        $data_return  =   KraResource::collection($task);
        return $this->sendResponse($data_return, 'K P I S retrieved successfully');
    }

    public function kar_kpi_mos_chart(Request $request){
        $user_data = Auth::guard('user')->user();
        $department = Department::find($user_data->department );
        $data = array(
            'value' => $department->name,
            'children' => array(
                'value' => 'KRA',
                'children' => array(
                    'value' => 'KPI',
                    'children' => array(
                        'value' => 'text',
                    )
                )
            )
        );
        return $this->sendResponse(  $data, 'KRA retrieved successfully');
    }

    /**
     * Store a newly created KRA in storage.
     * POST /kRAS
     *
     * @param CreateKRAAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateKRAAPIRequest $request)
    {
        $input = $request->all();

        $kRA = $this->kRARepository->create($input);

        return $this->sendResponse($kRA->toArray(), 'K R A saved successfully');
    }
    public function kra_kpi_setting(Request $request)
    {  

        // echo "<pre>"; print_r($request->sbu_id->id); die();
        $user_data = Auth::guard('user')->user();
        $department = Department::find($user_data->department );
        if($request->arrayData['name'] !=''){
            $kar = array(
                'kra_name' => $request->arrayData['name'] ,
                'kra_weight' => $request->arrayData['kra_weight'] ,
                'dept_id'  =>   $department->id , 
                'year'  =>  $request->year ,  
                'employee_sbu'  =>   isset($request->sbu_id['id'])?$request->sbu_id['id']:0,
                'employee_section'  =>   isset($request->section_id['id'])?$request->section_id['id']:0,
                'employee_sub_section'  =>   isset($request->subsection_id['id'])?$request->subsection_id['id']:0,
                'employee_unit'  =>   isset($request->unit_id['id'])?$request->unit_id['id']:0,
                'employee_sub_unit'  =>   isset($request->subunit_id['id'])?$request->subunit_id['id']:0,
                'dept_id'  =>   isset($request->department_id['id'])?$request->department_id['id']:0,
                'employee_work_location'  =>   isset($request->employee_work_location['id'])?$request->employee_work_location['id']:0,
                'employee_id_no'  =>   isset($request->employee_id['id'])?$request->employee_id['id']:0,
            );
             // echo "<pre>"; print_r($kar); die(); 
            $kRA = $this->kRARepository->create($kar);

            $kriArray  =  $request->arrayData['children'];
            foreach ($kriArray as $key => $value) { 
                if($kriArray[$key]['name'] !='')
                    $kar = array(
                        'kpi_name' => $kriArray[$key]['name'] ,
                        'kpi_weight' => $kriArray[$key]['kpi_weight'] ,
                        'dept_id'  =>   $department->id , 
                        'kra_id'   =>    $kRA->id , 
                        'year'  =>  $request->year ,
                        'created_at' => Now(),
                        'employee_sbu'  =>   isset($request->sbu_id['id'])?$request->sbu_id['id']:0,
                        'employee_section'  =>   isset($request->section_id['id'])?$request->section_id['id']:0,
                        'employee_sub_section'  =>   isset($request->subsection_id['id'])?$request->subsection_id['id']:0,
                        'employee_unit'  =>   isset($request->unit_id['id'])?$request->unit_id['id']:0,
                        'employee_sub_unit'  =>   isset($request->subunit_id['id'])?$request->subunit_id['id']:0,
                        'dept_id'  =>   isset($request->department_id['id'])?$request->department_id['id']:0,
                        'employee_work_location'  =>   isset($request->employee_work_location['id'])?$request->employee_work_location['id']:0,
                        'employee_id_no'  =>   isset($request->employee_id['id'])?$request->employee_id['id']:0,
                    ); 
                    $kpi_id = KPI::create($kar);
                    $mosArray  =  $kriArray[$key]['children'];
                    foreach ($mosArray as $key2 => $value) { 
                        if( $mosArray[$key2]['name'] !=''){
                            $mos = array(
                                'mos_name' => $mosArray[$key2]['name'] , 
                                'dept_id'  =>   $department->id , 
                                'kra_id'   =>    $kRA->id , 
                                'kpi_id'   =>    $kpi_id->id , 
                                'year'  =>  $request->year ,
                                'created_at' => Now(),
                                'employee_sbu'  =>   isset($request->sbu_id['id'])?$request->sbu_id['id']:0,
                                'employee_section'  =>   isset($request->section_id['id'])?$request->section_id['id']:0,
                                'employee_sub_section'  =>   isset($request->subsection_id['id'])?$request->subsection_id['id']:0,
                                'employee_unit'  =>   isset($request->unit_id['id'])?$request->unit_id['id']:0,
                                'employee_sub_unit'  =>   isset($request->subunit_id['id'])?$request->subunit_id['id']:0,
                                'dept_id'  =>   isset($request->department_id['id'])?$request->department_id['id']:0,
                                'employee_work_location'  =>   isset($request->employee_work_location['id'])?$request->employee_work_location['id']:0,
                                'employee_id_no'  =>   isset($request->employee_id['id'])?$request->employee_id['id']:0,
                            ); 
                            $mOS = MOS::create($mos); 

                            //target
                            $data['mos_id'] = $mOS->id;
                            $data['type'] = 'target';
                            $data['year'] =  $request->year ;
                            $data['dept_id'] =  $department->id ;
                            $this->mosDataRepository->create($data);

                            // module
                            $data2['mos_id'] = $mOS->id;
                            $data2['type'] = 'module';
                            $data2['year'] =   $request->year ;
                            $data2['dept_id'] =  $department->id ;
                            $this->mosDataRepository->create($data2);  

                            // achievement
                            $data3['mos_id'] = $mOS->id;
                            $data3['type'] = 'achievement';
                            $data3['year'] =   $request->year ;
                            $data3['dept_id'] =  $department->id ;
                            $this->mosDataRepository->create($data3);  
                        }
                    }
               }  
            }  
        return $this->sendResponse(  0  , 'K R A saved successfully');
    }

    /**
     * Display the specified KRA.
     * GET|HEAD /kRAS/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var KRA $kRA */
        $kRA = $this->kRARepository->find($id);

        if (empty($kRA)) {
            return $this->sendError('K R A not found');
        }

        return $this->sendResponse($kRA->toArray(), 'K R A retrieved successfully');
    }

    /**
     * Update the specified KRA in storage.
     * PUT/PATCH /kRAS/{id}
     *
     * @param int $id
     * @param UpdateKRAAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateKRAAPIRequest $request)
    {
        $input = $request->all();

        /** @var KRA $kRA */
        $kRA = $this->kRARepository->find($id);

        if (empty($kRA)) {
            return $this->sendError('K R A not found');
        }

        $kRA = $this->kRARepository->update($input, $id);

        return $this->sendResponse($kRA->toArray(), 'KRA updated successfully');
    }

    /**
     * Remove the specified KRA from storage.
     * DELETE /kRAS/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var KRA $kRA */
        $kRA = $this->kRARepository->find($id);

        if (empty($kRA)) {
            return $this->sendError('K R A not found');
        }

        $kRA->delete();

        return $this->sendSuccess('K R A deleted successfully');
    }
}
