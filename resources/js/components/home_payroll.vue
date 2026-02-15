<template>
  <div class="row">
				<div class="col-md-12">
				  <div class="card-header">
            <div class="row">
              <div
                class="col-12 col-sm-6 col-md-12"
                style="padding: 5px 10px"
              >
                <h3 class="card-title d-none d-md-block">
                  Payroll Management
                </h3>
                <span class="float-sm-right" style="float: right">
                  <div
                    v-if="lists.add == 'add'"
                    @click="
                      getModalData(
                        $event,
                        { dataUrl: 'create/manualattendance' },
                        resetModal,
                        (add_new_type = 2)
                      )
                    "
                    class="btn-group"
                  >
                    <span class="btn btn-sm btn-info"
                      ><i class="icon-plus"></i>Add New</span
                    >
                  </div>
                </span>
              </div>
            </div>
            <div class="row">
            <div class="col-12 col-sm-12 col-md-3 manual-attendance-box">
                <a @click="getDataActiveIctive('team')"  style="color: #000">
                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">My Team</span>
                      <span class="info-box-number">0</span>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-12 col-sm-12 col-md-3 manual-attendance-box">
              <a @click="getDataActiveIctive('Requested')"  style="color: #000">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"
                    ><i class="fa fa-paper-plane"></i
                  ></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Requests</span>
                    <span class="info-box-number">0
                    </span>
                  </div>
                </div>
                </a>
              </div>
              <div class="col-12 col-sm-12 col-md-3 manual-attendance-box">
              <a @click="getDataActiveIctive('Pending')"  style="color: #000">
                <div class="info-box">
                  <span class="info-box-icon bg-warning elevation-1"
                    ><i class="fas fa-clock"></i
                  ></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">0
                    </span>
                  </div>
                </div>
                </a>
              </div>
              <div class="col-12 col-sm-12 col-md-3 manual-attendance-box">
                <a @click="getDataActiveIctive('Accepted')"  style="color: #000">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"
                    ><i class="fa fa-check-circle"></i
                  ></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Approved</span>
                    <span class="info-box-number">0</span>
                  </div>
                </div>
                </a>
              </div>
              <div class="clearfix hidden-md-up"></div>

              <div class="col-12 col-sm-12 col-md-3 manual-attendance-box">
              <a @click="getDataActiveIctive('Rejected')"  style="color: #000">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1"
                    ><i class="fa fa-ban"></i
                  ></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Rejected</span>
                    <span class="info-box-number">0</span>
                  </div>
                </div>
                </a>
              </div>
            </div>
          </div>
				</div>
			</div>
</template>