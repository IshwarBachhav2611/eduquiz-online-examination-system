<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Examination | EduQuiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>

        *{

            margin:0;
            padding:0;
            box-sizing:border-box;

        }

        :root{

            --primary:#2563EB;
            --primary-dark:#1D4ED8;
            --border:#E2E8F0;
            --text:#64748B;
            --bg:#F8FAFC;
            --card:#FFFFFF;

        }

        body{

            background:var(--bg);
            font-family:'Segoe UI',sans-serif;

        }

        .page{

            padding:50px 0;

        }

        .exam-card{

            background:#fff;

            border-radius:22px;

            border:1px solid var(--border);

            padding:40px;

            box-shadow:0 15px 35px rgba(15,23,42,.05);

        }

        .page-title{

            font-size:34px;

            font-weight:700;

            color:#0F172A;

        }

        .page-subtitle{

            color:var(--text);

            margin-top:8px;

            margin-bottom:35px;

            line-height:1.8;

        }

        .section{

            margin-top:40px;

        }

        .section-title{

            font-size:20px;

            font-weight:700;

            color:#0F172A;

            margin-bottom:20px;

            display:flex;

            align-items:center;

            gap:10px;

        }

        .section-title i{

            color:var(--primary);

            font-size:22px;

        }

        .form-label{

            font-weight:600;

            margin-bottom:8px;

        }

        .required{

            color:red;

        }

        .form-control,
        .form-select{

            border-radius:12px;

            padding:12px 15px;

            border:1px solid var(--border);

        }

        .form-control:focus,
        .form-select:focus{

            border-color:var(--primary);

            box-shadow:0 0 0 .15rem rgba(37,99,235,.15);

        }

        textarea{

            resize:none;

        }

        hr{

            margin:40px 0;

            color:#E5E7EB;

        }

        @media(max-width:768px){

            .exam-card{

                padding:25px;

            }

            .page-title{

                font-size:28px;

            }

        }

    </style>

</head>

