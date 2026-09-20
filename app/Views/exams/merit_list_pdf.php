<?php

$examTitle = $exam['title'] ?? 'Examination';
$subject = $exam['subject'] ?? '-';

$examDate = '-';

if (!empty($exam['exam_date'])) {
    $examDate = date(
        'd M Y',
        strtotime($exam['exam_date'])
    );
}

$totalMarks = $exam['total_marks'] ?? 0;

$generatedDate = date(
    'd M Y, h:i A'
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Merit List - <?= esc($examTitle) ?>
    </title>

    <style>

        @page {
            margin: 35px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #212529;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #666;
            font-size: 11px;
        }

        .exam-box {
            border: 1px solid #d9dee3;
            padding: 12px;
            margin-bottom: 18px;
        }

        .exam-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .exam-info {
            width: 100%;
            border-collapse: collapse;
        }

        .exam-info td {
            padding: 3px 5px;
        }

        .label {
            font-weight: bold;
            width: 100px;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            border: 1px solid #d9dee3;
            padding: 8px;
            text-align: center;
        }

        .summary-number {
            font-size: 16px;
            font-weight: bold;
        }

        .summary-label {
            color: #666;
            font-size: 9px;
        }

        .merit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .merit-table th {
            background-color: #f1f3f5;
            border: 1px solid #cfd4da;
            padding: 8px 6px;
            font-weight: bold;
            text-align: center;
        }

        .merit-table td {
            border: 1px solid #d9dee3;
            padding: 7px 6px;
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .rank {
            font-weight: bold;
        }

        .student-name {
            font-weight: bold;
        }

        .email {
            color: #666;
            font-size: 9px;
        }

        .pass {
            color: #198754;
            font-weight: bold;
        }

        .fail {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            border-top: 1px solid #d9dee3;
            padding-top: 8px;
            color: #666;
            font-size: 9px;
        }

    </style>

</head>

<body>

    <div class="header">

        <div class="brand">
            EduQuiz
        </div>

        <div class="subtitle">
            Student Merit List
        </div>

    </div>


    <div class="exam-box">

        <div class="exam-title">
            <?= esc($examTitle) ?>
        </div>

        <table class="exam-info">

            <tr>

                <td class="label">
                    Subject
                </td>

                <td>
                    <?= esc($subject) ?>
                </td>

                <td class="label">
                    Exam Date
                </td>

                <td>
                    <?= esc($examDate) ?>
                </td>

            </tr>

            <tr>

                <td class="label">
                    Total Marks
                </td>

                <td>
                    <?= esc($totalMarks) ?>
                </td>

                <td class="label">
                    Generated
                </td>

                <td>
                    <?= esc($generatedDate) ?>
                </td>

            </tr>

        </table>

    </div>


    <?php

    $totalStudents = count($submissions);

    $passedStudents = 0;
    $failedStudents = 0;

    foreach ($submissions as $submission) {

        $status = strtolower(
            trim(
                $submission['result_status'] ?? ''
            )
        );

        if ($status === 'pass') {
            $passedStudents++;
        } else {
            $failedStudents++;
        }
    }

    ?>


    <table class="summary">

        <tr>

            <td>

                <div class="summary-number">
                    <?= esc($totalStudents) ?>
                </div>

                <div class="summary-label">
                    Submitted Students
                </div>

            </td>


            <td>

                <div class="summary-number">
                    <?= esc($passedStudents) ?>
                </div>

                <div class="summary-label">
                    Passed
                </div>

            </td>


            <td>

                <div class="summary-number">
                    <?= esc($failedStudents) ?>
                </div>

                <div class="summary-label">
                    Failed
                </div>

            </td>

        </tr>

    </table>


    <table class="merit-table">

        <thead>

            <tr>

                <th style="width: 7%;">
                    Rank
                </th>

                <th style="width: 27%;">
                    Student
                </th>

                <th style="width: 15%;">
                    Department
                </th>

                <th style="width: 10%;">
                    Score
                </th>

                <th style="width: 11%;">
                    Percentage
                </th>

                <th style="width: 10%;">
                    Result
                </th>

                <th style="width: 20%;">
                    Submitted At
                </th>

            </tr>

        </thead>


        <tbody>

            <?php if (!empty($submissions)): ?>

                <?php foreach ($submissions as $submission): ?>

                    <?php

                    $resultStatus = strtolower(
                        trim(
                            $submission['result_status'] ?? ''
                        )
                    );

                    $isPassed =
                        $resultStatus === 'pass';

                    $score =
                        $submission['score'] ?? 0;

                    $percentage =
                        $submission['percentage'] ?? 0;

                    $department =
                        trim(
                            $submission['department'] ?? ''
                        );

                    $submittedAt = '-';

                    if (
                        !empty(
                            $submission['submitted_at']
                        )
                    ) {
                        $submittedAt = date(
                            'd M Y, h:i A',
                            strtotime(
                                $submission['submitted_at']
                            )
                        );
                    }

                    ?>


                    <tr>

                        <td class="text-center">

                            <span class="rank">

                                #<?= esc(
                                    $submission['merit_rank']
                                ) ?>

                            </span>

                        </td>


                        <td class="text-left">

                            <div class="student-name">

                                <?= esc(
                                    $submission['name']
                                    ?? 'Student'
                                ) ?>

                            </div>

                            <div class="email">

                                <?= esc(
                                    $submission['email']
                                    ?? ''
                                ) ?>

                            </div>

                        </td>


                        <td class="text-center">

                            <?= !empty($department)
                                ? esc($department)
                                : '-' ?>

                        </td>


                        <td class="text-center">

                            <?= esc($score) ?>

                            /

                            <?= esc($totalMarks) ?>

                        </td>


                        <td class="text-center">

                            <?= esc($percentage) ?>%

                        </td>


                        <td class="text-center">

                            <?php if ($isPassed): ?>

                                <span class="pass">
                                    PASS
                                </span>

                            <?php else: ?>

                                <span class="fail">
                                    FAIL
                                </span>

                            <?php endif; ?>

                        </td>


                        <td class="text-center">

                            <?= esc($submittedAt) ?>

                        </td>

                    </tr>


                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td
                        colspan="7"
                        class="text-center">

                        No students submitted this examination.

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>


    <div class="footer">

        Generated by EduQuiz on
        <?= esc($generatedDate) ?>.

    </div>

</body>

</html>