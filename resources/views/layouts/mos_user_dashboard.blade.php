<div class="">
    <div class="row d-flex justify-content-center" style="margin-left: -11px; margin-right: -11px;">
        <div class="col-6 col-sm-4 col-md-2">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clock-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Target</span>
                    <span class="info-box-number "> {{$sumTotalTarget}}</span>
                </div>
                <div role="separator" class="dropdown-divider"></div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-clock-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Due Target</span>
                    <span class="info-box-number ">
                        {{$sumTotalDue}}
                    </span>
                </div>
                <div role="separator" class="dropdown-divider"></div>
            </div>
        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-6 col-sm-4 col-md-2">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-clock-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"> Achievement</span>
                    <span class="info-box-number ">
                        {{$sumTotalAchievement}}
                    </span>
                </div>
                <div role="separator" class="dropdown-divider"></div>
            </div>
        </div>


    </div>
    <div class="d-flex justify-content-center">
        <a class="nav-link" id="kpi-performance-user" data-toggle="tab" href="#kpi-performance" role="tab" aria-controls="kpi-performance" aria-selected="false">Show Your KPI List >></a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#kpi-performance-user").click(function() {
            // alert("You clicked me!");
            $("#kpi-performance").html('<div class="w-100 d-flex justify-content-center align-items-center"><div class="spinner"></div></div>');
            $("#kpi-performance").load("/kra_kpi_mos_list_user");
        });
    });