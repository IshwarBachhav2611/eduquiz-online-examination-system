<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($exam['title']) ?> | EduQuiz
    </title>


    <!-- Bootstrap 5 -->
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
           NAVBAR
        ========================================================= */

        .exam-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }


        .exam-title {
            font-weight: 700;
            color: #0f172a;
        }


        /* =========================================================
           TIMER
        ========================================================= */

        .timer-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            min-width: 130px;
        }


        .timer {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #0f172a;
        }


        .timer-warning {
            color: #dc2626 !important;
        }


        /* =========================================================
           QUESTION CARD
        ========================================================= */

        .question-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            scroll-margin-top: 90px;
        }


        .question-number {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

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
           OPTIONS
        ========================================================= */

        .option-label {
            display: block;

            border: 1px solid #e2e8f0;
            border-radius: 10px;

            padding: 14px 16px;

            cursor: pointer;

            transition: all 0.15s ease;

            background: #ffffff;
        }


        .option-label:hover {
            border-color: #93c5fd;
            background: #f8fbff;
        }


        .option-input:checked + .option-label {
            border-color: #2563eb;
            background: #eff6ff;
        }


        .option-letter {
            width: 30px;
            height: 30px;

            border-radius: 8px;

            background: #f1f5f9;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;

            margin-right: 10px;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
        }


        .exam-info-item {
            color: #64748b;
            font-size: 14px;
        }


        .exam-info-item i {
            width: 20px;
        }


        /* =========================================================
           QUESTION NAVIGATION
        ========================================================= */

        .question-nav {
            width: 40px;
            height: 40px;

            border-radius: 9px;

            border: 1px solid #cbd5e1;

            background: #ffffff;
            color: #334155;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition: all 0.15s ease;
        }


        .question-nav:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #2563eb;
        }


        .question-nav.active {
            border-color: #2563eb;
            background: #2563eb;
            color: #ffffff;
        }


        .question-nav.answered {
            background: #dcfce7;
            border-color: #86efac;
            color: #166534;
        }


        .question-nav.active.answered {
            background: #16a34a;
            border-color: #16a34a;
            color: #ffffff;
        }


        /* =========================================================
           LEGEND
        ========================================================= */

        .legend-box {
            width: 16px;
            height: 16px;

            border-radius: 4px;

            display: inline-block;

            margin-right: 8px;
        }


        .legend-answered {
            background: #dcfce7;
            border: 1px solid #86efac;
        }


        .legend-not-answered {
            background: #ffffff;
            border: 1px solid #cbd5e1;
        }


        /* =========================================================
           SUBMIT
        ========================================================= */

        .submit-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 991px) {

            .sidebar-card {
                margin-top: 20px;
            }

        }

    </style>

</head>


<body>


<!-- =============================================================
     NAVBAR
============================================================= -->

<nav class="navbar exam-navbar">

    <div class="container py-2">

        <div>

            <div class="exam-title">
                <?= esc($exam['title']) ?>
            </div>

            <div class="small text-muted">
                <?= esc($exam['subject']) ?>
            </div>

        </div>


        <div class="d-flex align-items-center gap-3">

            <div class="timer-card px-3 py-2 text-center">

                <div class="small text-muted">
                    Time Remaining
                </div>

                <div
                    id="timer"
                    class="timer"
                >
                    --:--
                </div>

            </div>

        </div>

    </div>

</nav>



<!-- =============================================================
     MAIN
============================================================= -->

