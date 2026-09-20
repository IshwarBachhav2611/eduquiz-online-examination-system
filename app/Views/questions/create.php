<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Questions | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f8fafc;
        }

        .upload-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .card-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

    </style>

</head>


<body class="bg-light">


<div class="container py-5">


    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Add Questions
            </h2>

            <p class="text-muted mb-0">
                Create questions for your examination.
            </p>

        </div>


        <a
            href="<?= base_url('/dashboard') ?>"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Dashboard

        </a>

    </div>


    <!-- SUCCESS MESSAGE -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            <?= esc(session()->getFlashdata('success')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- ERROR MESSAGE -->

    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle me-2"></i>

            <?= esc(session()->getFlashdata('error')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- VALIDATION ERRORS -->

    <?php if (session()->getFlashdata('errors')): ?>

        <div class="alert alert-danger">

            <strong>
                Please correct the following:
            </strong>

            <ul class="mb-0 mt-2">

                <?php foreach (
                    session()->getFlashdata('errors')
                    as $error
                ): ?>

                    <li>
                        <?= esc($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <!-- EXAM INFORMATION -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <small class="text-muted">
                        Examination
                    </small>

                    <h5 class="fw-semibold mb-0">

                        <?= esc($exam['title']) ?>

                    </h5>

                </div>


                <div class="col-md-6">

                    <small class="text-muted">
                        Subject
                    </small>

                    <h5 class="fw-semibold mb-0">

                        <?= esc($exam['subject']) ?>

                    </h5>

                </div>

            </div>

        </div>

    </div>


    <!-- QUESTION COUNT -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="fw-bold mb-0">
            Questions
        </h5>


        <span class="badge bg-primary rounded-pill">

            <?= count($questions) ?> Question(s)

        </span>

    </div>


    <!-- SAVED QUESTIONS -->

    <?php if (!empty($questions)): ?>

        <?php foreach ($questions as $index => $question): ?>

            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body p-4">


                    <!-- QUESTION HEADER -->

                    <div class="d-flex justify-content-between align-items-start">

                        <div class="d-flex gap-3">

                            <div
                                class="bg-primary text-white rounded-circle
                                       d-flex align-items-center justify-content-center"
                                style="width: 38px; height: 38px;"
                            >

                                <strong>
                                    <?= $index + 1 ?>
                                </strong>

                            </div>


                            <div>

                                <h6 class="fw-bold mb-1">

                                    Question <?= $index + 1 ?>

                                </h6>

                                <p class="mb-0">

                                    <?= esc($question['question']) ?>

                                </p>

                            </div>

                        </div>


                        <div class="d-flex justify-content-end align-items-center gap-2">

                            <a
                                href="<?= base_url('/questions/edit/' . $question['id']) ?>"
                                class="btn btn-sm btn-outline-primary"
                            >

                                <i class="bi bi-pencil"></i>

                                Edit

                            </a>


                            <a
                                href="<?= base_url('/questions/delete/' . $question['id']) ?>"
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this question?');"
                            >

                                <i class="bi bi-trash"></i>

                                Delete

                            </a>

                        </div>

                    </div>


                    <!-- OPTIONS -->

                    <div class="row g-3 mt-3">

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <strong>A.</strong>

                                <?= esc($question['option_a']) ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <strong>B.</strong>

                                <?= esc($question['option_b']) ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <strong>C.</strong>

                                <?= esc($question['option_c']) ?>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <strong>D.</strong>

                                <?= esc($question['option_d']) ?>

                            </div>

                        </div>

                    </div>


                    <!-- QUESTION FOOTER -->

                    <div class="d-flex gap-4 mt-3 text-muted">

                        <span>

                            <i class="bi bi-check-circle me-1"></i>

                            Correct:

                            <strong class="text-success">

                                <?= esc($question['correct_option']) ?>

                            </strong>

                        </span>


                        <span>

                            <i class="bi bi-award me-1"></i>

                            <?= esc($question['marks']) ?> Marks

                        </span>

                    </div>


                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <!-- EMPTY STATE -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body text-center py-5">

                <i
                    class="bi bi-question-circle display-5 text-muted"
                ></i>

                <h5 class="fw-semibold mt-3">

                    No questions added yet

                </h5>

                <p class="text-muted mb-0">

                    Add your first question manually or upload a CSV file.

                </p>

            </div>

        </div>

    <?php endif; ?>


    <!-- ========================================================= -->
    <!-- UPLOAD CSV -->
    <!-- ========================================================= -->

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body p-4">

            <div class="d-flex align-items-start gap-3">

                <div class="upload-icon">

                    <i class="bi bi-file-earmark-spreadsheet"></i>

                </div>


                <div class="flex-grow-1">

                    <h5 class="fw-bold mb-1">

                        Upload Questions from CSV

                    </h5>

                    <p class="text-muted mb-3">

                        Add multiple questions at once by uploading
                        a properly formatted CSV file.

                    </p>


                    <div class="alert alert-light border mb-4">

                        <div class="fw-semibold mb-2">

                            CSV format

                        </div>

                        <code class="text-dark">

                            question,option_a,option_b,option_c,option_d,correct_option,marks

                        </code>

                    </div>


                    <form
                        action="<?= base_url('/questions/upload-csv/' . $exam['id']) ?>"
                        method="post"
                        enctype="multipart/form-data"
                    >

                        <?= csrf_field() ?>


                        <div class="row align-items-end g-3">

                            <div class="col-md-8">

                                <label
                                    for="questions_csv"
                                    class="form-label fw-semibold"
                                >

                                    Questions CSV File

                                </label>


                                <input
                                    type="file"
                                    name="questions_csv"
                                    id="questions_csv"
                                    class="form-control"
                                    accept=".csv,text/csv"
                                    required
                                >


                                <div class="form-text">

                                    Only CSV files are allowed.

                                </div>

                            </div>


                            <div class="col-md-4">

                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >

                                    <i class="bi bi-upload me-1"></i>

                                    Upload Questions

                                </button>

                            </div>

                        </div>

                    </form>


                    <div class="mt-3">

                        <small class="text-muted">

                            Each row should contain:

                            Question, four options,
                            correct option (A/B/C/D), and marks.

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- ADD QUESTION MANUALLY -->
    <!-- ========================================================= -->

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body p-4">


            <h5 class="fw-bold mb-4">

                <i class="bi bi-plus-circle me-2"></i>

                Add Question Manually

            </h5>


            <form
                action="<?= base_url('/questions/store/' . $exam['id']) ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <!-- QUESTION -->

                <div class="mb-4">

                    <label
                        for="question"
                        class="form-label fw-semibold"
                    >

                        Question

                    </label>


                    <textarea
                        name="question"
                        id="question"
                        rows="4"
                        class="form-control"
                        placeholder="Enter your question here..."
                        required
                    ><?= old('question') ?></textarea>

                </div>


                <!-- OPTIONS -->

                <div class="row g-3">


                    <div class="col-md-6">

                        <label
                            for="option_a"
                            class="form-label fw-semibold"
                        >

                            Option A

                        </label>


                        <input
                            type="text"
                            name="option_a"
                            id="option_a"
                            class="form-control"
                            placeholder="Enter option A"
                            value="<?= old('option_a') ?>"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="option_b"
                            class="form-label fw-semibold"
                        >

                            Option B

                        </label>


                        <input
                            type="text"
                            name="option_b"
                            id="option_b"
                            class="form-control"
                            placeholder="Enter option B"
                            value="<?= old('option_b') ?>"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="option_c"
                            class="form-label fw-semibold"
                        >

                            Option C

                        </label>


                        <input
                            type="text"
                            name="option_c"
                            id="option_c"
                            class="form-control"
                            placeholder="Enter option C"
                            value="<?= old('option_c') ?>"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="option_d"
                            class="form-label fw-semibold"
                        >

                            Option D

                        </label>


                        <input
                            type="text"
                            name="option_d"
                            id="option_d"
                            class="form-control"
                            placeholder="Enter option D"
                            value="<?= old('option_d') ?>"
                            required
                        >

                    </div>

                </div>


                <!-- CORRECT OPTION + MARKS -->

                <div class="row g-3 mt-2">


                    <div class="col-md-6">

                        <label
                            for="correct_option"
                            class="form-label fw-semibold"
                        >

                            Correct Option

                        </label>


                        <select
                            name="correct_option"
                            id="correct_option"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select correct option
                            </option>

                            <option
                                value="A"
                                <?= old('correct_option') === 'A'
                                    ? 'selected'
                                    : '' ?>
                            >
                                Option A
                            </option>

                            <option
                                value="B"
                                <?= old('correct_option') === 'B'
                                    ? 'selected'
                                    : '' ?>
                            >
                                Option B
                            </option>

                            <option
                                value="C"
                                <?= old('correct_option') === 'C'
                                    ? 'selected'
                                    : '' ?>
                            >
                                Option C
                            </option>

                            <option
                                value="D"
                                <?= old('correct_option') === 'D'
                                    ? 'selected'
                                    : '' ?>
                            >
                                Option D
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label
                            for="marks"
                            class="form-label fw-semibold"
                        >

                            Marks

                        </label>


                        <input
                            type="number"
                            name="marks"
                            id="marks"
                            class="form-control"
                            min="1"
                            placeholder="Enter marks"
                            value="<?= old('marks') ?>"
                            required
                        >

                    </div>

                </div>


                <!-- ADD QUESTION -->

                <div class="d-flex justify-content-end mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-plus-circle me-1"></i>

                        Add Question

                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- FINISH -->

    <div class="card-box p-4 mt-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    Finished adding questions?
                </h5>

                <p class="text-muted mb-0">

                    <?= count($questions) ?>
                    question(s) added to this examination.

                </p>

            </div>


            <a
                href="<?= base_url('/exams/review/' . $exam['id']) ?>"
                class="btn btn-success"
            >

                <i class="bi bi-check-circle"></i>

                Finish Examination

            </a>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>