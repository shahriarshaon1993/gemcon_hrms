<div class="col-md-12" style="padding: 0px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" >
                        <li class="nav-item">
                            <a class="nav-link active"  data-toggle="tab" href="#CurrentAssets" role="tab" aria-controls="home" aria-selected="true">Current Assets </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="my-profile-tab" data-toggle="tab" href="#AssetsLog" role="tab" aria-controls="my-profile" aria-selected="false">Assets Log</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="CurrentAssets" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab1">
                        <div class="col-md-12 backToFolderList" style="padding:0px;">
                            <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;"> 
                                <i class="fa fa-bars"></i>
                                Current Assets List
                            </h5>
                            <?php 
                            $url = 'http://172.16.1.52:8090/api/employee_asset';
                            // $url = '';
                            $file_headers = @get_headers($url);
                            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                $exists = false;
                            }
                            else {
                                 $obj = json_decode(file_get_contents($url), true);
                            }
                           
                            if (!empty($obj)) {
                              $assets_assign_ids = collect($obj['fitAssetsUsedinfo'])->where('asset_assign_parson_id',Auth::guard('user')->user()->employee_card_no)->pluck('id')->toArray();
                              $asset_ids = collect($obj['fitAssetsUsedinfoDetails'])->whereIn('asset_assign_info_id',$assets_assign_ids)->where('checkout_status',1)->toArray();
                              // echo "<pre>";
                              // print_r($asset_ids);
                              // return false;
                              $assets_detail_array=[];
                              foreach ($asset_ids as $key => $value) {
                                $fixtAssets=collect($obj['fixtAssets'])->where('id',$value['assets_id'])->first();
                                $fitAssetsUsedinfo=collect($obj['fitAssetsUsedinfo'])->where('id',$value['asset_assign_info_id'])->first();
                                 $assets_detail_array[]= array(
                                      'assets_id' => $value['assets_master'], 
                                      'asset_checkout'=> $value['asset_checkout'], 
                                      'assets_master_description'=> $fixtAssets['assets_master_description'], 
                                      'brand_or_model'=> $fixtAssets['brand_or_model'], 
                                      'condidtion'=> $fixtAssets['condidtion'], 
                                      // 'assing_date' => $fitAssetsUsedinfo['assing_date'],
                                       'assign_create_at' => date("d M, Y, g:i a", strtotime($fitAssetsUsedinfo['created_at'])),
                                    );
                              }
                              $employee_assets = $assets_detail_array;
                            }
                            ?>  

                        </div>
                        <table id="assetsTable" class="table table-striped table-bordered assetsListTable" cellspacing="0" style="font-size:12px; border: none;">
                            <thead>
                                <tr class="text-center">
                                    <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Barcode </th>
                                    <th scope='col' style='border:1px solid #ddd !important; width: 30%;'>Description </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Brand </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>  Condition </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Assigning Date </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (!empty($employee_assets)) {
                                
                                $i=0;
                                foreach ($employee_assets as $key => $value): 
                                    ?>
                                    <?php 
                                    if($value['condidtion']==1){
                                        $condition="Good & In use";
                                     }elseif ($value['condidtion']==2) {
                                        $condition="Good But Idle";
                                     }elseif ($value['condidtion']==3) {
                                        $condition="Stand By";
                                     }elseif ($value['condidtion']==4) {
                                        $condition="Damage but Serviceable";
                                     }elseif ($value['condidtion']==5) {
                                        $condition="Obsolete/ Serviceable";
                                     }elseif ($value['condidtion']==6) {
                                        $condition="Obsolete/ Impaired/ Damage";
                                     }elseif ($value['condidtion']==7) {
                                        $condition="Out of Service";
                                     }elseif ($value['condidtion']==8) {
                                        $condition="Service Out";
                                     }elseif ($value['condidtion']==9) {
                                        $condition="New";
                                     }else{
                                        $condition="-";
                                     }

                                     if($value['asset_checkout']==1){
                                         $asset_checkout="Check In";
                                      }elseif ($value['asset_checkout']==0) {
                                         $asset_checkout="Check Out";
                                      }else{
                                         $asset_checkout = '-';
                                      }
                                    $i++;
                                     ?>
                               <tr role="row" class="odd">
                                  <td class="text-center sorting_1">{{$i}}</td>
                                  <td class="text-center">{{$value['assets_id']}}</td>
                                  <td class="text-left">{{$value['assets_master_description']}}</td>
                                  <td class="text-left">{{$value['brand_or_model']}}</td>
                                  <td class="text-left">{{$condition}}</td>
                                  <td class="text-center">{{$value['assign_create_at']}}</td>
                                  <td class="text-center">{{$asset_checkout}}</td>
                                  <!-- $assing_date -->
                               </tr>
                               <?php endforeach ?>
                           <?php }else{'No Data Found!';} ?>
                            </tbody>

                        </table>    
                    </div>

                    <div class="tab-pane fade" id="AssetsLog" style="padding:0px;" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12 backToFolderList" style="padding:0px;">
                            <h5 class='col-md-6 text-left float-left' style="margin-top:10px; padding:0px; cursor: pointer;"> 
                                <i class="fa fa-bars"></i>
                                Assets Log
                            </h5>
                            <?php 
                            // $url = 'http://172.16.1.52:8090/api/employee_asset';
                            // $obj = json_decode(file_get_contents($url), true);
                            if (!empty($obj)) {
                              $assets_assign_ids = collect($obj['fitAssetsUsedinfo'])->where('asset_assign_parson_id',Auth::guard('user')->user()->employee_card_no)->pluck('id')->toArray();
                              $asset_ids = collect($obj['fitAssetsUsedinfoDetails'])->whereIn('asset_assign_info_id',$assets_assign_ids)->toArray();
                              // echo "<pre>";
                              // print_r($asset_ids);
                              // return false;
                              $assets_detail_array=[];
                              foreach ($asset_ids as $key => $value) {
                                $fixtAssets=collect($obj['fixtAssets'])->where('id',$value['assets_id'])->first();
                                $fitAssetsUsedinfo=collect($obj['fitAssetsUsedinfo'])->where('id',$value['asset_assign_info_id'])->first();
                                 $assets_detail_array[]= array(
                                      'assets_id' => $value['assets_master'], 
                                      'asset_checkout'=> $value['asset_checkout'], 
                                      'assets_master_description'=> $fixtAssets['assets_master_description'], 
                                      'brand_or_model'=> $fixtAssets['brand_or_model'], 
                                      'condidtion'=> $fixtAssets['condidtion'], 
                                      // 'assing_date' => $fitAssetsUsedinfo['assing_date'],
                                       'assign_create_at' => date("d M, Y, g:i a", strtotime($fitAssetsUsedinfo['created_at'])),
                                    );
                              }
                              $employee_assets = $assets_detail_array;
                            }
                            ?>  

                        </div>
                        <table id="assetsTable" class="table table-striped table-bordered assetsListTable" cellspacing="0" style="font-size:12px; border: none;">
                            <thead>
                                <tr class="text-center">
                                    <th scope='col' style='border:1px solid #ddd !important;'>#</th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Barcode </th>
                                    <th scope='col' style='border:1px solid #ddd !important; width: 30%;'>Description </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>Brand </th>
                                    <th scope='col' style='border:1px solid #ddd !important;'>  Condition </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Assigning Date </th>
                                    <th scope='col' style='border:1px solid #ddd !important; '>  Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (!empty($employee_assets)) {
                                
                                $i=0;
                                foreach ($employee_assets as $key => $value): 
                                    ?>
                                    <?php 
                                    if($value['condidtion']==1){
                                        $condition="Good & In use";
                                     }elseif ($value['condidtion']==2) {
                                        $condition="Good But Idle";
                                     }elseif ($value['condidtion']==3) {
                                        $condition="Stand By";
                                     }elseif ($value['condidtion']==4) {
                                        $condition="Damage but Serviceable";
                                     }elseif ($value['condidtion']==5) {
                                        $condition="Obsolete/ Serviceable";
                                     }elseif ($value['condidtion']==6) {
                                        $condition="Obsolete/ Impaired/ Damage";
                                     }elseif ($value['condidtion']==7) {
                                        $condition="Out of Service";
                                     }elseif ($value['condidtion']==8) {
                                        $condition="Service Out";
                                     }elseif ($value['condidtion']==9) {
                                        $condition="New";
                                     }else{
                                        $condition="-";
                                     }

                                     if($value['asset_checkout']==1){
                                         $asset_checkout="Check In";
                                      }elseif ($value['asset_checkout']==0) {
                                         $asset_checkout="Check Out";
                                      }else{
                                         $asset_checkout = '-';
                                      }
                                    $i++;
                                     ?>
                               <tr role="row" class="odd">
                                  <td class="text-center sorting_1">{{$i}}</td>
                                  <td class="text-center">{{$value['assets_id']}}</td>
                                  <td class="text-left">{{$value['assets_master_description']}}</td>
                                  <td class="text-left">{{$value['brand_or_model']}}</td>
                                  <td class="text-left">{{$condition}}</td>
                                  <td class="text-center">{{$value['assign_create_at']}}</td>
                                  <td class="text-center">{{$asset_checkout}}</td>
                               </tr>
                               <?php endforeach ?>
                           <?php }else{'No Data Found!';} ?>
                            </tbody>

                        </table>    
                    </div> 
                 </div>
                