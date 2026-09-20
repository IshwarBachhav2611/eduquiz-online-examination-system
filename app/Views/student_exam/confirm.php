<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($exam['title']) ?> | Examination
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f7fb;
            font-family: Arial, sans-serif;
            color: #172033;
        }

        .exam-overlay {
            min-height: 100vh;
            padding: 40px 20px;
            background: rgba(15, 23, 42, 0.58);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .exam-modal {
            width: 100%;
            max-width: 950px;
            max-height: 92vh;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 25px 70px rgba(15, 23, 42, 0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header-custom {
            padding: 24px 30px;
            border-bottom: 1px solid #e5eaf1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .exam-heading {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .exam-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #eaf2ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .exam-heading h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .exam-heading p {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .close-btn {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 10px;
            background: #f4f6f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .close-btn:hover {
            background: #e9edf3;
            color: #172033;
        }

        .modal-body-custom {
            padding: 28px 30px;
            overflow-y: auto;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .detail-box {
            border: 1px solid #e3e8ef;
            background: #f9fbfd;
            border-radius: 12px;
            padding: 16px;
        }

        .detail-label {
            display: block;
            color: #7b8494;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .detail-value {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #172033;
        }

        .detail-value i {
            color: #0d6efd;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #172033;
        }

        .section-title i {
            color: #0d6efd;
            margin-right: 7px;
        }

        .description-box {
            background: #f8fafc;
            border: 1px solid #e5eaf0;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
        }

        .description-text {
            margin: 0;
            color: #566174;
            font-size: 14px;
            line-height: 1.75;
            white-space: pre-line;
        }

        .instructions-box {
            background: #fff;
            border: 1px solid #e5eaf0;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
        }

        .instructions-text {
            margin: 0;
            color: #566174;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .warning-box {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fff8e6;
            border: 1px solid #ffe2a8;
            border-radius: 12px;
            padding: 15px 17px;
            margin-top: 5px;
        }

        .warning-icon {
            color: #d88900;
            font-size: 19px;
        }

        .warning-box strong {
            display: block;
            color: #7a5200;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .warning-box span {
            color: #806a42;
            font-size: 13px;
            line-height: 1.5;
        }

        .modal-footer-custom {
            padding: 18px 30px;
            border-top: 1px solid #e5eaf1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            min-width: 110px;
            border: 1px solid #d9dee7;
            background: #fff;
            color: #4b5563;
            padding: 10px 18px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-cancel:hover {
            background: #f5f7fa;
        }

        .btn-start {
            min-width: 230px;
            border: 0;
            background: #0d6efd;
            color: #fff;
            padding: 11px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-start:hover {
            background: #0b5ed7;
        }

        @media (max-width: 900px) {

            .details-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 600px) {

            .exam-overlay {
                padding: 15px;
            }

            .exam-modal {
                max-height: 95vh;
                border-radius: 14px;
            }

            .modal-header-custom {
                padding: 18px;
            }

            .modal-body-custom {
                padding: 20px 18px;
            }

            .modal-footer-custom {
                padding: 15px 18px;
                flex-direction: column-reverse;
            }

            .btn-cancel,
            .btn-start {
                width: 100%;
            }

            .details-grid {
                grid-template-columns: 1fr 1fr;
            }

        }

    </style>

</head>

<body>

<div class="exam-overlay">

    <div class="exam-modal">

        <!-- Header -->
        <div class="modal-header-custom">

            <div class="exam-heading">

                <div class="exam-icon">
                    <i class="bi bi-journal-text"></i>
                </div>

                <div>

                    <h4>
                        <?= esc($exam['title']) ?>
                    </h4>

                    <p>
                        <?= esc($exam['subject']) ?>
                    </p>

                </div>

            </div>

            <a
                href="<?= base_url('/student/exams') ?>"
                class="close-btn text-decoration-none"
                title="Go Back"
            >
                <i class="bi bi-x-lg"></i>
            </a>

        </div>


        <!-- Body -->
        <div class="modal-body-custom">

            <!-- Examination Details -->
            <div class="details-grid">

                <div class="detail-box">

                    <span class="detail-label">
                        Examination Date
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-calendar3"></i>

                        <?= date(
                            'd M Y',
                            strtotime($exam['exam_date'])
                        ) ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Examination Time
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-clock"></i>

                        <?= date(
                            'h:i A',
                            strtotime($exam['start_time'])
                        ) ?>

                        -

                        <?= date(
                            'h:i A',
                            strtotime($exam['end_time'])
                        ) ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Duration
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-stopwatch"></i>

                        <?= esc($exam['duration']) ?>
                        minutes

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Total Questions
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-list-ol"></i>

                        <?= esc($questionCount) ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Total Marks
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-award"></i>

                        <?= esc($exam['total_marks']) ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Passing Marks
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-check-circle"></i>

                        <?= esc($exam['passing_marks']) ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Negative Marking
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-dash-circle"></i>

                        <?= !empty($exam['negative_marking'])
                            ? 'Yes'
                            : 'No'
                        ?>

                    </div>

                </div>


                <div class="detail-box">

                    <span class="detail-label">
                        Attempts Allowed
                    </span>

                    <div class="detail-value">

                        <i class="bi bi-arrow-repeat"></i>

                        1 Attempt

                    </div>

                </div>

            </div>


            <!-- Description -->
            <div>

                <div class="section-title">

                    <i class="bi bi-info-circle"></i>

                    Examination Description

                </div>

                <div class="description-box">

                    <p class="description-text">
                        <?= esc(
                            $exam['description']
                            ?? 'No description has been provided for this examination.'
                        ) ?>
                    </p>

                </div>

            </div>


            <!-- Instructions -->
            <div>

                <div class="section-title">

                    <i class="bi bi-list-check"></i>

                    Examination Instructions

                </div>

                <div class="instructions-box">

                    <p class="instructions-text">
                        <?= esc(
                            $exam['instructions']
                            ?? 'No additional instructions have been provided for this examination.'
                        ) ?>
                    </p>

                </div>

            </div>


            <!-- Warning -->
            <div class="warning-box">

                <div class="warning-icon">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                </div>

                <div>

                    <strong>
                        Important
                    </strong>

                    <span>
                        Your examination attempt and timer will begin
                        only after you click
                        <strong>
                            "I Understand & Start Examination"
                        </strong>.
                        Once started, the examination cannot be restarted
                        or attempted again.
                    </span>

                </div>

            </div>

        </div>


        <!-- Footer -->
        <div class="modal-footer-custom">

            <a
                href="<?= base_url('/student/exams') ?>"
                class="btn-cancel text-decoration-none text-center"
            >
                Cancel
            </a>


            <form
                method="post"
                action="<?= base_url('/student/exam/begin/' . $exam['id']) ?>"
            >

                <?= csrf_field() ?>

                <button
                    type="submit"
                    class="btn-start"
                >

                    <i class="bi bi-play-circle me-2"></i>

                    I Understand & Start Examination

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>