<main class="container py-4">

    <div class="row g-4">


        <!-- =====================================================
             QUESTIONS
        ====================================================== -->

        <div class="col-lg-8">


            <form
                id="examForm"
                method="post"
                action="<?= base_url('/student/exam/submit/' . $attemptId) ?>"
            >

                <?= csrf_field() ?>


                <?php foreach ($questions as $index => $question): ?>


                    <div
                        class="question-card p-4 mb-4"
                        id="question-<?= esc($index + 1) ?>"
                        data-question-number="<?= esc($index + 1) ?>"
                    >


                        <!-- Question Header -->

                        <div class="d-flex align-items-start gap-3 mb-4">

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



                        <!-- Options -->

                        <div class="d-grid gap-3">

                            <?php

                            $options = [
                                'A' => $question['option_a'],
                                'B' => $question['option_b'],
                                'C' => $question['option_c'],
                                'D' => $question['option_d']
                            ];

                            ?>


                            <?php foreach ($options as $letter => $option): ?>


                                <div>

                                    <input
                                        type="radio"
                                        class="btn-check option-input"
                                        name="answers[<?= esc($question['id']) ?>]"
                                        id="q<?= esc($question['id']) ?><?= esc($letter) ?>"
                                        value="<?= esc($letter) ?>"
                                        autocomplete="off"
                                    >


                                    <label
                                        class="option-label"
                                        for="q<?= esc($question['id']) ?><?= esc($letter) ?>"
                                    >

                                        <span class="option-letter">

                                            <?= esc($letter) ?>

                                        </span>

                                        <?= esc($option) ?>

                                    </label>

                                </div>


                            <?php endforeach; ?>

                        </div>


                    </div>


                <?php endforeach; ?>



                <!-- =================================================
                     SUBMIT CARD
                ================================================== -->

                <div class="submit-card p-4 mb-4">

                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                    >

                        <div>

                            <div class="fw-semibold">

                                Ready to submit?

                            </div>


                            <div class="small text-muted">

                                Answered:

                                <strong id="answeredCount">
                                    0
                                </strong>

                                /

                                <?= count($questions) ?>

                            </div>

                        </div>


                        <button
                            type="button"
                            id="submitButton"
                            class="btn btn-primary px-4"
                        >

                            <i class="bi bi-send me-2"></i>

                            Submit Examination

                        </button>

                    </div>

                </div>


            </form>

        </div>



        <!-- =====================================================
             SIDEBAR
        ====================================================== -->

        <div class="col-lg-4">


            <div
                class="sidebar-card p-4 sticky-lg-top"
                style="top: 20px;"
            >


                <!-- Examination Information -->

                <h6 class="fw-bold mb-3">

                    Examination Information

                </h6>


                <!-- Date -->

                <div class="exam-info-item mb-3">

                    <i class="bi bi-calendar3 me-2"></i>

                    <?= date(
                        'd M Y',
                        strtotime($exam['exam_date'])
                    ) ?>

                </div>


                <!-- Time -->

                <div class="exam-info-item mb-3">

                    <i class="bi bi-clock me-2"></i>

                    <?= date(
                        'h:i A',
                        strtotime($exam['start_time'])
                    ) ?>

                    <span class="mx-1">–</span>

                    <?= date(
                        'h:i A',
                        strtotime($exam['end_time'])
                    ) ?>

                </div>


                <!-- Duration -->

                <div class="exam-info-item mb-3">

                    <i class="bi bi-stopwatch me-2"></i>

                    <?= esc($exam['duration']) ?> minutes

                </div>


                <!-- Marks -->

                <div class="exam-info-item mb-4">

                    <i class="bi bi-award me-2"></i>

                    <?= esc($exam['total_marks']) ?> marks

                </div>


                <hr>



                <!-- =================================================
                     QUESTION NAVIGATION
                ================================================== -->

                <h6 class="fw-bold mb-3">

                    Questions

                </h6>


                <div
                    id="questionNavigation"
                    class="d-flex flex-wrap gap-2"
                >


                    <?php foreach ($questions as $index => $question): ?>


                        <a
                            href="#question-<?= esc($index + 1) ?>"
                            class="question-nav <?= $index === 0 ? 'active' : '' ?>"
                            data-question="<?= esc($question['id']) ?>"
                            data-target="question-<?= esc($index + 1) ?>"
                        >

                            <?= esc($index + 1) ?>

                        </a>


                    <?php endforeach; ?>


                </div>


                <hr class="my-4">



                <!-- =================================================
                     ANSWER SUMMARY
                ================================================== -->

                <div class="small text-muted">

                    <div class="mb-3">

                        <span
                            class="legend-box legend-answered"
                        ></span>

                        Answered

                        <strong
                            id="legendAnswered"
                            class="text-success"
                        >
                            0
                        </strong>

                    </div>


                    <div>

                        <span
                            class="legend-box legend-not-answered"
                        ></span>

                        Not answered

                        <strong
                            id="legendNotAnswered"
                            class="text-muted"
                        >
                            <?= count($questions) ?>
                        </strong>

                    </div>

                </div>


            </div>

        </div>


    </div>

</main>



<!-- =============================================================
     SUBMIT CONFIRMATION MODAL
============================================================= -->

<div
    class="modal fade"
    id="submitModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Submit Examination?

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">

                <p class="mb-2">

                    Are you sure you want to submit your examination?

                </p>


                <div
                    class="alert alert-info py-2 mb-0"
                >

                    <i class="bi bi-check-circle me-2"></i>

                    Answered:

                    <strong id="modalAnsweredCount">
                        0
                    </strong>

                    /

                    <?= count($questions) ?>

                </div>


                <p class="text-muted small mt-3 mb-0">

                    Once submitted, you cannot take this examination again.

                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light border"
                    data-bs-dismiss="modal"
                >

                    Continue Exam

                </button>


                <button
                    type="button"
                    id="confirmSubmit"
                    class="btn btn-primary"
                >

                    Yes, Submit

                </button>

            </div>


        </div>

    </div>

