<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Examination Result | EduQuiz
    </title>


    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        body {
            background: #f8fafc;
            color: #1e293b;
        }


        /* =========================================================
           MAIN CONTAINER
        ========================================================= */

        .result-wrapper {
            max-width: 1050px;
            margin: 40px auto;
        }


        /* =========================================================
           RESULT HEADER
        ========================================================= */

        .result-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
        }


        .result-icon {
            width: 72px;
            height: 72px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 20px;

            font-size: 34px;
        }


        .result-icon.pass {
            background: #d1fae5;
            color: #059669;
        }


        .result-icon.fail {
            background: #fee2e2;
            color: #dc2626;
        }


        .result-title {
            font-size: 30px;
            font-weight: 700;
            color: #0f172a;
        }


        .exam-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }


        /* =========================================================
           SCORE
        ========================================================= */

        .score {
            font-size: 58px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }


        .score-total {
            font-size: 20px;
            color: #64748b;
        }


        /* =========================================================
           STAT CARDS
        ========================================================= */

        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            height: 100%;
        }


        .stat-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 5px;
        }


        .stat-value {
            font-size: 25px;
            font-weight: 700;
        }


        .stat-value.correct {
            color: #16a34a;
        }


        .stat-value.wrong {
            color: #dc2626;
        }


        .stat-value.unanswered {
            color: #64748b;
        }


        /* =========================================================
           ACTIONS
        ========================================================= */

        .action-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
        }


        /* =========================================================
           REVIEW SECTION
        ========================================================= */

        .review-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;

            scroll-margin-top: 30px;
        }


        .question-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }


        .question-number {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;
            color: #2563eb;

            font-weight: 700;

            flex-shrink: 0;
        }


        .question-text {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.6;
            color: #0f172a;
        }


        /* =========================================================
           ANSWER BOX
        ========================================================= */

        .answer-box {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }


        .answer-box.correct {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }


        .answer-box.wrong {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }


        .answer-box.unanswered {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }


        .answer-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 5px;
        }


        .answer-text {
            font-size: 15px;
            color: #0f172a;
        }


        .answer-status {
            font-weight: 700;
        }


        .answer-status.correct {
            color: #16a34a;
        }


        .answer-status.wrong {
            color: #dc2626;
        }


        .answer-status.unanswered {
            color: #64748b;
        }


        .marks {
            font-weight: 700;
            font-size: 14px;
        }


        /* =========================================================
           PRINT
        ========================================================= */

        @media print {

            body {
                background: #ffffff;
            }


            .no-print {
                display: none !important;
            }


            .result-wrapper {
                margin: 0;
                max-width: 100%;
            }


            .result-card,
            .review-card {
                box-shadow: none !important;
                break-inside: avoid;
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 576px) {

            .result-wrapper {
                margin: 20px 10px;
            }


            .result-title {
                font-size: 25px;
            }


            .score {
                font-size: 48px;
            }

        }

    </style>

</head>


<body>


<div class="container result-wrapper">


    <!-- =========================================================
         RESULT SUMMARY
    ========================================================== -->

    <div class="result-card shadow-sm p-4 p-md-5 mb-4">

        <?php
            $isPassed =
                isset($result['status']) &&
                $result['status'] === 'Pass';
        ?>


        <!-- Result Icon -->

        <div
            class="result-icon <?= $isPassed ? 'pass' : 'fail' ?>"
        >

            <?php if ($isPassed): ?>

                <i class="bi bi-check-lg"></i>

            <?php else: ?>

                <i class="bi bi-x-lg"></i>

            <?php endif; ?>

        </div>


        <!-- Result Title -->

        <div class="text-center">

            <div class="result-title mb-2">

                <?= $isPassed
                    ? 'Congratulations!'
                    : 'Examination Completed'
                ?>

            </div>


            <p class="text-muted mb-4">

                <?php if ($isPassed): ?>

                    You have passed the examination.

                <?php else: ?>

                    You did not pass the examination.

                <?php endif; ?>

            </p>


            <!-- Exam -->

            <div class="exam-title">

                <?= esc($exam['title']) ?>

            </div>


            <div class="text-muted mb-4">

                <?= esc($exam['subject']) ?>

            </div>


            <!-- Score -->

            <div class="mb-4">

                <span class="score">

                    <?= esc($attempt['score'] ?? 0) ?>

                </span>

                <span class="score-total">

                    /
                    <?= esc($exam['total_marks']) ?>

                </span>


                <div class="text-muted mt-2">

                    Total Score

                </div>

            </div>

        </div>



        <!-- =====================================================
             STATISTICS
        ====================================================== -->

        <div class="row g-3 mb-4">


            <!-- Percentage -->

            <div class="col-md-3">

                <div class="stat-card">

                    <div class="stat-label">

                        Percentage

                    </div>

                    <div class="stat-value">

                        <?= esc(
                            $attempt['percentage'] ?? 0
                        ) ?>%

                    </div>

                </div>

            </div>


            <!-- Correct -->

            <div class="col-md-3">

                <div class="stat-card">

                    <div class="stat-label">

                        Correct Answers

                    </div>

                    <div class="stat-value correct">

                        <?= esc($correctCount) ?>

                    </div>

                </div>

            </div>


            <!-- Wrong -->

            <div class="col-md-3">

                <div class="stat-card">

                    <div class="stat-label">

                        Wrong Answers

                    </div>

                    <div class="stat-value wrong">

                        <?= esc($wrongCount) ?>

                    </div>

                </div>

            </div>


            <!-- Not Answered -->

            <div class="col-md-3">

                <div class="stat-card">

                    <div class="stat-label">

                        Not Answered

                    </div>

                    <div class="stat-value unanswered">

                        <?= esc($notAnsweredCount) ?>

                    </div>

                </div>

            </div>

        </div>



        <!-- =====================================================
             EXTRA INFORMATION
        ====================================================== -->

        <div class="row text-center text-muted small">

            <div class="col-md-4 mb-2">

                <i class="bi bi-award me-1"></i>

                Passing Marks:

                <strong class="text-dark">

                    <?= esc($exam['passing_marks']) ?>

                </strong>

            </div>


            <div class="col-md-4 mb-2">

                <i class="bi bi-calendar3 me-1"></i>

                <?= date(
                    'd M Y',
                    strtotime($exam['exam_date'])
                ) ?>

            </div>


            <div class="col-md-4 mb-2">

                <i class="bi bi-clock me-1"></i>

                Submitted:

                <strong class="text-dark">

                    <?= date(
                        'd M Y, h:i A',
                        strtotime($attempt['submitted_at'])
                    ) ?>

                </strong>

            </div>

        </div>

    </div>



    <!-- =========================================================
         ACTION BUTTONS
    ========================================================== -->

    <div class="action-card shadow-sm p-3 mb-4 no-print">

        <div class="row g-2">


            <!-- See Exam -->

            <div class="col-md-4">

                <a
                    href="#answerReview"
                    class="btn btn-primary w-100"
                >

                    <i class="bi bi-eye me-2"></i>

                    See Exam

                </a>

            </div>


            <!-- Download Result -->

            <div class="col-md-4">

                <button
                    type="button"
                    class="btn btn-outline-primary w-100"
                    onclick="window.print()"
                >

                    <i class="bi bi-download me-2"></i>

                    Download Result

                </button>

            </div>


            <!-- Back -->

            <div class="col-md-4">

                <a
                    href="<?= base_url('/student/exams') ?>"
                    class="btn btn-outline-secondary w-100"
                >

                    <i class="bi bi-arrow-left me-2"></i>

                    Back to My Exams

                </a>

            </div>


        </div>

    </div>



    <!-- =========================================================
         ANSWER REVIEW
    ========================================================== -->

    <div
        id="answerReview"
        class="mb-4"
    >

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h4 class="fw-bold mb-1">

                    Exam Review

                </h4>

                <div class="text-muted small">

                    Review your answers and the correct answers.

                </div>

            </div>

        </div>



        <?php foreach ($questions as $index => $question): ?>


            <?php

                $questionId =
                    $question['id'];

                $studentAnswer =
                    $answersByQuestion[$questionId]
                    ?? null;


                $selectedOption =
                    $studentAnswer['selected_option']
                    ?? null;


                $correctOption =
                    $question['correct_option'];


                $isAnswered =
                    $selectedOption !== null &&
                    $selectedOption !== '';


                $isCorrect =
                    $isAnswered &&
                    $selectedOption === $correctOption;


                if ($isCorrect) {

                    $statusClass = 'correct';

                } elseif ($isAnswered) {

                    $statusClass = 'wrong';

                } else {

                    $statusClass = 'unanswered';

                }


                $options = [

                    'A' => $question['option_a'],

                    'B' => $question['option_b'],

                    'C' => $question['option_c'],

                    'D' => $question['option_d']

                ];

            ?>


            <div
                class="review-card shadow-sm p-4 mb-4"
            >


                <!-- Question Header -->

                <div
                    class="question-header d-flex align-items-start gap-3"
                >

                    <div class="question-number">

                        <?= esc($index + 1) ?>

                    </div>


                    <div class="flex-grow-1">

                        <div class="small text-muted mb-1">

                            Question
                            <?= esc($index + 1) ?>

                            of

                            <?= count($questions) ?>

                        </div>


                        <div class="question-text">

                            <?= esc($question['question']) ?>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     ALL OPTIONS
                ================================================== -->

                <div class="mb-3">


                    <?php foreach ($options as $letter => $option): ?>


                        <?php

                            $optionIsCorrect =
                                $letter === $correctOption;

                            $optionWasSelected =
                                $letter === $selectedOption;

                        ?>


                        <div
                            class="border rounded-3 p-3 mb-2
                            <?php
                                if ($optionIsCorrect) {
                                    echo 'border-success bg-success-subtle';
                                } elseif ($optionWasSelected) {
                                    echo 'border-danger bg-danger-subtle';
                                }
                            ?>"
                        >

                            <div
                                class="d-flex align-items-start gap-2"
                            >

                                <strong>

                                    <?= esc($letter) ?>.

                                </strong>


                                <span class="flex-grow-1">

                                    <?= esc($option) ?>

                                </span>


                                <?php if ($optionIsCorrect): ?>

                                    <span
                                        class="badge text-bg-success"
                                    >

                                        Correct Answer

                                    </span>

                                <?php elseif ($optionWasSelected): ?>

                                    <span
                                        class="badge text-bg-danger"
                                    >

                                        Your Answer

                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>


                    <?php endforeach; ?>


                </div>



                <!-- =================================================
                     RESULT FOR QUESTION
                ================================================== -->

                <?php if ($isCorrect): ?>


                    <div class="answer-box correct">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="answer-label">

                                    Your Answer

                                </div>


                                <div class="answer-text">

                                    <?= esc($selectedOption) ?>.

                                    <?= esc(
                                        $options[$selectedOption]
                                    ) ?>

                                </div>

                            </div>


                            <div class="text-end">

                                <div
                                    class="answer-status correct"
                                >

                                    <i class="bi bi-check-circle me-1"></i>

                                    Correct

                                </div>


                                <div class="marks text-success">

                                    +
                                    <?= esc(
                                        $studentAnswer['marks_obtained']
                                        ?? $question['marks']
                                    ) ?>

                                    marks

                                </div>

                            </div>

                        </div>

                    </div>


                <?php elseif ($isAnswered): ?>


                    <div class="answer-box wrong">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="answer-label">

                                    Your Answer

                                </div>


                                <div class="answer-text">

                                    <?= esc($selectedOption) ?>.

                                    <?= esc(
                                        $options[$selectedOption]
                                    ) ?>

                                </div>

                            </div>


                            <div class="text-end">

                                <div
                                    class="answer-status wrong"
                                >

                                    <i class="bi bi-x-circle me-1"></i>

                                    Wrong

                                </div>


                                <div class="marks text-danger">

                                    <?= esc(
                                        $studentAnswer['marks_obtained']
                                        ?? 0
                                    ) ?>

                                    marks

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="answer-box correct">

                        <div class="answer-label">

                            Correct Answer

                        </div>


                        <div class="answer-text">

                            <strong>

                                <?= esc($correctOption) ?>.

                            </strong>

                            <?= esc(
                                $options[$correctOption]
                            ) ?>

                        </div>

                    </div>


                <?php else: ?>


                    <div class="answer-box unanswered">

                        <div class="d-flex justify-content-between">

                            <div>

                                <div class="answer-label">

                                    Your Answer

                                </div>


                                <div class="answer-text">

                                    Not Answered

                                </div>

                            </div>


                            <div class="text-end">

                                <div
                                    class="answer-status unanswered"
                                >

                                    <i class="bi bi-dash-circle me-1"></i>

                                    Not Answered

                                </div>


                                <div class="marks text-muted">

                                    0 marks

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="answer-box correct">

                        <div class="answer-label">

                            Correct Answer

                        </div>


                        <div class="answer-text">

                            <strong>

                                <?= esc($correctOption) ?>.

                            </strong>

                            <?= esc(
                                $options[$correctOption]
                            ) ?>

                        </div>

                    </div>


                <?php endif; ?>


            </div>


        <?php endforeach; ?>


    </div>



    <!-- =========================================================
         BOTTOM ACTIONS
    ========================================================== -->

    <div class="text-center pb-5 no-print">

        <a
            href="<?= base_url('/student/exams') ?>"
            class="btn btn-primary px-4"
        >

            <i class="bi bi-grid me-2"></i>

            Back to My Exams

        </a>

    </div>


</div>


</body>

</html>