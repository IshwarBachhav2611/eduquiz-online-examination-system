<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($exam['title']) ?> | EduQuiz</title>

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
            color: #1e293b;
        }

        .exam-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .question-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        .question-number {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .option {
            display: block;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .option:hover {
            background: #f8fafc;
            border-color: #93c5fd;
        }

        .option input {
            margin-right: 10px;
        }

        .submit-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        @media (max-width: 768px) {

            .exam-title {
                font-size: 18px;
            }

            .question-card {
                border-radius: 10px;
            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header class="exam-header">

    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="exam-title fw-bold mb-1">
                    <?= esc($exam['title']) ?>
                </h5>

                <small class="text-muted">
                    <?= esc($exam['subject']) ?>
                    • <?= esc($exam['duration']) ?> minutes
                </small>

            </div>


            <div class="text-end">

                <small class="text-muted d-block">
                    Questions
                </small>

                <strong>
                    <?= count($questions) ?>
                </strong>

            </div>

        </div>

    </div>

</header>



<!-- =========================================================
     EXAM CONTENT
========================================================= -->

<main class="container py-4">

    <form
        action="<?= base_url('/student/exam/submit/' . $attemptId) ?>"
        method="post"
    >

        <?= csrf_field() ?>


        <?php foreach ($questions as $index => $question): ?>

            <div class="question-card shadow-sm mb-4">

                <div class="card-body p-4">


                    <!-- Question -->

                    <div class="d-flex gap-3 mb-4">

                        <div class="question-number">

                            <?= $index + 1 ?>

                        </div>


                        <div>

                            <h6 class="fw-bold mb-2">

                                Question <?= $index + 1 ?>

                            </h6>

                            <p class="mb-0">

                                <?= esc($question['question']) ?>

                            </p>

                        </div>

                    </div>



                    <!-- Options -->

                    <div>


                        <label class="option">

                            <input
                                type="radio"
                                name="answers[<?= $question['id'] ?>]"
                                value="A"
                            >

                            <strong>A.</strong>

                            <?= esc($question['option_a']) ?>

                        </label>



                        <label class="option">

                            <input
                                type="radio"
                                name="answers[<?= $question['id'] ?>]"
                                value="B"
                            >

                            <strong>B.</strong>

                            <?= esc($question['option_b']) ?>

                        </label>



                        <label class="option">

                            <input
                                type="radio"
                                name="answers[<?= $question['id'] ?>]"
                                value="C"
                            >

                            <strong>C.</strong>

                            <?= esc($question['option_c']) ?>

                        </label>



                        <label class="option">

                            <input
                                type="radio"
                                name="answers[<?= $question['id'] ?>]"
                                value="D"
                            >

                            <strong>D.</strong>

                            <?= esc($question['option_d']) ?>

                        </label>


                    </div>

                </div>

            </div>

        <?php endforeach; ?>



        <!-- =====================================================
             SUBMIT
        ====================================================== -->

        <div class="submit-section shadow-sm p-4 mb-5">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Ready to submit?
                    </h5>

                    <p class="text-muted mb-0">
                        Make sure you have answered all questions.
                    </p>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary px-4"
                    onclick="return confirm('Are you sure you want to submit the examination?');"
                >

                    <i class="bi bi-check-circle me-1"></i>

                    Submit Examination

                </button>

            </div>

        </div>


    </form>

</main>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>