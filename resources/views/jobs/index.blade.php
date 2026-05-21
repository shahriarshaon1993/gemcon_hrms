@extends('layouts.job_layout')
@section('title', 'jobs')

@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #0d6efd;
            --dark: #0b1c2d;
        }

        /* HERO */
        .careers-hero {
            background: linear-gradient(rgba(11,28,45,.85), rgba(11,28,45,.85)),
            url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d') center/cover;
            padding: 120px 0;
        }

        /* SECTIONS */
        .careers-section {
            padding: 80px 0;
        }

        .section-header h2 {
            font-weight: 700;
        }

        /* FORM CARD */
        .form-card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,.08);
            max-width: 900px;
        }

        /* CARDS */
        .career-card {
            background: #fff;
            padding: 30px;
            text-align: center;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(0,0,0,.08);
            font-weight: 600;
            transition: .3s;
        }

        .career-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 45px rgba(0,0,0,.12);
        }

        /* BUTTON */
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
        }

        .select2-container--default .select2-selection--single {
            height: 36px;
            padding: 3px;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content" style="min-height: calc(100vh - 126px)">
            <div class="container" style="margin-bottom: 1rem;">
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        <h2 class="text-success">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Congratulations!</span>
                        </h2>
                        <p style="margin-left: 42px; font-size: 18px;">
                            {{ Session::get('message') }}
                        </p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Small boxes (Stat box) -->
                <div class="row" style="padding-top: 10px;"></div>

                @forelse ($jobs as $job)
                    <div class="job-card mt-3" id="jobCircular" data-id="{{ $job->id }}">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body circulars">
                                        <h3 class="card-title">
                                            {{ $job->designation_name }}
                                        </h3>
                                        <h6 class="card-title">{{ $job->sbu_name }}</h6>

                                        <div>
                                            {!! \Illuminate\Support\Str::words($job->jc_job_description, 30, '...') !!}
                                        </div>

                                        {{-- <div style="max-width: 30rem;">
                                            <p class="card-text">
                                                <i class="fa-solid fa-location-dot circular-icon"></i>
                                                <span>{{ $job->work_location_name }}</span>
                                            </p>
                                            <p class="card-text">
                                                <i class="fas fa-graduation-cap circular-icon"></i>
                                                <span>{{ $job->jc_educational_requirements }}</span>
                                            </p>
                                        </div> --}}

                                        {{-- <div class="d-flex align-items-center justify-content-between mt-2">
                                            <p class="card-text">
                                                <i class="fas fas fa-briefcase circular-icon"></i>
                                                <span>{{ $job->jc_experience_requirements }}</span>
                                            </p>
                                            <p class="card-text">
                                                <i class="fas fa-calendar circular-icon"></i>
                                                <span>
                                                    Deadline: {{ date('d M Y', strtotime($job->jc_circular_expired_date)) }}
                                                </span>
                                            </p>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <section class="careers-hero text-white text-center">
                        <div class="container">
                            <h1 class="fw-bold mb-3">Careers at Gemcon Group</h1>
                            <p class="lead">
                                <strong>We’re not hiring right now — but we’re always looking for great people.</strong><br>
                                Submit your profile to our Talent Pool and we’ll contact you when an opportunity opens.
                            </p>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a class="btn btn-primary btn-lg" href="#talent-pool">Join the Talent Pool</a>
                                <a class="btn btn-outline-light btn-lg" href="#job-alerts">Get Job Alerts</a>
                            </div>
                        </div>
                    </section>

                    <section id="talent-pool" class="careers-section">
                        <div class="container">
                            <div class="section-header text-center mb-5">
                                <h2>Join Our Talent Pool</h2>
                                <p>Share your CV and areas of interest. Our HR team will contact you when a role matches.</p>
                            </div>

                            <form class="form-card mx-auto" method="post" enctype="multipart/form-data" action="{{ route('applyTalent') }}">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input id="name" name="name" class="form-control" type="text"
                                               value="{{ old('name') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email *</label>
                                        <input id="email" name="email" class="form-control" type="email"
                                               value="{{ old('email') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone *</label>
                                        <input id="phone" name="phone" class="form-control" type="tel"
                                               value="{{ old('phone') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="department_id" class="form-label">Interested Department *</label>
                                        <select id="department_id" name="department_id" class="form-select selectDp" required>
                                            <option value="">Select…</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="experience_level" class="form-label">Experience Level *</label>
                                        <select id="experience_level" name="experience_level" class="form-select" required>
                                            <option value="">Select…</option>
                                            <option value="entry-level" {{ old('experience_level') == 'entry-level' ? 'selected' : '' }}>Entry-level</option>
                                            <option value="1-3 years" {{ old('experience_level') == '1-3 years' ? 'selected' : '' }}>1–3 years</option>
                                            <option value="3-7 years" {{ old('experience_level') == '3-7 years' ? 'selected' : '' }}>3–7 years</option>
                                            <option value="7+ years" {{ old('experience_level') == '7+ years' ? 'selected' : '' }}>7+ years</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Current Location</label>
                                        <input id="address" name="address" class="form-control" type="text"
                                               value="{{ old('address') }}">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="cv" class="form-label">Upload CV *</label>
                                        <input id="cv" name="cv" class="form-control" type="file" required>
                                        {{-- File inputs CANNOT retain old value for security reasons --}}
                                    </div>

                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Short Note</label>
                                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-check mt-4">
                                    <input id="is_agree" name="is_agree" class="form-check-input" type="checkbox"
                                           {{ old('is_agree') ? 'checked' : '' }} required>
                                    <label for="is_agree" class="form-check-label">
                                        I agree that GEMCON Group may store my information for recruitment purposes.
                                    </label>
                                </div>

                                <button class="btn btn-primary btn-lg mt-4 w-100">Submit Profile</button>
                            </form>

                        </div>
                    </section>

                    <section id="job-alerts" class="careers-section bg-light">
                        <div class="container text-center">
                            <h2>Get Job Alerts</h2>
                            <p>Receive an email when new opportunities are posted.</p>

                            <form action="{{ route('applyJobAlert') }}" method="POST" class="row justify-content-center g-3 mt-4">
                                @csrf

                                <div class="col-md-4">
                                    <input name="email" class="form-control" type="email" placeholder="Email address*" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <select name="department_id" class="form-select selectDp">
                                        <option value="">Select…</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="submit" class="btn btn-primary">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <section class="careers-section">
                        <div class="container">
                            <h2 class="text-center mb-5">Why Work With GEMCON Group</h2>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="career-card">Long-term growth</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="career-card">Professional environment</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="career-card">Learning culture</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="career-card">Stability & impact</div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Job Details Modal -->
    <div class="modal fade" id="jobDetailsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2" style="background: #fec23c;">
                    <h5 class="modal-title" id="jobDetailsModalLabel"></h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body circular-body px-4"></div>
            </div>
        </div>
    </div>

    <!-- Apply form Modal -->
    <div class="modal fade" id="applyFormModal" tabindex="-1" aria-labelledby="applyFormModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2" style="background: #fec23c;">
                    <h5 class="modal-title" id="applyFormModalLabel">
                        Apply Online
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <form action="{{ route('jobApply') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jac_job_circular_id" id="hiddenCircularId">
                        <input type="hidden" name="jac_company_name" id="hiddenCompanyName">
                        <input type="hidden" name="jac_job_position" id="hiddenJobPosition">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputName" class="form-label">Position Applied</label>
                                    <input id="inputName" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jac_candidate_name" class="form-label">
                                        Name
                                        <span class="required" style="color:red">*</span>
                                    </label>
                                    <input id="jac_candidate_name" name="jac_candidate_name" type="text"
                                           placeholder="Full Name" class="form-control input-md">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    Address
                                    <span class="required"style="color:red">*</span>
                                </label>
                                <textarea id="name" name="jac_candidate_address" placeholder="Example: Dhanmondi, Dhaka" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <div>
                                    <label class="radio-inline" for="Gender-0">
                                        <input type="radio" name="jac_gender" id="Gender-0" value="1"
                                               checked="checked">
                                        Male
                                    </label>
                                    <label class="radio-inline" for="Gender-1">
                                        <input type="radio" name="jac_gender" id="Gender-1" value="2">
                                        Female
                                    </label>
                                    <label class="radio-inline" for="Gender-2">
                                        <input type="radio" name="jac_gender" id="Gender-2" value="3">
                                        Others
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div>
                                    <label for="date" class="form-label">
                                        Date of Birth
                                        <span class="required" style="color:red">*</span>
                                    </label>
                                    <input class="form-control" id="date" name="jac_birth_day" type="text"
                                           placeholder="dd-mm-yyyy">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="contact_no" class="form-label">
                                    Contact No
                                    <span class="required" style="color:red">*</span>
                                </label>
                                <input id="contact_no" name="jac_contact_no" type="number" placeholder="Contact No."
                                       class="form-control" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="form-label">
                                    Email Address
                                    <span class="required" style="color:red">*</span>
                                </label>
                                <input id="email" name="jac_email_address" type="email"
                                       placeholder="Keep your email address" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="jac_highest_education" class="form-label">
                                    Highest Education
                                </label>
                                <input id="jac_highest_education" name="jac_highest_education" type="text"
                                       placeholder="Master of Science" class="form-control" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="universityName" class="form-label">
                                    University Name
                                </label>
                                <select name="jac_universitgy_name" class="form-select js-example-basic-single"
                                        id="universityName">
                                    <option>Select University</option>
                                    @foreach ($university_lists_data as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->university_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group col-md-12">
                                <label for="jac_last_employment" class="form-label">
                                    Last Employment
                                </label>
                                <input id="jac_last_employment" name="jac_last_employment" type="text"
                                       placeholder="Last Employment Office Name" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="jac_last_designation">Designation</label>
                                    <input id="jac_last_designation" name="jac_last_designation" type="text"
                                           placeholder="Last Designation" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="jac_last_experience">Experience</label>
                                    <input id="jac_last_experience" name="jac_last_experience" type="number"
                                           placeholder="Last Experience" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group">
                                <label class="form-label" for="jac_expected_salary">Expected Salary</label>
                                <input id="jac_expected_salary" name="jac_expected_salary" type="number"
                                       placeholder="Expected Salary" class="form-control">
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="form-group col-md-6">
                                <label for="imgInp">
                                    Picture
                                    <span class="required" style="color:red">*</span>
                                </label>
                                <input type="file" name="jac_image" class="form-control" id="imgInp">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cv_file">
                                    Attach CV
                                    <span class="required" style="color:red">*</span>
                                </label>
                                <input class="form-control" type="file" name="jac_cv" id="cv_file">
                            </div>
                        </div>

                        <div class="modal-footer pt-2 pb-0">
                            <button type="button" class="btn btn-sm btn-secondary" id="closeFormModal">Close</button>
                            <button type="submit" class="btn btn-sm btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- start scripts --}}
    @push('scripts')
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        {{-- start scripts --}}
        <script>
            $(document).ready(function() {
                $('.selectDp').select2({
                    placeholder: "Select a department",
                    allowClear: true
                });
            });

            $(function() {
                $("#date").datepicker();
            });

            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#jobCircular', function() {
                let circularId = $(this).data('id');

                $.post('<?= route('career.circular.show') ?>', {
                    id: circularId
                }, function(data) {
                    console.log(data);
                    $("#jobDetailsModalLabel").text(data.designation_name);

                    const circularDetails = getCircularDetails(data);

                    $('.circular-body').html(circularDetails);

                    $('#jobDetailsModal').modal('show');
                }, 'json');
            });

            $(document).on('click', '.apply-btn', function() {
                $('#jobDetailsModal').modal('hide');
                const rawData = $(this).attr('data-info');
                const data = JSON.parse(rawData);

                $('#hiddenCircularId').val(data.id);
                $('#inputName').val(data.designation_name);
                $('#hiddenCompanyName').val(data.jc_company_name);
                $('#hiddenJobPosition').val(data.jc_job_position);

                $('#applyFormModal').modal('show');
            });

            $(document).on('click', '#closeFormModal', function() {
                $('#applyFormModal').modal('hide');
            });

            function getCircularDetails(data) {
                return `
                    <div class="circular-details">
                        <h5>${data.sbu_name}</h5>
                        <div class="context-block">
                            <h6>Vacancy</h6>
                            <p>${data.jc_job_vacancy}</p>
                        </div>
                        <div class="context-block">
                            <h6>Job Context</h6>
                            <p>${data.jc_job_description}</p>
                        </div>
                        <div class="context-block">
                            <h6>Employment Status</h6>
                            <p>${data.jc_job_nature}</p>
                        </div>
                        <div class="context-block">
                            <h6>Workplace</h6>
                            <p>${data.work_location_name}</p>
                        </div>
                        <div class="context-block">
                            <h6>Job Location</h6>
                            <p>${data.work_location_name}</p>
                        </div>
                        <div class="context-block">
                            <h6>Salary</h6>
                            <p>${data.jc_salary_range}</p>
                        </div>

                        <div class="context-block">
                            <h6>Compensation & Other Benefits</h6>
                            <p>${data.jc_other_benefits}</p>
                        </div>
                    </div>

                    <div class="circular-footer">
                        <h5>Read Before Apply</h5>
                        <p class="footer-text-sm">This is an urgent requirements.</p>
                        <p class="footer-text">*Photograph must be enclosed with the resume.</p>
                        <p class="footer-text">Apply Procedure</p>
                        <button
                            type="button"
                            class="btn btn-sm btn-success my-2 apply-btn"
                            data-info='${JSON.stringify(data)}'
                        >
                            Apply Online
                        </button>
                        <p class="footer-text-sm mt-2">
                            Application Deadline : ${formatDate(data.jc_circular_expired_date)}
                        </p>
                    </div>
                `;
            }

            function formatDate(dateInput) {
                const date = new Date(dateInput);
                const options = {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                };
                return date.toLocaleDateString('en-GB', options);
            }
        </script>
    @endpush
@endsection
