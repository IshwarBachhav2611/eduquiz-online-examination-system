<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\ExamStudentModel;
use App\Models\AttemptModel;

class StudentExamListController extends BaseController
{
    protected $examModel;
    protected $examStudentModel;
    protected $attemptModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
        $this->examStudentModel = new ExamStudentModel();
        $this->attemptModel = new AttemptModel();
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Check student login
        |--------------------------------------------------------------------------
        */

        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()
                ->to('/student/login')
                ->with('error', 'Please login first.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get all examinations assigned to this student
        |--------------------------------------------------------------------------
        */

        $assignments = $this->examStudentModel
            ->where('student_id', $studentId)
            ->findAll();


        $exams = [];


        /*
        |--------------------------------------------------------------------------
        | Process each assigned examination
        |--------------------------------------------------------------------------
        */

        foreach ($assignments as $assignment) {

            $exam = $this->examModel
                ->where('id', $assignment['exam_id'])
                ->where('status', 'Published')
                ->first();


            if (!$exam) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Find student's latest attempt for this examination
            |--------------------------------------------------------------------------
            */

            $attempt = $this->attemptModel
                ->where('exam_id', $exam['id'])
                ->where('student_id', $studentId)
                ->orderBy('id', 'DESC')
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Determine examination status
            |--------------------------------------------------------------------------
            */

            $status = $this->getExamStatus(
                $exam,
                $attempt
            );


            /*
            |--------------------------------------------------------------------------
            | Add student-specific information
            |--------------------------------------------------------------------------
            */

            $exam['student_status'] = $status['status'];

            $exam['status_label'] = $status['label'];

            $exam['status_class'] = $status['class'];

            $exam['action'] = $status['action'];

            $exam['attempt_id'] =
                $attempt['id'] ?? null;

            $exam['score'] =
                $attempt['score'] ?? null;

            $exam['percentage'] =
                $attempt['percentage'] ?? null;

            $exam['submitted_at'] =
                $attempt['submitted_at'] ?? null;


            $exams[] = $exam;
        }


        /*
        |--------------------------------------------------------------------------
        | Sort Examinations by Importance
        |--------------------------------------------------------------------------
        |
        | Priority:
        |
        | 1. In Progress
        | 2. Start Now
        | 3. Waiting
        | 4. Completed
        | 5. Not Attempted
        |
        | Waiting examinations are additionally sorted by
        | their scheduled date and start time.
        |
        |--------------------------------------------------------------------------
        */

        $statusPriority = [
            'in_progress' => 1,
            'available'   => 2,
            'waiting'     => 3,
            'completed'   => 4,
            'not_attempted' => 5
        ];


        usort($exams, function ($a, $b) use ($statusPriority) {

            /*
            |--------------------------------------------------------------------------
            | Compare Status Priority
            |--------------------------------------------------------------------------
            */

            $priorityA =
                $statusPriority[$a['student_status']] ?? 99;

            $priorityB =
                $statusPriority[$b['student_status']] ?? 99;


            if ($priorityA !== $priorityB) {

                return $priorityA <=> $priorityB;
            }


            /*
            |--------------------------------------------------------------------------
            | For Waiting Exams:
            | Sort by nearest examination date/time
            |--------------------------------------------------------------------------
            */

            if (
                $a['student_status'] === 'waiting' &&
                $b['student_status'] === 'waiting'
            ) {

                $dateTimeA =
                    strtotime(
                        $a['exam_date'] . ' ' . $a['start_time']
                    );

                $dateTimeB =
                    strtotime(
                        $b['exam_date'] . ' ' . $b['start_time']
                    );


                return $dateTimeA <=> $dateTimeB;
            }


            /*
            |--------------------------------------------------------------------------
            | For Other Statuses:
            | Keep their existing order
            |--------------------------------------------------------------------------
            */

            return 0;
        });


        /*
        |--------------------------------------------------------------------------
        | Send examinations to view
        |--------------------------------------------------------------------------
        */

        return view('student/exams', [
            'exams' => $exams
        ]);
    }


    /**
     * Determine the student's current examination status.
     */
    private function getExamStatus(
        array $exam,
        ?array $attempt
    ): array {

        /*
        |--------------------------------------------------------------------------
        | 1. Completed
        |--------------------------------------------------------------------------
        |
        | If the student already submitted the examination,
        | they cannot take it again.
        |
        */

        if (
            $attempt &&
            in_array(
                $attempt['status'],
                ['Submitted', 'Auto Submitted'],
                true
            )
        ) {

            return [
                'status' => 'completed',
                'label' => 'Completed',
                'class' => 'success',
                'action' => 'result'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 2. In Progress
        |--------------------------------------------------------------------------
        |
        | The student has started the examination but
        | has not submitted it yet.
        |
        */

        if (
            $attempt &&
            $attempt['status'] === 'Started'
        ) {

            return [
                'status' => 'in_progress',
                'label' => 'In Progress',
                'class' => 'warning',
                'action' => 'continue'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 3. India timezone
        |--------------------------------------------------------------------------
        */

        $timezone = new \DateTimeZone(
            'Asia/Kolkata'
        );


        /*
        |--------------------------------------------------------------------------
        | 4. Current date and time
        |--------------------------------------------------------------------------
        */

        $now = new \DateTime(
            'now',
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | 5. Examination date
        |--------------------------------------------------------------------------
        */

        $examDate = $exam['exam_date'];


        /*
        |--------------------------------------------------------------------------
        | 6. Examination start date/time
        |--------------------------------------------------------------------------
        */

        $startDateTime = new \DateTime(
            $examDate . ' ' . $exam['start_time'],
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | 7. Examination end date/time
        |--------------------------------------------------------------------------
        */

        $endDateTime = new \DateTime(
            $examDate . ' ' . $exam['end_time'],
            $timezone
        );


        /*
        |--------------------------------------------------------------------------
        | 8. Waiting
        |--------------------------------------------------------------------------
        |
        | Examination hasn't started yet.
        |
        */

        if ($now < $startDateTime) {

            return [
                'status' => 'waiting',
                'label' => 'Waiting',
                'class' => 'secondary',
                'action' => 'disabled'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 9. Start Now
        |--------------------------------------------------------------------------
        |
        | Examination is currently open and the student
        | has never attempted it.
        |
        */

        if (
            $now >= $startDateTime &&
            $now <= $endDateTime
        ) {

            return [
                'status' => 'available',
                'label' => 'Start Now',
                'class' => 'primary',
                'action' => 'start'
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | 10. Not Attempted
        |--------------------------------------------------------------------------
        |
        | The examination has ended and there is no
        | existing attempt for this student.
        |
        */

        return [
            'status' => 'not_attempted',
            'label' => 'Not Attempted',
            'class' => 'danger',
            'action' => 'disabled'
        ];
    }
}