<body>

    <div class="page">

        <div class="container">

            <div class="exam-card">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h1 class="page-title">

                            Create New Examination

                        </h1>

                        <p class="page-subtitle">

                            Fill in the examination details.
                            After saving, you'll continue to the Question Management module.

                        </p>

                    </div>

                    <a href="<?= base_url('dashboard') ?>"
                    class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Back

                    </a>

                </div>

                <form method="post"
                    action="<?= base_url('exams/store') ?>">

                    <?= csrf_field() ?>

                    <!-- ==========================================
                        Basic Information
                    ========================================== -->

                    <div class="section">

                        <h4 class="section-title">

                            <i class="bi bi-info-circle-fill"></i>

                            Basic Information

                        </h4>

                        <div class="row">

                            <!-- Exam Title -->

                            <div class="col-md-12 mb-4">

                                <label class="form-label">

                                    Examination Title
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="title"
                                    placeholder="Example: Java Programming Mid Semester Examination"
                                    value="<?= old('title') ?>">

                                <small class="text-danger">

                                    <?= session('errors.title') ?>

                                </small>

                            </div>

                            <!-- Subject -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Subject
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="subject"
                                    placeholder="Example: Java Programming"
                                    value="<?= old('subject') ?>">

                                <small class="text-danger">

                                    <?= session('errors.subject') ?>

                                </small>

                            </div>

                            <!-- Status -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Examination Status

                                </label>

                                <select
                                    class="form-select"
                                    name="status">

                                    <option value="Draft">

                                        Draft

                                    </option>

                                    <option value="Published">

                                        Published

                                    </option>

                                </select>

                            </div>

                            <!-- Description -->

                            <div class="col-12 mb-4">

                                <label class="form-label">

                                    Description

                                </label>

                                <textarea
                                    class="form-control"
                                    rows="4"
                                    name="description"
                                    placeholder="Write a short description about this examination..."><?= old('description') ?></textarea>

                                <small class="text-danger">

                                    <?= session('errors.description') ?>

                                </small>

                            </div>

                            <!-- Instructions -->

                            <div class="col-12">

                                <label class="form-label">

                                    Examination Instructions

                                </label>

                                <textarea
                                    class="form-control"
                                    rows="6"
                                    name="instructions"
                                    placeholder="Example:

                                    • Read all questions carefully.
                                    • No tab switching allowed.
                                    • Full-screen mode is mandatory.
                                    • The exam will be submitted automatically after the timer ends.
                                    • No negative marking.
                                    "><?= old('instructions') ?>
                                </textarea>

                                <small class="text-danger">

                                    <?= session('errors.instructions') ?>

                                </small>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <!-- ==========================================
                        Exam Configuration
                    ========================================== -->

                    <div class="section">

                        <h4 class="section-title">

                            <i class="bi bi-gear-fill"></i>

                            Exam Configuration

                        </h4>

                        <div class="row">

                            <!-- Duration -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Duration (Minutes)
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="duration"
                                    min="1"
                                    placeholder="60"
                                    value="<?= old('duration') ?>">

                                <small class="text-danger">

                                    <?= session('errors.duration') ?>

                                </small>

                            </div>

                            <!-- Total Marks -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Total Marks
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="total_marks"
                                    min="1"
                                    placeholder="100"
                                    value="<?= old('total_marks') ?>">

                                <small class="text-danger">

                                    <?= session('errors.total_marks') ?>

                                </small>

                            </div>

                            <!-- Passing Marks -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Passing Marks
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="passing_marks"
                                    min="1"
                                    placeholder="40"
                                    value="<?= old('passing_marks') ?>">

                                <small class="text-danger">

                                    <?= session('errors.passing_marks') ?>

                                </small>

                            </div>

                            <!-- Maximum Attempts -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Maximum Attempts

                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="max_attempts"
                                    min="1"
                                    value="<?= old('max_attempts') ?: 1 ?>">

                            </div>

                            <!-- Negative Marking -->

                            <div class="col-md-6 mb-4">

                                <label class="form-label">

                                    Negative Marking

                                </label>

                                <select
                                    class="form-select"
                                    name="negative_marking">

                                    <option value="No">

                                        No

                                    </option>

                                    <option value="Yes">

                                        Yes

                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <!-- ==========================================
                        Schedule
                    ========================================== -->

                    <div class="section">

                        <h4 class="section-title">

                            <i class="bi bi-calendar-event-fill"></i>

                            Examination Schedule

                        </h4>

                        <div class="row">

                            <!-- Exam Date -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Examination Date
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    name="exam_date"
                                    value="<?= old('exam_date') ?>">

                                <small class="text-danger">

                                    <?= session('errors.exam_date') ?>

                                </small>

                            </div>

                            <!-- Start Time -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    Start Time
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="time"
                                    class="form-control"
                                    name="start_time"
                                    value="<?= old('start_time') ?>">

                                <small class="text-danger">

                                    <?= session('errors.start_time') ?>

                                </small>

                            </div>

                            <!-- End Time -->

                            <div class="col-md-4 mb-4">

                                <label class="form-label">

                                    End Time
                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="time"
                                    class="form-control"
                                    name="end_time"
                                    value="<?= old('end_time') ?>">

                                <small class="text-danger">

                                    <?= session('errors.end_time') ?>

                                </small>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <!-- ==========================================
                        Action Buttons
                    ========================================== -->

                    <div class="section">

                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <!-- Back Button -->

                            <a href="<?= base_url('dashboard') ?>"
                            class="btn btn-outline-secondary px-4 py-2">

                                <i class="bi bi-arrow-left me-2"></i>

                                Back to Dashboard

                            </a>

                            <!-- Action Buttons -->

                            <div class="mt-3 mt-md-0">

                                <button
                                    type="submit"
                                    name="action"
                                    value="draft"
                                    class="btn btn-outline-primary px-4 py-2 me-2">

                                    <i class="bi bi-file-earmark me-2"></i>

                                    Save as Draft

                                </button>

                                <button
                                    type="submit"
                                    name="action"
                                    value="continue"
                                    class="btn btn-primary px-4 py-2">

                                    <i class="bi bi-arrow-right-circle me-2"></i>

                                    Save & Continue

                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>