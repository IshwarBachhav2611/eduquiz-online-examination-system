<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Question | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7f9;
            color: #172033;
        }

        .page-container {
            max-width: 1220px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 700;
        }

        .page-subtitle {
            color: #64748b;
        }

        .card-custom {
            background: #ffffff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .exam-info {
            padding: 22px;
        }

        .question-card {
            padding: 25px;
            margin-top: 22px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
        }

    </style>

</head>

<body>

<div class="page-container">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="page-title">
                Edit Question
            </div>

            <div class="page-subtitle">
                Update the question details for your examination.
            </div>

        </div>

        <a
            href="<?= base_url('questions/create/' . $exam['id']) ?>"
            class="btn btn-outline-secondary"
        >
            ← Back
        </a>

    </div>


    <!-- Examination Information -->

    <div class="card-custom exam-info">

        <div class="row">

            <div class="col-md-6">

                <small class="text-muted">
                    Examination
                </small>

                <div class="fw-semibold fs-5">
                    <?= esc($exam['title']) ?>
                </div>

            </div>

            <div class="col-md-6">

                <small class="text-muted">
                    Subject
                </small>

                <div class="fw-semibold fs-5">
                    <?= esc($exam['subject']) ?>
                </div>

            </div>

        </div>

    </div>


    <!-- Edit Question -->

    <div class="card-custom question-card">

        <div class="section-title">
            ✎ Question Details
        </div>


        <form
            action="<?= base_url('questions/update/' . $question['id']) ?>"
            method="post"
        >

            <?= csrf_field() ?>


            <!-- Question -->

            <div class="mb-4">

                <label class="form-label">
                    Question
                </label>

                <textarea
                    name="question"
                    class="form-control"
                    rows="4"
                    placeholder="Enter your question here..."
                    required
                ><?= esc($question['question']) ?></textarea>

            </div>


            <!-- Options -->

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Option A
                    </label>

                    <input
                        type="text"
                        name="option_a"
                        class="form-control"
                        value="<?= esc($question['option_a']) ?>"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Option B
                    </label>

                    <input
                        type="text"
                        name="option_b"
                        class="form-control"
                        value="<?= esc($question['option_b']) ?>"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Option C
                    </label>

                    <input
                        type="text"
                        name="option_c"
                        class="form-control"
                        value="<?= esc($question['option_c']) ?>"
                        required
                    >

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Option D
                    </label>

                    <input
                        type="text"
                        name="option_d"
                        class="form-control"
                        value="<?= esc($question['option_d']) ?>"
                        required
                    >

                </div>

            </div>


            <!-- Correct Option + Marks -->

            <div class="row mt-2">

                <div class="col-md-6">

                    <label class="form-label">
                        Correct Option
                    </label>

                    <select
                        name="correct_option"
                        class="form-select"
                        required
                    >

                        <option
                            value="A"
                            <?= $question['correct_option'] === 'A' ? 'selected' : '' ?>
                        >
                            Option A
                        </option>

                        <option
                            value="B"
                            <?= $question['correct_option'] === 'B' ? 'selected' : '' ?>
                        >
                            Option B
                        </option>

                        <option
                            value="C"
                            <?= $question['correct_option'] === 'C' ? 'selected' : '' ?>
                        >
                            Option C
                        </option>

                        <option
                            value="D"
                            <?= $question['correct_option'] === 'D' ? 'selected' : '' ?>
                        >
                            Option D
                        </option>

                    </select>

                </div>


                <div class="col-md-6">

                    <label class="form-label">
                        Marks
                    </label>

                    <input
                        type="number"
                        name="marks"
                        class="form-control"
                        min="1"
                        value="<?= esc($question['marks']) ?>"
                        required
                    >

                </div>

            </div>


            <!-- Buttons -->

            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="<?= base_url('questions/create/' . $exam['id']) ?>"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary px-4"
                >
                    ✓ Update Question
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>