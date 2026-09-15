<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\ExaminerStudentModel;
use App\Models\ExamModel;
use App\Models\ExamStudentModel;
use App\Models\AttemptModel;
use App\Models\ResultModel;

class StudentController extends BaseController
{
    protected $studentModel;
    protected $examinerStudentModel;
    protected $examModel;
    protected $examStudentModel;
    protected $attemptModel;
    protected $resultModel;

    public function __construct()
    {
        $this->studentModel = new StudentModel();
        $this->examinerStudentModel = new ExaminerStudentModel();
        $this->examModel = new ExamModel();
        $this->examStudentModel = new ExamStudentModel();
        $this->attemptModel = new AttemptModel();
        $this->resultModel = new ResultModel();
    }

    /*
    |--------------------------------------------------------------------------
    | STUDENT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $examinerId = session('user_id');

        $students = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'examiner_students.examiner_id',
                $examinerId
            )
            ->orderBy('students.name', 'ASC')
            ->findAll();

        return view('students/index', [
            'students' => $students
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ADD STUDENT PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('students/create');
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE NEW / ADD EXISTING STUDENT
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]',
            'department' => 'required|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $email = strtolower(
            trim($this->request->getPost('email'))
        );

        $examinerId = session('user_id');

        /*
        |--------------------------------------------------------------------------
        | CHECK IF STUDENT ACCOUNT ALREADY EXISTS
        |--------------------------------------------------------------------------
        */

        $existingStudent = $this->studentModel
            ->where('email', $email)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | EXISTING STUDENT
        |--------------------------------------------------------------------------
        */

