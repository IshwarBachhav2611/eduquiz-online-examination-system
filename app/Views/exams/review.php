<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Review Examination</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7fa;
            color: #172033;
        }

        .page-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .exam-header {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }

        .question-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
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
            flex-shrink: 0;
        }

        .option-box {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 14px;
            background: #fafafa;
        }

        .correct-option {
            border-color: #198754;
            background: #eaf7ef;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .finish-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

    </style>

</head>

<body>

<div class="page-container">

    <!-- Page Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Review Examination
            </h2>

            <p class="text-muted mb-0">
                Review your examination before finishing.
            </p>

        </div>

        <a href="<?= base_url('/dashboard') ?>"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Dashboard

        </a>

    </div>


    <!-- Examination Information -->

    <div class="exam-header">

        <div class="row">

            <div class="col-md-6">

                <small class="text-muted">
                    Examination
                </small>

                <h4 class="fw-bold">
                    <?= esc($exam['title']) ?>
                </h4>

            </div>

            <div class="col-md-6">

                <small class="text-muted">
                    Subject
                </small>

                <h4 class="fw-bold">
                    <?= esc($exam['subject']) ?>
                </h4>

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-4">

                <small class="text-muted">
                    Duration
                </small>

                <div>
                    <?= esc($exam['duration']) ?> Minutes
                </div>

            </div>

            <div class="col-md-4">

                <small class="text-muted">
                    Total Marks
                </small>

                <div>
                    <?= esc($exam['total_marks']) ?>
                </div>

            </div>

            <div class="col-md-4">

                <small class="text-muted">
                    Passing Marks
                </small>

                <div>
                    <?= esc($exam['passing_marks']) ?>
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

        <div class="alert alert-warning">

            <i class="bi bi-exclamation-circle"></i>

            No questions have been added yet.

        </div>

    <?php else: ?>

        <?php foreach ($questions as $index => $question): ?>

            <div class="question-card">

                <!-- Question Header -->

                <div class="d-flex align-items-start">

                    <div class="question-number">

                        <?= $index + 1 ?>

                    </div>


                    <div class="ms-3 flex-grow-1">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="fw-bold mb-2">

                                    Question <?= $index + 1 ?>

                                </h5>

                                <p class="mb-0">

                                    <?= esc($question['question']) ?>

                                </p>

                            </div>


                            <div class="action-buttons">

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
                                    onclick="return confirm('Are you sure you want to delete this question?')"
                                >

                                    <i class="bi bi-trash"></i>
                                    Delete

                                </a>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Options -->

                <div class="row g-3 mt-3">

                    <div class="col-md-6">

                        <div class="option-box <?= $question['correct_option'] === 'A' ? 'correct-option' : '' ?>">

                            <strong>A.</strong>

                            <?= esc($question['option_a']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option-box <?= $question['correct_option'] === 'B' ? 'correct-option' : '' ?>">

                            <strong>B.</strong>

                            <?= esc($question['option_b']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option-box <?= $question['correct_option'] === 'C' ? 'correct-option' : '' ?>">

                            <strong>C.</strong>

                            <?= esc($question['option_c']) ?>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="option-box <?= $question['correct_option'] === 'D' ? 'correct-option' : '' ?>">

                            <strong>D.</strong>

                            <?= esc($question['option_d']) ?>

                        </div>

                    </div>

                </div>


                <!-- Question Footer -->

                <div class="mt-3 pt-3 border-top">

                    <span class="text-success me-4">

                        <i class="bi bi-check-circle"></i>

                        Correct:
                        <strong>
                            <?= esc($question['correct_option']) ?>
                        </strong>

                    </span>


                    <span class="text-muted">

                        <i class="bi bi-award"></i>

                        <?= esc($question['marks']) ?> Marks

                    </span>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


    <!-- Add Another Question -->

    <div class="mb-4">

        <a
            href="<?= base_url('/questions/create/' . $exam['id']) ?>"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-plus-circle"></i>

            Add Another Question

        </a>

    </div>


    <!-- Finish Examination -->

    <div class="finish-card">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    Ready to finish?
                </h5>

                <p class="text-muted mb-0">

                    <?= count($questions) ?>
                    question(s) added to this examination.

                </p>

            </div>


            <a  href="<?= base_url('exams/share/' . $exam['id']) ?>"
                class="btn btn-success">
                
                <i class="bi bi-check-circle"></i>
                Finish Examination
            </a>

        </div>

    </div>

</div>

</body>

</html>