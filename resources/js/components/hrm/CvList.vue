<template>
    <div>
        <div v-if="!isPageLoading" class="widget box">
            <div class="container-fluid">
                <div class="card px-3 py-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="">
                            Circular Title
                        </h5>
                        <div>
                            <router-link to="/interview-board-call" class="btn btn-sm btn-success">
                                <i class="fa fa-clipboard"> </i>
                                Interview Board Call
                            </router-link>
                            <a class="btn btn-sm btn-default" @click="$router.go(-1)">
                                <i class="fa fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" class="form-control" v-model="gander">
                                    <option value="">Select</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">Age</label>
                                <div class="d-flex">
                                    <input type="number" v-model="minAge" min="0" class="form-control mr-1">
                                    <input type="number" v-model="maxAge" min="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label for="designations">Designation {{ designationId }}</label>
                                <vue-select
                                    v-model="designationId"
                                    :options="designations"
                                    label="id" track-by="id"
                                ></vue-select>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-2">
                            <input type="text" class="form-control">
                        </div> -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">Experience</label>
                                <div class="d-flex">
                                    <input type="number" v-model="minExperience" min="0" class="form-control mr-1">
                                    <input type="number" v-model="maxExperience" min="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">Salary Range</label>
                                <div class="d-flex">
                                    <input type="number" v-model="minSalary" min="0" class="form-control mr-1">
                                    <input type="number" v-model="maxSalary" min="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" @click="handleFilter" style="margin-top: 27px;">
                                Go
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3" @click="filterByStatus(1)">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fa fa-paper-plane"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">No of applicants</span>
                                    <span class="info-box-number">
                                        {{ counts.applied }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" @click="filterByStatus(2)">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fas fa-clock"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Shortlisted</span>
                                    <span class="info-box-number">
                                        {{ counts.shortlisted }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" @click="filterByStatus(3)">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fa fa-check-circle"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Selected</span>
                                    <span class="info-box-number">
                                        {{ counts.selected }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3" @click="filterByStatus(4)">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="fa fa-ban"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Rejected</span>
                                    <span class="info-box-number">
                                        {{ counts.rejected }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="DataTables_Table_0_length d-flex align-items-center">
                                Show
                                <select class="form-control pagination-number mx-2" @change="handlePaginatePerPage($event)">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20" selected>20</option>
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
                                    v-on:keyup="handleSearch($event)"
                                    type="text"
                                    class="form-control search-keyword"
                                    id="search"
                                    placeholder="Search..."
                                />
                            </div>
                        </div>

                        <template v-if="candidates.data.length > 0">
                            <div class="card mt-3" v-for="circular in candidates.data" :key="circular.id">
                                <div class="row p-3">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div v-if="circular.jac_image">
                                                    <img
                                                        :src="circular.jac_image"
                                                        :alt="circular.jac_candidate_name"
                                                        class="img-fluid"
                                                        style="height: 60px; width: 60px; border-radius: 10px;"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="mt-1">
                                                    <h5>
                                                        {{ circular.jac_candidate_name }}
                                                        <span style="font-size: 14px; color: dodgerblue;">
                                                            [Age: {{ circular.jac_age }}]
                                                        </span>
                                                    </h5>
                                                    <div style="font-size: 13px;">
                                                        <p class="mb-0">
                                                            <i class="fa fa-map-marker"></i>
                                                            {{ circular.jac_candidate_address }}
                                                        </p>
                                                        <p class="mb-0">
                                                            <i class="fa fa-phone"></i>
                                                            {{ circular.jac_contact_no }}
                                                        </p>
                                                        <p class="mb-0">
                                                            <i class="fa fa-book"></i>
                                                            <span v-if="circular.university">
                                                                {{ circular.university.university_name }}
                                                            </span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <i class="fa fa-book"></i>
                                                            {{ circular.jac_highest_education }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mt-1 d-flex">
                                                    <div style="font-size: 14px;">
                                                        <p class="mb-0">{{ circular.jac_last_employment }}</p>
                                                        <p class="mb-0">{{ circular.jac_last_designation }}</p>
                                                        <a class="btn btn-sm btn-info mt-3" target="_blank" :href="circular.jac_cv">
                                                            <i class="fa fa-download text-white"></i>
                                                            <span class="text-white">
                                                                Download CV
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <div class="ml-5" style="font-size: 14px;">
                                                        <p class="mb-0">{{ circular.jac_last_experience }} years</p>
                                                        <p class="mb-0">BDT {{ circular.jac_expected_salary }}/=</p>
                                                        <div style="font-size: 16px;">
                                                            <span v-if="circular.jac_status == 1" class="badge badge-primary">
                                                                Applied
                                                            </span>
                                                            <span v-if="circular.jac_status == 2" class="badge badge-primary">
                                                                Shortlisted
                                                            </span>
                                                            <span v-if="circular.jac_status == 3" class="badge badge-primary">
                                                                Selected
                                                            </span>
                                                            <span v-if="circular.jac_status == 4" class="badge badge-primary">
                                                                Rejected
                                                            </span>
                                                            <span v-if="circular.jac_status == 5" class="badge badge-warning">
                                                                Unlisted
                                                            </span>
                                                        </div>
                                                        <p v-if="circular.jac_email_send_status == 1" class="mb-0">
                                                            Email sent!
                                                        </p>
                                                        <p v-if="circular.jac_email_send_status == 2" class="mb-0">
                                                            Email not sent!
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 120px;">


                                                    <template v-if="circular.jac_status == 2 && circular.jac_email_send_status == 2">
                                                        <button
                                                            type="button"
                                                            @click="handleSendMail(circular.id)"
                                                            class="btn btn-sm btn-success"
                                                            style="margin: 2px;"
                                                            :disabled="isSendMail"
                                                        >
                                                            <span v-if="isSendMail" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            <i v-else class="fa fa-envelope"></i>

                                                            {{ isSendMail ? 'Sending...': 'Send mail' }}
                                                        </button>
                                                    </template>

                                                    <template v-if="circular.jac_status == 2">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-info"
                                                            style="margin: 2px;"
                                                            @click="confirmSelectModal(circular.id)"
                                                        >
                                                            <i class="fa fa-check"></i>
                                                            Select
                                                        </button>
                                                    </template>

                                                    <template v-if="circular.jac_status == 2">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-primary"
                                                            style="margin: 2px;"
                                                            @click="openMarkingModal(circular.id)"
                                                        >
                                                            <i class="fa fa-plus"></i>
                                                            Marking
                                                        </button>
                                                    </template>

                                                    <template
                                                        v-if="circular.jac_status == 1 ||
                                                        circular.jac_status == 5 ||
                                                        circular.jac_status == 4"
                                                    >
                                                        <button
                                                            type="button"
                                                            @click="handleShortList(circular.id)"
                                                            class="btn btn-sm btn-info"
                                                            style="margin: 2px;"
                                                        >
                                                            <i class="fa fa-check"></i>
                                                            Shortlist
                                                        </button>
                                                    </template>

                                                    <template v-if="circular.jac_status == 3">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-primary"
                                                            style="margin: 2px;"
                                                        >
                                                            <i class="fa fa-check"></i>
                                                            Join
                                                        </button>
                                                    </template>

                                                    <template v-if="circular.jac_status == 2">
                                                        <button
                                                            type="button"
                                                            @click="handleUnlisted(circular.id)"
                                                            class="btn btn-sm btn-warning"
                                                            style="margin: 2px;"
                                                            :disabled="isUnlisted"
                                                        >
                                                            <span v-if="isUnlisted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            <i v-else class="fa fa-times"></i>

                                                            {{ isUnlisted ? 'Unlisting...': 'Unlist' }}
                                                        </button>
                                                    </template>

                                                    <template v-if="circular.jac_status != 4">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-danger"
                                                            style="margin: 2px;"
                                                            @click="confirmRejectModal(circular.id)"
                                                        >
                                                            <i class="fa fa-times"></i>
                                                            Reject
                                                        </button>
                                                    </template>

                                                    <!-- <template v-if="circular.jac_status == 4">
                                                        <p class="badge badge-warning px-3 py-3 text-white" style="font-size: 15px;">
                                                            Application Rejected
                                                        </p>
                                                    </template> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    Showing {{ candidates.current_page }} of
                                    {{ candidates.last_page }} pages
                                </div>
                                <pagination
                                    :data="candidates"
                                    @pagination-change-page="handlePaginatePage"
                                ></pagination>
                            </div>
                        </template>

                        <template v-else>
                            <div class="mt-3 text-center">
                                <p>No data found</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <PageLoading />
        </div>

        <!-- Short List Modals -->
        <div class="modal fade" id="confirmShortListModal" tabindex="-1" aria-labelledby="shortListModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 360px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shortListModalLabel">
                            <i class="fa fa-bars"></i>
                            Shortlist Confirmation
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="modal-title">
                            Are you sure want to short list!
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button
                                type="button"
                                class="btn btn-sm btn-success"
                                @click="handleCandidateShortWithMail"
                                :disabled="isShortListedMail"
                            >
                                <span v-if="isShortListedMail" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ isShortListedMail ? 'Mail Sending...': 'Short list with mail' }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-info"
                                @click="handleCandidateShort"
                                :disabled="isShortListed"
                            >
                                <span v-if="isShortListed" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ isShortListed ? 'Short Listing...': 'Only Short List' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Reject Modal -->
        <div class="modal fade" id="confirmRejectModal" tabindex="-1" aria-labelledby="confirmRejectModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 360px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRejectModalLabel">
                            <i class="fa fa-bars"></i>
                            Reject Confirmation
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="modal-title">
                            Are you sure want to reject this person?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button
                                type="button"
                                class="btn btn-sm btn-info"
                                @click="handleRejectPerson"
                                :disabled="isRejected"
                            >
                                <span v-if="isRejected" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ isRejected ? 'Confirming...': 'Confirm' }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                data-dismiss="modal"
                            >
                                Cancel
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Select Modal -->
        <div class="modal fade" id="confirmSelectModal" tabindex="-1" aria-labelledby="confirmRejectModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 360px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRejectModalLabel">
                            <i class="fa fa-bars"></i>
                            Selection Confirmation
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="modal-title">
                            Are you sure want to select this person?
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button
                                type="button"
                                class="btn btn-sm btn-info"
                                @click="handleSelectPerson"
                                :disabled="isSelected"
                            >
                                <span v-if="isSelected" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                {{ isSelected ? 'Confirming...': 'Confirm' }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                data-dismiss="modal"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add marking modal -->
        <div class="modal fade" id="openMarkingModal" tabindex="-1" aria-labelledby="openMarkingModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 460px !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="openMarkingModalLabel">
                            <i class="fa fa-bars"></i>
                            Interview Marks Entry
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="submitMark">
                        <div class="modal-body px-3">
                            <div class="form-group">
                                <label for="experience_mark">
                                    Experiences (Out of 10)
                                    <span style="color: red;">*</span>
                                </label>
                                <input
                                    v-model="markForm.cim_experience_mark"
                                    class="form-control" id="experience_mark"
                                    type="number" @input="checkExperience"
                                    min="0" max="10"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="experience_mark">
                                    Dress-up/Smartness (Out of 10)
                                    <span style="color: red;">*</span>
                                </label>
                                <input
                                    v-model="markForm.cim_dressup_mark"
                                    class="form-control" id="experience_mark"
                                    @input="checkDressup"
                                    type="number" min="0" max="10"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="experience_mark">
                                    Academic Qualification (Out of 10)
                                    <span style="color: red;">*</span>
                                </label>
                                <input
                                    v-model="markForm.cim_academic_mark"
                                    class="form-control" id="experience_mark"
                                    @input="checkAcademic"
                                    type="number" min="0" max="10"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="experience_mark">
                                    Viva Marks (Out of 10)
                                    <span style="color: red;">*</span>
                                </label>
                                <input
                                    v-model="markForm.cim_viva_mark"
                                    class="form-control" id="experience_mark"
                                    @input="checkViva"
                                    type="number" min="0" max="10"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="experience_mark">
                                    Written Marks (Out of 10)
                                    <span style="color: red;">*</span>
                                </label>
                                <input
                                    v-model="markForm.cim_written_mark"
                                    class="form-control" id="experience_mark"
                                    @input="checkWritten"
                                    min="0" max="10" required
                                >
                            </div>

                            <div class="mt-3">
                                Total Mark: {{ markForm.cim_total_mark }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info"
                                    @click="submitMark"
                                    :disabled="isMarkSubmit"
                                >
                                    <span v-if="isMarkSubmit" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    {{ isMarkSubmit ? 'Submitting...': 'Submit' }}
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    data-dismiss="modal"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import PageLoading from '../Loading.vue';

export default {
    components: {
        PageLoading
    },
    data() {
        return {
            candidates: [],
            candidate_id: '',

            isSelected: false,
            isRejected: false,
            isSendMail: false,
            isUnlisted: false,
            isMarkSubmit: false,
            isShortListed: false,
            isPageLoading: false,
            isShortListedMail: false,

            counts: {
                applied: 0,
                shortlisted: 0,
                selected: 0,
                rejected: 0
            },

            minAge: '',
            maxAge: '',
            minSalary: '',
            maxSalary: '',
            gander: '',
            search: '',
            status: '',
            page: 1,
            sort: 'id',
            order: 'desc',
            paginateNum: 15,
            minExperience: '',
            maxExperience: '',
            pageRefId: this.$route.params.jobId,

            markForm: {
                cim_candidate_id: '',
                cim_experience_mark: 0,
                cim_dressup_mark: 0,
                cim_academic_mark: 0,
                cim_viva_mark: 0,
                cim_written_mark: 0,
                cim_total_mark: 0,
                cim_circular_id: this.$route.params.jobId,
            }
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        openMarkingModal(id) {
            this.markForm.cim_candidate_id = id;
            $('#openMarkingModal').modal('show');
        },
        handleShortList(id) {
            this.candidate_id = id;
            $('#confirmShortListModal').modal('show');
        },
        confirmRejectModal(id) {
            this.candidate_id = id;
            $('#confirmRejectModal').modal('show');
        },
        confirmSelectModal(id) {
            this.candidate_id = id;
            $('#confirmSelectModal').modal('show');
        },
        async submitMark() {
            this.isMarkSubmit = true;
            await axios.post(URL.baseUrl(`add-marking`), this.markForm)
                .then((res) => {
                    this.isMarkSubmit = false;
                    this.fetchData();
                    $('#openMarkingModal').modal('hide');
                    this.showToster(res.data);
                });
        },
        async handleCandidateShortWithMail() {
            this.isShortListedMail = true;
            await axios.get(URL.baseUrl(`candidate-short-mail/${this.candidate_id}`))
                .then((res) => {
                    this.isShortListedMail = false;
                    this.fetchData();
                    $('#confirmShortListModal').modal('hide');
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async handleCandidateShort() {
            this.isShortListed = true;
            await axios.get(URL.baseUrl(`candidate-short/${this.candidate_id}`))
                .then((res) => {
                    this.isShortListed = false;
                    this.fetchData();
                    $('#confirmShortListModal').modal('hide');
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async handleSendMail(id) {
            this.isSendMail = true;
            await axios.get(URL.baseUrl(`candidate-send-mail/${id}`))
                .then((res) => {
                    this.isSendMail = false;
                    this.fetchData();
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async handleUnlisted(id) {
            this.isUnlisted = true;
            await axios.get(URL.baseUrl(`candidate-unlisted/${id}`))
                .then((res) => {
                    this.isUnlisted = false;
                    this.fetchData();
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async handleRejectPerson() {
            this.isRejected = true;
            await axios.get(URL.baseUrl(`candidate-rejected/${this.candidate_id}`))
                .then((res) => {
                    this.isRejected = false;
                    this.fetchData();
                    $('#confirmRejectModal').modal('hide');
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async handleSelectPerson() {
            this.isSelected = true;
            await axios.get(URL.baseUrl(`candidate-selected/${this.candidate_id}`))
                .then((res) => {
                    this.isSelected = false;
                    this.fetchData();
                    $('#confirmSelectModal').modal('hide');
                    this.showToster(res.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async fetchData() {
            const res = await axios.get(URL.baseUrl("cvlist/job_circular"), {
                params: {
                    search: this.search,
                    status: this.status,
                    page: this.page,
                    sort: this.sort,
                    gander: this.gander,
                    order: this.order,
                    min_age: this.minAge,
                    max_age: this.maxAge,
                    min_salary: this.minSalary,
                    max_salary: this.maxSalary,
                    page_ref_id: this.pageRefId,
                    paginate_num: this.paginateNum,
                    min_experience: this.minExperience,
                    max_experience: this.maxExperience,
                }
            });
            this.counts = res.data.counts;
            this.candidates = res.data.candidates;
            this.designations = res.data.designations;
        },
        handleSearch(e) {
            this.search = e.target.value;
            this.fetchData();
        },
        handlePaginatePage(page) {
            this.page = page;
            this.fetchData();
        },
        handlePaginatePerPage(e) {
            this.paginateNum = e.target.value;
            this.fetchData();
        },
        filterByStatus(status) {
            this.status = status;
            this.fetchData();
        },
        handleFilter() {
            this.fetchData();
        },
        checkExperience() {
            if (this.markForm.cim_experience_mark > 10) {
                alert('Max mark is 10');
                this.markForm.cim_experience_mark = 10;
            }
            if (this.markForm.cim_experience_mark < 0) {
                alert('Min mark is 0');
                this.markForm.cim_experience_mark = 0;
            }
            this.calculateMarkTotal();
        },
        checkViva() {
            if (this.markForm.cim_viva_mark > 10) {
                alert('Max mark is 10');
                this.markForm.cim_viva_mark = 10;
            }
            if (this.markForm.cim_viva_mark < 0) {
                alert('Min mark is 0');
                this.markForm.cim_viva_mark = 0;
            }
            this.calculateMarkTotal();
        },
        checkDressup() {
            if (this.markForm.cim_dressup_mark > 10) {
                alert('Max mark is 10');
                this.markForm.cim_dressup_mark = 10;
            }
            if (this.markForm.cim_dressup_mark < 0) {
                alert('Min mark is 0');
                this.markForm.cim_dressup_mark = 0;
            }
            this.calculateMarkTotal();
        },
        checkAcademic() {
            if (this.markForm.cim_academic_mark > 10) {
                alert('Max mark is 10');
                this.markForm.cim_academic_mark = 10;
            }
            if (this.markForm.cim_academic_mark < 0) {
                alert('Min mark is 0');
                this.markForm.cim_academic_mark = 0;
            }
            this.calculateMarkTotal();
        },
        checkWritten() {
            if (this.markForm.cim_written_mark > 10) {
                alert('Max mark is 10');
                this.markForm.cim_written_mark = 10;
            }
            if (this.markForm.cim_written_mark < 0) {
                alert('Min mark is 0');
                this.markForm.cim_written_mark = 0;
            }
            this.calculateMarkTotal();
        },
        calculateMarkTotal() {
            this.markForm.cim_total_mark =
                Number(this.markForm.cim_experience_mark) +
                Number(this.markForm.cim_dressup_mark) +
                Number(this.markForm.cim_academic_mark) +
                Number(this.markForm.cim_viva_mark) +
                Number(this.markForm.cim_written_mark);
        },
    }
}
</script>

<style scoped>
.info-box {
    cursor: pointer;
}
</style>