        if ($existingStudent) {

            $alreadyLinked = $this->examinerStudentModel
                ->where(
                    'examiner_id',
                    $examinerId
                )
                ->where(
                    'student_id',
                    $existingStudent['id']
                )
                ->first();

            if ($alreadyLinked) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'This student is already in your student list.'
                    );
            }

            $this->examinerStudentModel->insert([
                'examiner_id' => $examinerId,
                'student_id' => $existingStudent['id']
            ]);

            return redirect()
                ->to('/students')
                ->with(
                    'success',
                    'Existing student added to your student list.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW STUDENT ACCOUNT
        |--------------------------------------------------------------------------
        */

        $plainPassword = bin2hex(
            random_bytes(4)
        );

        $studentId = $this->studentModel->insert([
            'name' => trim(
                $this->request->getPost('name')
            ),

            'email' => $email,

            'department' => trim(
                $this->request->getPost('department')
            ),

            'password' => password_hash(
                $plainPassword,
                PASSWORD_DEFAULT
            ),

            'status' => 'Active'
        ]);


        if (!$studentId) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create student account.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CONNECT STUDENT WITH CURRENT TEACHER
        |--------------------------------------------------------------------------
        */

        $this->examinerStudentModel->insert([
            'examiner_id' => $examinerId,
            'student_id' => $studentId
        ]);


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student added successfully.'
            )
            ->with(
                'student_credentials',
                [
                    'email' => $email,
                    'password' => $plainPassword
                ]
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD EXISTING STUDENT
    |--------------------------------------------------------------------------
    */

    public function addExisting($studentId)
    {
        $examinerId = session('user_id');

        $student = $this->studentModel
            ->where('id', $studentId)
            ->first();

        if (!$student) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Student not found.'
                );
        }

        $alreadyLinked = $this->examinerStudentModel
            ->where(
                'examiner_id',
                $examinerId
            )
            ->where(
                'student_id',
                $studentId
            )
            ->first();

        if ($alreadyLinked) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This student is already in your student list.'
                );
        }

        $this->examinerStudentModel->insert([
            'examiner_id' => $examinerId,
            'student_id' => $studentId
        ]);

        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student added to your student list successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE STUDENT FROM MY LIST
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | This NEVER deletes the student account.
    |
    | It only deletes:
    |
    | examiner_students
    |
    | for the current teacher + student relationship.
    |
    */

    public function delete($studentId)
    {
        $examinerId = session('user_id');

        $relationship = $this->examinerStudentModel
            ->where(
                'examiner_id',
                $examinerId
            )
            ->where(
                'student_id',
                $studentId
            )
            ->first();

        if (!$relationship) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $this->examinerStudentModel
            ->where(
                'examiner_id',
                $examinerId
            )
            ->where(
                'student_id',
                $studentId
            )
            ->delete();

        return redirect()
            ->to('/students')
            ->with(
                'success',
                'Student removed from your student list.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW STUDENT + TEACHER-SPECIFIC PROGRESS
    |--------------------------------------------------------------------------
    */

    public function view($studentId)
    {
        $examinerId = session('user_id');


        /*
        |--------------------------------------------------------------------------
        | VERIFY STUDENT BELONGS TO CURRENT TEACHER
        |--------------------------------------------------------------------------
        */

        $student = $this->studentModel
            ->select('students.*')
            ->join(
                'examiner_students',
                'examiner_students.student_id = students.id'
            )
            ->where(
                'students.id',
                $studentId
            )
            ->where(
                'examiner_students.examiner_id',
                $examinerId
            )
            ->first();

        if (!$student) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }


        /*
        |--------------------------------------------------------------------------
        | GET CURRENT TEACHER'S EXAMS
        |--------------------------------------------------------------------------
        */

        $teacherExams = $this->examModel
            ->select('exams.*')
            ->where(
                'exams.examiner_id',
                $examinerId
            )
            ->findAll();


        $examIds = [];

        foreach ($teacherExams as $exam) {
            $examIds[] = $exam['id'];
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT PROGRESS VALUES
        |--------------------------------------------------------------------------
        */

        $totalAssigned = 0;
        $attempted = 0;
        $completed = 0;

        $passed = 0;
        $failed = 0;

        $percentages = [];

        $recentResults = [];


        /*
        |--------------------------------------------------------------------------
        | NO EXAMS
        |--------------------------------------------------------------------------
        */

        if (!empty($examIds)) {

            /*
            |--------------------------------------------------------------------------
            | TOTAL ASSIGNED EXAMS
            |--------------------------------------------------------------------------
            */

            $totalAssigned = $this->examStudentModel
                ->where(
                    'student_id',
                    $studentId
                )
                ->whereIn(
                    'exam_id',
                    $examIds
                )
                ->countAllResults();


            /*
            |--------------------------------------------------------------------------
            | COMPLETED ATTEMPTS
            |--------------------------------------------------------------------------
            */

            $attempts = $this->attemptModel
                ->select(
                    'attempts.*, exams.title, exams.subject, exams.exam_date, exams.total_marks'
                )
                ->join(
                    'exams',
                    'exams.id = attempts.exam_id'
                )
                ->where(
                    'attempts.student_id',
                    $studentId
                )
                ->whereIn(
                    'attempts.exam_id',
                    $examIds
                )
                ->whereIn(
                    'attempts.status',
                    ['Submitted', 'Auto Submitted']
                )
                ->orderBy(
                    'attempts.submitted_at',
                    'DESC'
                )
                ->findAll();


            /*
            |--------------------------------------------------------------------------
            | USE ONE COMPLETED ATTEMPT PER EXAM
            |--------------------------------------------------------------------------
            */

            $processedExams = [];

            foreach ($attempts as $attempt) {

                if (in_array($attempt['exam_id'], $processedExams)) {
                    continue;
                }

                $processedExams[] = $attempt['exam_id'];

                $completed++;

                $percentage = (float) $attempt['percentage'];

                $percentages[] = $percentage;


                /*
                |--------------------------------------------------------------------------
                | PASS / FAIL
                |--------------------------------------------------------------------------
                */

                $result = $this->resultModel
                    ->where(
                        'attempt_id',
                        $attempt['id']
                    )
                    ->first();

                if ($result) {

                    if ($result['status'] === 'Pass') {
                        $passed++;
                    } elseif ($result['status'] === 'Fail') {
                        $failed++;
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | RECENT RESULTS
                |--------------------------------------------------------------------------
                */

                $recentResults[] = [
                    'attempt_id' => $attempt['id'],
                    'title' => $attempt['title'],
                    'subject' => $attempt['subject'],
                    'exam_date' => $attempt['exam_date'],
                    'score' => $attempt['score'],
                    'total_marks' => $attempt['total_marks'],
                    'percentage' => $percentage,
                    'status' => $result['status'] ?? null,
                    'submitted_at' => $attempt['submitted_at']
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | ATTEMPTED EXAMS
            |--------------------------------------------------------------------------
            */

            $attempted = $this->attemptModel
                ->select('attempts.exam_id')
                ->join(
                    'exams',
                    'exams.id = attempts.exam_id'
                )
                ->where(
                    'attempts.student_id',
                    $studentId
                )
                ->whereIn(
                    'attempts.exam_id',
                    $examIds
                )
                ->groupBy(
                    'attempts.exam_id'
                )
                ->countAllResults();
        }


        /*
        |--------------------------------------------------------------------------
        | PERFORMANCE CALCULATIONS
        |--------------------------------------------------------------------------
        */

        $averagePercentage = 0;
        $highestPercentage = 0;
        $lowestPercentage = 0;
        $passPercentage = 0;

        if (!empty($percentages)) {

            $averagePercentage =
                array_sum($percentages) / count($percentages);

            $highestPercentage =
                max($percentages);

            $lowestPercentage =
                min($percentages);
        }

        if ($completed > 0) {
            $passPercentage =
                ($passed / $completed) * 100;
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('students/view', [

            'student' => $student,

            'totalAssigned' => $totalAssigned,

            'attempted' => $attempted,

            'completed' => $completed,

            'passed' => $passed,

            'failed' => $failed,

            'averagePercentage' => $averagePercentage,

            'highestPercentage' => $highestPercentage,

            'lowestPercentage' => $lowestPercentage,

            'passPercentage' => $passPercentage,

            'recentResults' => array_slice(
                $recentResults,
                0,
                10
            )
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DYNAMIC STUDENT SEARCH
    |--------------------------------------------------------------------------
    */

    public function search()
    {
        $query = trim(
            $this->request->getGet('q') ?? ''
        );

        if ($query === '') {
            return $this->response
                ->setJSON([]);
        }

        $students = $this->studentModel
            ->groupStart()
                ->like('name', $query)
                ->orLike('email', $query)
            ->groupEnd()
            ->orderBy('name', 'ASC')
            ->findAll(10);


        $linkedStudentIds = $this->examinerStudentModel
            ->where(
                'examiner_id',
                session('user_id')
            )
            ->findColumn('student_id');


        if (!$linkedStudentIds) {
            $linkedStudentIds = [];
        }


        $results = [];

        foreach ($students as $student) {

            $results[] = [
                'id' => $student['id'],
                'name' => $student['name'],
                'email' => $student['email'],
                'department' => $student['department'],
                'already_added' => in_array(
                    $student['id'],
                    $linkedStudentIds
                )
            ];
        }


        return $this->response
            ->setJSON($results);
    }
}