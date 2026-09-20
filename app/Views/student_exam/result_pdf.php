<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Examination Result | EduQuiz</title>

    <style>
        @page {
            margin: 35px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #172033;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #123b7a;
        }

        .subtitle {
            color: #667085;
            font-size: 11px;
            margin-top: 4px;
        }

        .result-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .result-title h1 {
            margin: 0;
            font-size: 22px;
            color: #172033;
        }

        .result-title p {
            margin-top: 6px;
            color: #667085;
        }

        .status {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .pass {
            color: #16a34a;
        }

        .fail {
            color: #dc2626;
        }

        .student-box {
            border: 1px solid #d9e0ea;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #123b7a;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            border-bottom: 1px solid #edf0f4;
            padding: 8px 5px;
        }

        .details td:first-child {
            width: 35%;
            font-weight: bold;
            color: #475467;
        }

        .score-box {
            border: 1px solid #d9e0ea;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .score {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #123b7a;
            margin-bottom: 5px;
        }

        .score-label {
            text-align: center;
            color: #667085;
            margin-bottom: 15px;
        }

        .statistics td {
            width: 25%;
            text-align: center;
            border: 1px solid #e4e7ec;
            padding: 12px 5px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 10px;
            color: #667085;
        }

        .green {
            color: #16a34a;
        }

        .red {
            color: #dc2626;
        }

        .blue {
            color: #123b7a;
        }

        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #d9e0ea;
            text-align: center;
            font-size: 9px;
            color: #667085;
        }

        .notice {
            background: #f5f8ff;
            border: 1px solid #d9e5ff;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            color: #475467;
            line-height: 1.5;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="brand">EduQuiz</div>
        <div class="subtitle">
            Online Examination and Assessment System
        </div>
    </div>

    <div class="result-title">
        <h1>Examination Result</h1>

        <p>
            Official examination performance report
        </p>
    </div>

    <div class="status <?= strtoupper($status) === 'PASS' ? 'pass' : 'fail' ?>">
        <?= esc(strtoupper($status)) ?>
    </div>

    <div class="student-box">

        <div class="section-title">
            Student Information
        </div>

        <table class="details">

            <tr>
                <td>Student Name</td>
                <td><?= esc($studentName) ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td><?= esc($studentEmail) ?></td>
            </tr>

        </table>

    </div>

    <div class="student-box">

        <div class="section-title">
            Examination Information
        </div>

        <table class="details">

            <tr>
                <td>Examination</td>
                <td><?= esc($exam['title']) ?></td>
            </tr>

            <tr>
                <td>Subject</td>
                <td><?= esc($exam['subject']) ?></td>
            </tr>

            <tr>
                <td>Exam Date</td>
                <td><?= esc($exam['exam_date']) ?></td>
            </tr>

            <tr>
                <td>Duration</td>
                <td><?= esc($exam['duration']) ?> minutes</td>
            </tr>

            <tr>
                <td>Total Marks</td>
                <td><?= esc($exam['total_marks']) ?></td>
            </tr>

            <tr>
                <td>Passing Marks</td>
                <td><?= esc($exam['passing_marks']) ?></td>
            </tr>

        </table>

    </div>

    <div class="score-box">

        <div class="section-title">
            Result Summary
        </div>

        <div class="score">
            <?= esc(number_format((float) $score, 2)) ?>
            /
            <?= esc($exam['total_marks']) ?>
        </div>

        <div class="score-label">
            Marks Obtained
        </div>

        <table class="statistics">

            <tr>

                <td>
                    <div class="stat-number blue">
                        <?= esc(number_format((float) $percentage, 2)) ?>%
                    </div>

                    <div class="stat-label">
                        Percentage
                    </div>
                </td>

                <td>
                    <div class="stat-number green">
                        <?= esc($correctCount) ?>
                    </div>

                    <div class="stat-label">
                        Correct Answers
                    </div>
                </td>

                <td>
                    <div class="stat-number red">
                        <?= esc($wrongCount) ?>
                    </div>

                    <div class="stat-label">
                        Wrong Answers
                    </div>
                </td>

                <td>
                    <div class="stat-number blue">
                        <?= esc($notAnsweredCount) ?>
                    </div>

                    <div class="stat-label">
                        Not Answered
                    </div>
                </td>

            </tr>

        </table>

    </div>

    <div class="notice">

        This document is an electronically generated examination
        result from the EduQuiz Online Examination and Assessment
        System. No physical signature is required.

    </div>

    <div class="footer">

        EduQuiz &nbsp; | &nbsp;
        Examination Result Report
        <br>

        Generated on:
        <?= date('d M Y, h:i A') ?>

    </div>

</body>
</html>