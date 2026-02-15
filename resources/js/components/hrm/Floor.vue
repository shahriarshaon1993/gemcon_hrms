<template>
    <div>
        <div v-if="page_loading" class="widget box">
            <div class="widget-header">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-12" style="padding: 5px 10px;">
                                                <h3 class="card-title d-none d-md-block">Floor Lists</h3>
                                                <span v-if="lists.add" class="float-sm-right" style="float: right;">
                                                    <div @click="getModalData($event,{dataUrl:'create/floors'})" class="btn-group">
                                                        <span class="btn btn-sm btn-info"><i class="icon-plus"></i>Add New</span>
                                                    </div>
                                                    <a class="btn btn-default" href="#"><i class="fa fa-arrow-left"></i>Back</a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-4">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info elevation-1"><i
                                                        class="fa fa-paper-plane"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Total</span>
                                                        <span class="info-box-number">
                                                            {{ lists.total_data }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-4">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-warning elevation-1"><i
                                                        class="fas fa-clock"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Inactive</span>
                                                        <span class="info-box-number">
                                                            {{ lists.inactive_data }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-4">
                                                <div class="info-box mb-3">
                                                    <span class="info-box-icon bg-success elevation-1">
                                                        <i class="fa fa-check-circle"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Active </span>
                                                        <span class="info-box-number">{{ lists.active_data }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix hidden-md-up"></div>
                                        </div>
                                    </div>
                                    <div class="card-body col-md-12">
                                        <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                                            <div id="DataTables_Table_0_length" class="">
                                                Show
                                                <label>
                                                    <select class="form-control pagination-number" @change="onChange($event)" v-model="paginate_num" name="pageSize">
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                        <option value="25">25</option>
                                                        <option value="30">30</option>
                                                        <option value="35">35</option>
                                                        <option value="40">40</option>
                                                        <option value="45">45</option>
                                                        <option value="50">50</option>
                                                    </select>
                                                </label>
                                                entries
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-6 float-left" style="padding:0px;">
                                            <div class="dataTables_filter" id="DataTables_Table_0_filter">
                                                <label class="float-right">
                                                    <div class="input-group"><span class="input-group-addon"><i
                                                        class="icon-search"></i></span>
                                                        <input v-on:keyup="getResults" v-model="search_input.search_key"
                                                               type="text" aria-controls="DataTables_Table_0"
                                                               class="form-control search-keyword" id="search"
                                                               placeholder="Search...">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <span></span>

                                        <table id="employeeTable"
                                               class="table table-bordered table-striped employeeTable">
                                            <thead>
                                            <tr>
                                                <th class="text-center">SL</th>

                                                <th class="text-center" v-bind:class="getSortingClass('floor_code')" @click="sortingChanged('floor_code')">
                                                    Location Code
                                                    <i class="fas fa-sort"></i>
                                                </th>

                                                <th class="text-center" v-bind:class="getSortingClass('work_location_name')" @click="sortingChanged('work_location_name')">
                                                    Location
                                                    <i class="fas fa-sort"></i>
                                                </th>

                                                <th class="text-left" v-bind:class="getSortingClass('floor_number')" @click="sortingChanged('floor_number')">
                                                    Floor Number
                                                    <i class="fas fa-sort"></i>
                                                </th>

                                                <th class="text-left" v-bind:class="getSortingClass('floor_status')" @click="sortingChanged('floor_status')">
                                                    Status
                                                    <i class="fas fa-sort"></i>
                                                </th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody v-if="Object.keys(paginate_data.data).length > 0">
                                                <tr v-for="(form_data, index) in paginate_data.data" :key="form_data.id">
                                                    <td class="text-center">{{ index + 1 }}</td>
                                                    <td class="text-center">{{ form_data.floor_code }}</td>
                                                    <td class="text-center">{{form_data.work_location.work_location_name}}</td>
                                                    <td>{{ form_data.floor_number }}</td>

                                                    <td class="text-center" v-if="form_data.floor_status == 1">
                                                        {{ 'Active' }}
                                                    </td>
                                                    <td class="text-center" v-else>{{ 'Inactive' }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            @click="getModalData($event,{dataUrl:'edit/floors/'+form_data.id})"
                                                            class="btn btn-info btn-xs" title="Edit"><i
                                                            class="fa fa-edit"> </i> Edit
                                                        </button>

                                                        <button @click="deleteItem({delUrl:'delete/floors/'+form_data.id})"
                                                            title="Delete" class="btn btn-danger btn-xs"><i
                                                            class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="5" align="center">No data in database</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="dataTables_footer clearfix col-md-12 col-12" style="padding: 10px 0px;">
                                                <div class="col-md-6 col-6 float-left">
                                                    <div class="dataTables_info" id="DataTables_Table_0_info">Showing
                                                        {{ paginate_data.current_page }} of
                                                        {{ paginate_data.last_page }} pages
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-6 float-right">
                                                    <div class="dataTables_paginate paging_bootstrap float-right">
                                                        <pagination :data="paginate_data"
                                                                    @pagination-change-page="getResults"></pagination>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <modal class="" name="myModal" height="auto" :clickToClose="false">
                    <div v-if="modal_loading">
                        <div class="widget-header modal-header">
                            <h4><i class="fa fa-bars"></i> Add/Edit Floor</h4>
                            <button type="button" @click="hideModal" class="close close-modify" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modify-wraper modal-body">
                            <form @submit.prevent="add({add:'add/floors'}, resetModal)"
                                  class="form-horizontal  row-border" id="validate-1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Floor number</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i
                                                    class="glyphicon glyphicon-home"></i></span>
                                                    <input id="floor_number" v-model="form_data.floor_number"
                                                           name="floor_number" placeholder="" class="form-control"
                                                           required="true" type="text"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Work location</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i
                                                        class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.work_location_id" required="true">
                                                        <option disabled>--Select--</option>

                                                        <option v-for="(location, i) in form_data.locations" :key="i" :value="location.id">
                                                            {{ location.work_location_name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Status</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="max-width: 100%;"><i
                                                        class="glyphicon glyphicon-list"></i></span>
                                                    <select class="form-control" v-model="form_data.floor_status"
                                                            required="true">
                                                        <option disabled>--Select--</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Priority</label>
                                            <div class="col-md-12 inputGroupContainer">
                                                <div class="input-group"><span class="input-group-addon"><i
                                                    class="glyphicon glyphicon-home"></i></span>
                                                    <input id="sbu_name" v-model="form_data.priority" name="sbu_name"
                                                           placeholder="" class="form-control" type="number"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions col-md-12">
                                    <input type="submit" tabindex="4" value="Save" class="btn btn-sm btn-info float-right col-md-2 col-2">
                                    <button type="button" @click="hideModal" class="btn btn-sm btn-default float-right col-md-2 offset-md-6 col-2" style="margin-right: 10px;">
                                        Close
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div v-if="!modal_loading">
                        <pageLoading></pageLoading>
                    </div>
                </modal>
            </div>
        </div>
        <div v-if="!page_loading">
            <pageLoading></pageLoading>
        </div>
    </div>
</template>
<script>
import Loading from '../Loading.vue';

export default {
    created() {
        this.getResults(1);
    },
    components: {
        pageLoading: Loading
    }
}
</script>
