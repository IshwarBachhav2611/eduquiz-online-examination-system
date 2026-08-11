<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Review Examination | EduQuiz</title>

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
            background: #f5f7fa;
            color: #172b4d;
        }

        .page-container {
            max-width: 1100px;
            margin: auto;
            padding: 35px 20px;
        }

        .card-box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }

        .exam-header {
            padding: 25px;
        }

        .question-card {
            padding: 22px;
            margin-bottom: 16px;
        }

        .question-number {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .option {
            border: 1px solid #dee2e6;
            border-radius: 7px;
            padding: 12px 15px;
            background: #fafbfc;
        }

        .correct-option {
            border-color: #198754;
            background: #f0fff7;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 600;
        }

    </style>

</head>

<body>

<div class="page-container">

    <!-- Header -->

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Review Examination
            </h2>

            <p class="text-muted mb-0">
                Review your examination before publishing it.
            </p>

        </div>

        <a
            href="<?= base_url('/questions/create/' . $exam['id']) ?>"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Questions
        </a>

    </div>


    <!-- Examination Summary -->

    <div class="card-box exam-header mb-4">

        <div class="row g-4">

            <div class="col-md-6">

                <small class="text-muted">
                    Examination
                </small>

                <div class="summary-value">
                    <?= esc($exam['title']) ?>
                </div>

            </div>


            <div class="col-md-6">

                <small class="text-muted">
                    Subject
                </small>

                <div class="summary-value">
                    <?= esc($exam['subject']) ?>
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Questions
                </small>

                <div class="summary-value">
                    <?= count($questions) ?>
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Total Marks
                </small>

                <div class="summary-value">
                    <?= esc($exam['total_marks']) ?>
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Passing Marks
                </small>

                <div class="summary-value">
                    <?= esc($exam['passing_marks']) ?>
                </div>

            </div>


            <div class="col-md-3">

                <small class="text-muted">
                    Duration
                </small>

                <div class="summary-value">
                    <?= esc($exam['duration']) ?> min
                </div>

            </div>

        </div>

    </div>


    <!-- Questions -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="fw-bold mb-0">
            Questions
        </h4>

        <span class="badge bg-primary">
            <?= count($questions) ?> Question(s)
        </span>

    </div>


    <?php if (empty($questions)): ?>

        <div class="card-box p-5 text-center">

            <i class="bi bi-exclamation-circle fs-1 text-warning"></i>

            <h5 class="mt-3">
                No questions added
            </h5>

            <p class="text-muted">
                Add at least one question before publishing the examination.
            </p>

            <a
                href="<?= base_url('/questions/create/' . $exam['id']) ?>"
                class="btn btn-primary"
            >
                Add Questions
            </a>

        </div>

    <?php else: ?>


        <?php foreach ($questions as $index => $question): ?>

            <div class="card-box question-card">

                <!-- Question Header -->

                <div class="d-flex justify-content-between align-items-start mb-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="question-number">
                            <?= $index + 1 ?>
                        </div>

                        <div>

                            <div class="fw-semibold">
                                Question <?= $index + 1 ?>
                            </div>

                            <small class="text-muted">
                                <?= esc($question['marks']) ?> Marks
                            </small>

                        </div>

                    </div>


                    <a
                        href="<?= base_url('/questions/edit/' . $question['id']) ?>"
                        class="btn btn-sm btn-outline-primary"
                    >
                        <i class="bi bi-pencil"></i>
                        Edit
                    </a>

                </div>


                <!-- Question -->

                <div class="mb-4">

                    <strong>
                        <?= esc($question['question']) ?>
                    </strong>

                </div>


                <!-- Options -->

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="option
                            <?= $question['correct_option'] === 'A'
                                ? 'correct-option'
                                : '' ?>"
                        >

                            <strong>A.</strong>
                            <?= esc($question['option_a']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option
                            <?= $question['correct_option'] === 'B'
                                ? 'correct-option'
                                : '' ?>"
                        >

                            <strong>B.</strong>
                            <?= esc($question['option_b']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option
                            <?= $question['correct_option'] === 'C'
                                ? 'correct-option'
                                : '' ?>"
                        >

                            <strong>C.</strong>
                            <?= esc($question['option_c']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option
                            <?= $question['correct_option'] === 'D'
                                ? 'correct-option'
                                : '' ?>"
                        >

                            <strong>D.</strong>
                            <?= esc($question['option_d']) ?>

                        </div>

                    </div>

                </div>


                <!-- Correct Answer -->

                <div class="mt-3 text-success">

                    <i class="bi bi-check-circle"></i>

                    Correct Answer:
                    <strong>
                        Option <?= esc($question['correct_option']) ?>
                    </strong>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


    <!-- Bottom Actions -->

    <?php if (!empty($questions)): ?>

        <div class="card-box p-4 mt-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Ready to publish?
                    </h5>

                    <p class="text-muted mb-0">
                        Review all questions carefully before publishing.
                    </p>

                </div>


                <div class="d-flex gap-2">

                    <a
                        href="<?= base_url('/questions/create/' . $exam['id']) ?>"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-pencil"></i>
                        Review Again
                    </a>

                    <button
                        type="button"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-send"></i>
                        Publish Examination
                    </button>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>

</body>

</html>