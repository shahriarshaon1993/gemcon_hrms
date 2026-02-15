<template>
    <div>
        <link
            href="http://127.0.0.1:8000/melon/assets/css/table-sort.css"
            rel="stylesheet"
            type="text/css"
        />

        <div v-if="page_loading" class="widget box">
            <div class="container-fluid">
                <div class="card px-3 py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="">
                            Circular Description Lists
                        </h5>
                        <div>
                            <button
                                v-if="lists.add == 'add'"
                                type="button"
                                class="btn btn-sm btn-info"
                                @click="getModalData($event, { dataUrl: 'circular-descriptions/create' }, resetModal)"
                            >
                                <i class="icon-plus"></i>
                                Add new
                            </button>

                            <button type="button" class="btn btn-sm btn-default" @click="$router.go(-1)">
                                <i class="fa fa-arrow-left"></i>
                                Back
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fa fa-paper-plane"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number">20</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fa fa-paper-plane"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number">5</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fa fa-paper-plane"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total</span>
                                    <span class="info-box-number">4</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="DataTables_Table_0_length d-flex align-items-center">
                                Show
                                <select class="form-control pagination-number mx-2" @change="onChange($event)" v-model="paginate_num" name="pageSize">
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
                                entries
                            </div>

                            <div>
                                <input
                                    v-on:keyup="getResults"
                                    v-model="search_input.search_key"
                                    type="text"
                                    aria-controls="DataTables_Table_0"
                                    class="form-control search-keyword"
                                    id="search"
                                    placeholder="Search..."
                                />
                            </div>
                        </div>
                    </div>

                    <table id="employeeTable" class="table table-bordered table-striped employeeTable">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('designation_id')"
                                    @click="sortingChanged('designation_id')"
                                >
                                    Designation
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('job_description')"
                                    @click="sortingChanged('job_description')"
                                >
                                    Job Des.
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('job_responsibility')"
                                    @click="sortingChanged('job_responsibility')"
                                >
                                    Job Res.
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('applied_requirements')"
                                    @click="sortingChanged('applied_requirements')"
                                >
                                    Applied Req.
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('job_requirements')"
                                    @click="sortingChanged('job_requirements')"
                                >
                                    Job Req.
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th
                                    class="text-center"
                                    v-bind:class="getSortingClass('other_benefits')"
                                    @click="sortingChanged('other_benefits')"
                                >
                                    Other Benefits
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="Object.keys(paginate_data.data).length > 0">
                            <tr v-for="(form_data, index) in paginate_data.data" v-bind:key="form_data.id" i="index">
                                <td class="text-center">
                                    {{ order_no + index + 1 }}
                                </td>
                                <td>{{ form_data.designation.designation_name }}</td>
                                <td>{{ stripHtml(form_data.job_description, 5) }}</td>
                                <td>{{ stripHtml(form_data.job_responsibility, 5) }}</td>
                                <td>{{ stripHtml(form_data.applied_requirements, 5) }}</td>
                                <td>{{ stripHtml(form_data.job_requirements, 5) }}</td>
                                <td>{{ stripHtml(form_data.other_benefits, 5) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-info">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button
                                        v-if="lists.delete=='delete'"
                                        @click="deleteItem({delUrl:'circular-descriptions/delete/'+form_data.id})"
                                        class="btn btn-xs btn-danger"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                        <tbody v-else>
                            <tr>
                                <td colspan="8" align="center">
                                    No data in database
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            Showing {{ paginate_data.current_page }} of
                            {{ paginate_data.last_page }} pages
                        </div>
                        <pagination
                            :data="paginate_data"
                            @pagination-change-page="getResults"
                        ></pagination>
                    </div>
                </div>
            </div>

        </div>

        <div v-if="!page_loading">
            <pageLoading></pageLoading>
        </div>

        <!-- Modal -->
        <modal ref="modal" class="employee-modal" name="myModal" height="auto" :clickToClose="false">
            <div v-if="modal_loading">
                <div class="widget-header modal-header">
                    <h4>
                        <i class="fa fa-bars"></i>
                        Add circular description
                    </h4>
                    <button
                        type="button"
                        @click="hideModal"
                        class="close close-modify"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modify-wraper modal-body px-4">
                    <form @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Select Designation</label>
                                <vue-select
                                    v-model="form.designation_id"
                                    :options="form_data.designations"
                                    placeholder="Select one"
                                    label="text"
                                    track-by="text"
                                />
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label>Job Description<sup style="color:red; top: -2px;">*</sup></label>
                                <vue-editor v-model="form.job_description" class="mb-3" style="width: 100%;"></vue-editor>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label>Job Responsibility<sup style="color:red; top: -2px;">*</sup></label>
                                <vue-editor v-model="form.job_responsibility" class="mb-3" style="width: 100%;"></vue-editor>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label>Applied Requirements<sup style="color:red; top: -2px;">*</sup></label>]
                                <vue-editor v-model="form.applied_requirements" class="mb-3" style="width: 100%;"></vue-editor>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label>Job Requirements<sup style="color:red; top: -2px;">*</sup></label>
                                <vue-editor v-model="form.job_requirements" class="mb-3" style="width: 100%;"></vue-editor>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label>Other Benefits<sup style="color:red; top: -2px;">*</sup></label>
                                <vue-editor v-model="form.other_benefits" class="mb-3" style="width: 100%;"></vue-editor>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <input type="submit" value="Save" class="btn btn-sm btn-info mr-1">
                            <button type="button" @click="hideModal" class="btn btn-sm btn-default">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            <div v-if="!modal_loading">
                <pageLoading></pageLoading>
            </div>
        </modal>
    </div>
</template>

<script>
import Loading from '../Loading.vue';
import { VueEditor } from "vue2-editor";

export default {
    components: {
        VueEditor,
        pageLoading: Loading,
    },
    data() {
        return {
            editorConfig: {},
            designations: [],
            form: {
                designation_id: '',
                job_description: '',
                job_responsibility: '',
                applied_requirements: '',
                job_requirements: '',
                other_benefits: '',
            }
        };
    },
    created() {
        this.getResults(1);
    },
    methods: {
        stripHtml(html, limit = 100) {
            const div = document.createElement('div');
            div.innerHTML = html;
            const text = div.textContent || div.innerText || '';

            const words = text.trim().split(/\s+/);

            if (words.length <= limit) {
            return text;
            }

            const limitedText = words.slice(0, limit).join(' ');
            return `${limitedText} ...`;
        },
        formReset() {
            this.form = {
                designation_id: '',
                job_description: '',
                job_responsibility: '',
                applied_requirements: '',
                job_requirements: '',
                other_benefits: '',
            }
        },
        async onSubmit() {
            await axios.post(URL.baseUrl('circular-descriptions/store'), this.form)
                .then(res => {
                    this.formReset();
                    this.hideModal();
                    this.showToster(res.data);
                    this.getResults(1);
                })
        }
    },
};
</script>