</div>



<!-- =============================================================
     TIME WARNING MODAL
============================================================= -->

<div
    class="modal fade"
    id="timeWarningModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center p-4">

                <i class="bi bi-clock-history text-danger display-5"></i>


                <h5 class="fw-bold mt-3">

                    Time Almost Over

                </h5>


                <p class="text-muted mb-0">

                    Less than 5 minutes remain.

                    Please review your answers and submit the examination.

                </p>

            </div>

        </div>

    </div>

</div>



<!-- =============================================================
     TIME EXPIRED MODAL
============================================================= -->

<div
    class="modal fade"
    id="timeExpiredModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center p-4">

                <i class="bi bi-hourglass-bottom text-danger display-5"></i>


                <h5 class="fw-bold mt-3">

                    Time Expired

                </h5>


                <p class="text-muted">

                    Your examination time has ended.

                    Your answers will now be submitted automatically.

                </p>


                <div class="spinner-border text-primary mb-2"></div>

            </div>

        </div>

    </div>

</div>



<!-- =============================================================
     BOOTSTRAP JAVASCRIPT
     
     IMPORTANT:
     Bootstrap MUST load BEFORE our custom JavaScript.
============================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>



<!-- =============================================================
     CUSTOM JAVASCRIPT
============================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const timerElement =
        document.getElementById('timer');

    const examForm =
        document.getElementById('examForm');

    const submitButton =
        document.getElementById('submitButton');

    const confirmSubmit =
        document.getElementById('confirmSubmit');

    const answeredCountElement =
        document.getElementById('answeredCount');

    const legendAnswered =
        document.getElementById('legendAnswered');

    const legendNotAnswered =
        document.getElementById('legendNotAnswered');

    const modalAnsweredCount =
        document.getElementById('modalAnsweredCount');


    /*
    |--------------------------------------------------------------------------
    | Questions
    |--------------------------------------------------------------------------
    */

    const totalQuestions =
        <?= count($questions) ?>;


    /*
    |--------------------------------------------------------------------------
    | Attempt end timestamp
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | We use a Unix timestamp generated by PHP.
    |
    | This avoids browser timezone/parsing problems.
    |--------------------------------------------------------------------------
    */

    const attemptEnd =
        <?= strtotime($attemptEnd) * 1000 ?>;


    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    let hasSubmitted = false;

    let warningShown = false;


    /*
    |--------------------------------------------------------------------------
    | Bootstrap modals
    |--------------------------------------------------------------------------
    */

    const submitModal =
        new bootstrap.Modal(
            document.getElementById('submitModal')
        );


    const timeWarningModal =
        new bootstrap.Modal(
            document.getElementById('timeWarningModal')
        );


    const timeExpiredModal =
        new bootstrap.Modal(
            document.getElementById('timeExpiredModal')
        );


    /*
    |--------------------------------------------------------------------------
    | Timer
    |--------------------------------------------------------------------------
    */

    function updateTimer() {


        const now =
            Date.now();


        const remaining =
            attemptEnd - now;


        /*
        |--------------------------------------------------------------------------
        | Expired
        |--------------------------------------------------------------------------
        */

        if (remaining <= 0) {


            timerElement.textContent =
                '00:00';


            timerElement.classList.add(
                'timer-warning'
            );


            if (!hasSubmitted) {


                hasSubmitted = true;


                clearInterval(timerInterval);


                timeExpiredModal.show();


                setTimeout(function () {

                    examForm.submit();

                }, 1500);

            }


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Convert time
        |--------------------------------------------------------------------------
        */

        const totalSeconds =
            Math.floor(
                remaining / 1000
            );


        const minutes =
            Math.floor(
                totalSeconds / 60
            );


        const seconds =
            totalSeconds % 60;


        timerElement.textContent =
            String(minutes).padStart(2, '0')
            + ':'
            + String(seconds).padStart(2, '0');


        /*
        |--------------------------------------------------------------------------
        | Warning
        |--------------------------------------------------------------------------
        */

        if (totalSeconds <= 300) {


            timerElement.classList.add(
                'timer-warning'
            );


            if (!warningShown) {


                warningShown = true;


                timeWarningModal.show();

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Start timer
    |--------------------------------------------------------------------------
    */

    updateTimer();


    const timerInterval =
        setInterval(
            updateTimer,
            1000
        );



    /*
    |--------------------------------------------------------------------------
    | Update answer status
    |--------------------------------------------------------------------------
    */

    function updateAnswerStatus() {


        const questionIds =
            new Set();


        document
            .querySelectorAll('.option-input:checked')
            .forEach(function (input) {


                const match =
                    input.name.match(
                        /answers\[(\d+)\]/
                    );


                if (match) {

                    questionIds.add(
                        match[1]
                    );

                }

            });


        const answered =
            questionIds.size;


        const notAnswered =
            totalQuestions - answered;


        /*
        |--------------------------------------------------------------------------
        | Update counters
        |--------------------------------------------------------------------------
        */

        answeredCountElement.textContent =
            answered;


        legendAnswered.textContent =
            answered;


        legendNotAnswered.textContent =
            notAnswered;


        modalAnsweredCount.textContent =
            answered;


        /*
        |--------------------------------------------------------------------------
        | Update navigation
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.question-nav')
            .forEach(function (navigationButton) {


                const questionId =
                    navigationButton.dataset.question;


                if (
                    questionIds.has(
                        questionId
                    )
                ) {

                    navigationButton.classList.add(
                        'answered'
                    );

                } else {

                    navigationButton.classList.remove(
                        'answered'
                    );

                }

            });

    }



    /*
    |--------------------------------------------------------------------------
    | Option change
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.option-input')
        .forEach(function (input) {


            input.addEventListener(
                'change',
                function () {

                    updateAnswerStatus();

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Question navigation
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.question-nav')
        .forEach(function (button) {


            button.addEventListener(
                'click',
                function (event) {


                    event.preventDefault();


                    const targetId =
                        this.dataset.target;


                    const target =
                        document.getElementById(
                            targetId
                        );


                    if (target) {


                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });


                        /*
                        |--------------------------------------------------------------------------
                        | Active question
                        |--------------------------------------------------------------------------
                        */

                        document
                            .querySelectorAll('.question-nav')
                            .forEach(function (nav) {

                                nav.classList.remove(
                                    'active'
                                );

                            });


                        this.classList.add(
                            'active'
                        );

                    }

                }
            );

        });



    /*
    |--------------------------------------------------------------------------
    | Detect currently visible question
    |--------------------------------------------------------------------------
    */

    const questionCards =
        document.querySelectorAll(
            '.question-card'
        );


    const observer =
        new IntersectionObserver(
            function (entries) {


                entries.forEach(function (entry) {


                    if (
                        entry.isIntersecting
                    ) {


                        const questionNumber =
                            entry.target.dataset.questionNumber;


                        document
                            .querySelectorAll('.question-nav')
                            .forEach(function (nav) {

                                nav.classList.remove(
                                    'active'
                                );

                            });


                        const activeNav =
                            document.querySelector(
                                '.question-nav[data-target="question-'
                                + questionNumber
                                + '"]'
                            );


                        if (activeNav) {

                            activeNav.classList.add(
                                'active'
                            );

                        }

                    }

                });

            },
            {
                threshold: 0.45
            }
        );


    questionCards.forEach(function (card) {

        observer.observe(card);

    });



    /*
    |--------------------------------------------------------------------------
    | Submit button
    |--------------------------------------------------------------------------
    */

    submitButton.addEventListener(
        'click',
        function () {


            if (hasSubmitted) {

                return;

            }


            updateAnswerStatus();


            submitModal.show();

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Confirm submit
    |--------------------------------------------------------------------------
    */

    confirmSubmit.addEventListener(
        'click',
        function () {


            if (hasSubmitted) {

                return;

            }


            hasSubmitted = true;


            clearInterval(
                timerInterval
            );


            confirmSubmit.disabled =
                true;


            submitButton.disabled =
                true;


            confirmSubmit.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>'
                + 'Submitting...';


            /*
            |--------------------------------------------------------------------------
            | Actually submit form
            |--------------------------------------------------------------------------
            */

            examForm.submit();

        }
    );



    /*
    |--------------------------------------------------------------------------
    | Initial answer state
    |--------------------------------------------------------------------------
    */

    updateAnswerStatus();



    /*
    |--------------------------------------------------------------------------
    | Prevent accidental exit
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeunload',
        function (event) {


            if (!hasSubmitted) {


                event.preventDefault();

                event.returnValue = '';

            }

        }
    );

});

</script>


</body>

</html>