<?php

namespace App\Controllers;

use App\Models\ExamModel;
use App\Models\QuestionModel;
use App\Models\StudentModel;
use App\Models\ExamStudentModel;
use App\Models\ExaminerStudentModel;
use App\Models\AttemptModel;
use App\Models\ResultModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExamController extends BaseController
{
    protected $examModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
    }

    public function create()
    {
        return view('exams/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'subject' => 'required|max_length[150]',
            'duration' => 'required|integer|greater_than[0]',
            'total_marks' => 'required|integer|greater_than[0]',
            'passing_marks' => 'required|integer|greater_than_equal_to[0]',
            'exam_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $action = $this->request->getPost('action');

        $status = ($action === 'draft')
            ? 'Draft'
            : 'Published';

        $examData = [
            'examiner_id' => session('user_id'),
            'title' => trim($this->request->getPost('title')),
            'subject' => trim($this->request->getPost('subject')),
            'description' => trim($this->request->getPost('description')),
            'instructions' => trim($this->request->getPost('instructions')),
            'duration' => $this->request->getPost('duration'),
            'total_marks' => $this->request->getPost('total_marks'),
            'passing_marks' => $this->request->getPost('passing_marks'),

            // One student can attempt an examination only once.
            'max_attempts' => 1,

            'exam_date' => $this->request->getPost('exam_date'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'status' => $status
        ];

        $this->examModel->insert($examData);

        $examId = $this->examModel->getInsertID();

        if ($action === 'draft') {
            return redirect()
                ->to('/dashboard')
                ->with(
                    'success',
                    'Examination saved as draft successfully.'
                );
        }

        return redirect()
            ->to('/questions/create/' . $examId)
            ->with(
                'success',
                'Examination created successfully. Now add questions.'
            );
    }

    public function index()
    {
        $exams = $this->examModel
            ->where('examiner_id', session('user_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $questionModel = new QuestionModel();

        $questionsCount = [];

        foreach ($exams as $exam) {
            $questionsCount[] = [
                'exam_id' => $exam['id'],
                'total' => $questionModel
                    ->where('exam_id', $exam['id'])
                    ->countAllResults()
            ];
        }

        $examStudentModel = new ExamStudentModel();

        $resultsAvailable = [];

        foreach ($exams as $exam) {
            $sharedCount = $examStudentModel
                ->where('exam_id', $exam['id'])
                ->countAllResults();

            $deadlinePassed = $this->isExamDeadlinePassed($exam);

            $resultsAvailable[$exam['id']] =
                ($sharedCount > 0 && $deadlinePassed);
        }

        return view('exams/index', [
            'exams' => $exams,
            'questionsCount' => $questionsCount,
            'resultsAvailable' => $resultsAvailable
        ]);
    }

    public function review($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $questionModel = new QuestionModel();

        $questions = $questionModel
            ->where('exam_id', $id)
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('exams/review', [
            'exam' => $exam,
            'questions' => $questions
        ]);
    }

    public function finish($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        if ($exam['status'] === 'Published') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'This examination is already published.'
                );
        }

        $questionModel = new QuestionModel();

        $questionCount = $questionModel
            ->where('exam_id', $id)
            ->countAllResults();

        if ($questionCount === 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Add at least one question before publishing the examination.'
                );
        }

        $this->examModel->update($id, [
            'status' => 'Published'
        ]);

        return redirect()
            ->to('/exams/review/' . $id)
            ->with(
                'success',
                'Examination published successfully.'
            );
    }

    public function edit($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        return view('exams/edit', [
            'exam' => $exam
        ]);
    }

    public function update($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'subject' => 'required|max_length[150]',
            'duration' => 'required|integer|greater_than[0]',
            'total_marks' => 'required|integer|greater_than[0]',
            'passing_marks' => 'required|integer|greater_than_equal_to[0]',
            'exam_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in_list[Draft,Published]'
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

        $status = $this->request->getPost('status');

        if (
            $status === 'Published' &&
            $exam['status'] !== 'Published'
        ) {
            $questionModel = new QuestionModel();

            $questionCount = $questionModel
                ->where('exam_id', $id)
                ->countAllResults();

            if ($questionCount === 0) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Add at least one question before publishing the examination.'
                    );
            }
        }

        $examData = [
            'title' => trim($this->request->getPost('title')),
            'subject' => trim($this->request->getPost('subject')),
            'description' => trim($this->request->getPost('description')),
            'instructions' => trim($this->request->getPost('instructions')),
            'duration' => $this->request->getPost('duration'),
            'total_marks' => $this->request->getPost('total_marks'),
            'passing_marks' => $this->request->getPost('passing_marks'),
            'max_attempts' => $this->request->getPost('max_attempts'),
            'exam_date' => $this->request->getPost('exam_date'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'status' => $status
        ];

        $this->examModel->update($id, $examData);

        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination updated successfully.'
            );
    }

    public function results($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $examStudentModel = new ExamStudentModel();

        $sharedCount = $examStudentModel
            ->where('exam_id', $id)
            ->countAllResults();

        if ($sharedCount === 0) {
            return redirect()
                ->to('/exams')
                ->with(
                    'error',
                    'Results are not available because this examination was not shared with any students.'
                );
        }

        if (!$this->isExamDeadlinePassed($exam)) {
            return redirect()
                ->to('/exams')
                ->with(
                    'error',
                    'Results will be available after the examination deadline.'
                );
        }

        $attemptModel = new AttemptModel();

        $submissions = $attemptModel
            ->select(
                'attempts.*,
                students.name,
                students.email,
                students.department,
                results.rank,
                results.status AS result_status'
            )
            ->join(
                'students',
                'students.id = attempts.student_id',
                'inner'
            )
            ->join(
                'results',
                'results.attempt_id = attempts.id',
                'inner'
            )
            ->where(
                'attempts.exam_id',
                $id
            )
            ->where(
                'attempts.status',
                'Submitted'
            )
            ->orderBy(
                'attempts.score',
                'DESC'
            )
            ->orderBy(
                'attempts.submitted_at',
                'ASC'
            )
            ->findAll();

        $rank = 0;
        $position = 0;
        $previousScore = null;

        foreach ($submissions as &$submission) {
            $position++;

            $currentScore = (int) (
                $submission['score'] ?? 0
            );

            if (
                $previousScore === null ||
                $currentScore < $previousScore
            ) {
                $rank = $position;
            }

            $submission['merit_rank'] = $rank;

            $previousScore = $currentScore;
        }

        unset($submission);

        $totalSubmissions = count($submissions);

        $passed = 0;
        $failed = 0;
        $totalScore = 0;

        foreach ($submissions as $submission) {
            $score = (int) (
                $submission['score'] ?? 0
            );

            $totalScore += $score;

            $resultStatus = strtolower(
                trim(
                    $submission['result_status'] ?? ''
                )
            );

            if ($resultStatus === 'pass') {
                $passed++;
            } else {
                $failed++;
            }
        }

        $averageScore = $totalSubmissions > 0
            ? round(
                $totalScore / $totalSubmissions,
                2
            )
            : 0;

        $passPercentage = $totalSubmissions > 0
            ? round(
                ($passed / $totalSubmissions) * 100,
                2
            )
            : 0;

        $submissionPercentage = $sharedCount > 0
            ? round(
                ($totalSubmissions / $sharedCount) * 100,
                2
            )
            : 0;

        return view('exams/results', [
            'exam' => $exam,
            'sharedCount' => $sharedCount,
            'totalSubmissions' => $totalSubmissions,
            'passed' => $passed,
            'failed' => $failed,
            'averageScore' => $averageScore,
            'passPercentage' => $passPercentage,
            'submissionPercentage' => $submissionPercentage,
            'submissions' => $submissions
        ]);
    }

    public function downloadStudentResult($attemptId)
    {
        $examinerId = session('user_id');

        if (!$examinerId) {
            return redirect()
                ->to('/login')
                ->with('error', 'Please login as examiner.');
        }

        $attemptModel = new AttemptModel();

        $attempt = $attemptModel
            ->where('id', $attemptId)
            ->where('status', 'Submitted')
            ->first();

        if (!$attempt) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        /*
        * Get the examination and make sure
        * it belongs to the logged-in examiner.
        */
        $exam = $this->examModel
            ->where('id', $attempt['exam_id'])
            ->where('examiner_id', $examinerId)
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        /*
        * Get student information.
        */
        $studentModel = new StudentModel();

        $student = $studentModel
            ->where('id', $attempt['student_id'])
            ->first();

        if (!$student) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        /*
        * Get questions.
        */
        $questionModel = new QuestionModel();

        $questions = $questionModel
            ->where('exam_id', $attempt['exam_id'])
            ->orderBy('id', 'ASC')
            ->findAll();

        /*
        * Get student's answers.
        */
        $studentAnswerModel =
            new \App\Models\StudentAnswerModel();

        $answers = $studentAnswerModel
            ->where('attempt_id', $attemptId)
            ->findAll();

        /*
        * Calculate answer statistics.
        */
        $correctCount = 0;
        $wrongCount = 0;
        $answeredCount = 0;

        foreach ($answers as $answer) {

            if (
                isset($answer['selected_option']) &&
                $answer['selected_option'] !== null &&
                $answer['selected_option'] !== ''
            ) {

                $answeredCount++;

                if (
                    isset($answer['is_correct']) &&
                    (
                        $answer['is_correct'] === true ||
                        $answer['is_correct'] === 1 ||
                        $answer['is_correct'] === '1'
                    )
                ) {

                    $correctCount++;

                } else {

                    $wrongCount++;
                }
            }
        }

        $totalQuestions = count($questions);

        $notAnsweredCount = max(
            0,
            $totalQuestions - $answeredCount
        );

        /*
        * Calculate percentage.
        */
        $totalMarks = (float) $exam['total_marks'];

        $score = (float) (
            $attempt['score'] ?? 0
        );

        $percentage = 0;

        if ($totalMarks > 0) {

            $percentage = round(
                ($score / $totalMarks) * 100,
                2
            );
        }

        /*
        * Determine result status.
        */
        $status = 'FAIL';

        if (
            $score >= (float) $exam['passing_marks']
        ) {

            $status = 'PASS';
        }

        /*
        * Student information.
        */
        $studentName =
            $student['name']
            ?? $student['full_name']
            ?? 'Student';

        $studentEmail =
            $student['email']
            ?? '';

        /*
        * Generate PDF HTML.
        *
        * We reuse the same result PDF view
        * used on the student side.
        */
        $html = view(
            'student_exam/result_pdf',
            [
                'studentName' => $studentName,
                'studentEmail' => $studentEmail,
                'exam' => $exam,
                'attempt' => $attempt,
                'totalQuestions' => $totalQuestions,
                'answeredCount' => $answeredCount,
                'correctCount' => $correctCount,
                'wrongCount' => $wrongCount,
                'notAnsweredCount' => $notAnsweredCount,
                'score' => $score,
                'percentage' => $percentage,
                'status' => $status
            ]
        );

        /*
        * Dompdf configuration.
        */
        $options = new Options();

        $options->set(
            'isHtml5ParserEnabled',
            true
        );

        $options->set(
            'isRemoteEnabled',
            true
        );

        $options->set(
            'defaultFont',
            'DejaVu Sans'
        );

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper(
            'A4',
            'portrait'
        );

        $dompdf->render();

        /*
        * Generate a safe filename.
        */
        $safeExamTitle = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $exam['title']
        );

        $safeStudentName = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $studentName
        );

        $fileName =
            $safeStudentName .
            '_' .
            $safeExamTitle .
            '_Result.pdf';

        /*
        * Download PDF.
        */
        $dompdf->stream(
            $fileName,
            [
                'Attachment' => true
            ]
        );

        exit;
    }

    public function downloadMeritList($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $examStudentModel = new ExamStudentModel();

        $sharedCount = $examStudentModel
            ->where('exam_id', $id)
            ->countAllResults();

        if ($sharedCount === 0) {
            return redirect()
                ->to('/exams')
                ->with(
                    'error',
                    'Merit list is not available because this examination was not shared with any students.'
                );
        }

        if (!$this->isExamDeadlinePassed($exam)) {
            return redirect()
                ->to('/exams')
                ->with(
                    'error',
                    'Merit list will be available after the examination deadline.'
                );
        }

        $attemptModel = new AttemptModel();

        $submissions = $attemptModel
            ->select(
                'attempts.*,
                students.name,
                students.email,
                students.department,
                results.status AS result_status'
            )
            ->join(
                'students',
                'students.id = attempts.student_id',
                'inner'
            )
            ->join(
                'results',
                'results.attempt_id = attempts.id',
                'inner'
            )
            ->where(
                'attempts.exam_id',
                $id
            )
            ->where(
                'attempts.status',
                'Submitted'
            )
            ->orderBy(
                'attempts.score',
                'DESC'
            )
            ->orderBy(
                'attempts.submitted_at',
                'ASC'
            )
            ->findAll();

        $rank = 0;
        $position = 0;
        $previousScore = null;

        foreach ($submissions as &$submission) {

            $position++;

            $currentScore = (int) (
                $submission['score'] ?? 0
            );

            if (
                $previousScore === null ||
                $currentScore < $previousScore
            ) {
                $rank = $position;
            }

            $submission['merit_rank'] = $rank;

            $previousScore = $currentScore;
        }

        unset($submission);

        $html = view(
            'exams/merit_list_pdf',
            [
                'exam' => $exam,
                'submissions' => $submissions
            ]
        );

        $options = new Options();

        $options->set(
            'isHtml5ParserEnabled',
            true
        );

        $options->set(
            'isRemoteEnabled',
            true
        );

        $options->set(
            'defaultFont',
            'DejaVu Sans'
        );

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper(
            'A4',
            'landscape'
        );

        $dompdf->render();

        $safeTitle = preg_replace(
            '/[^A-Za-z0-9_-]/',
            '_',
            $exam['title']
        );

        $fileName =
            $safeTitle .
            '_Merit_List_' .
            date('Y-m-d') .
            '.pdf';

        $dompdf->stream(
            $fileName,
            [
                'Attachment' => true
            ]
        );

        exit;
    }

    public function delete($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $this->examModel->delete($id);

        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination deleted successfully.'
            );
    }

    public function share($id)
    {
        $exam = $this->examModel
            ->where('id', $id)
            ->where('examiner_id', session('user_id'))
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        if (
            !empty($exam['exam_date']) &&
            !empty($exam['end_time'])
        ) {
            $deadline = strtotime(
                $exam['exam_date'] .
                ' ' .
                $exam['end_time']
            );

            if (time() > $deadline) {
                return redirect()
                    ->to('/exams')
                    ->with(
                        'error',
                        'This examination deadline has closed. Students can no longer be added.'
                    );
            }
        }

        $examinerStudentModel = new ExaminerStudentModel();

        $studentModel = new StudentModel();

        $studentRelations = $examinerStudentModel
            ->where(
                'examiner_id',
                session('user_id')
            )
            ->findAll();

        $students = [];

        foreach ($studentRelations as $relation) {
            $student = $studentModel
                ->where(
                    'id',
                    $relation['student_id']
                )
                ->first();

            if ($student) {
                $students[] = $student;
            }
        }

        $examStudentModel = new ExamStudentModel();

        $selectedStudents = $examStudentModel
            ->where('exam_id', $id)
            ->findColumn('student_id');

        if (!$selectedStudents) {
            $selectedStudents = [];
        }

        return view('exams/share', [
            'exam' => $exam,
            'students' => $students,
            'selectedStudents' => $selectedStudents
        ]);
    }

    public function shareStudents($id)
    {
        $examModel = new ExamModel();

        $examStudentModel = new ExamStudentModel();

        $examinerStudentModel = new ExaminerStudentModel();

        $exam = $examModel
            ->where('id', $id)
            ->where(
                'examiner_id',
                session('user_id')
            )
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        if (
            !empty($exam['exam_date']) &&
            !empty($exam['end_time'])
        ) {
            $deadline = strtotime(
                $exam['exam_date'] .
                ' ' .
                $exam['end_time']
            );

            if (time() > $deadline) {
                return redirect()
                    ->to('/exams')
                    ->with(
                        'error',
                        'This examination deadline has closed. Students can no longer be added.'
                    );
            }
        }

        $students = $this->request
            ->getPost('students');

        if (
            empty($students) ||
            !is_array($students)
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select at least one student.'
                );
        }

        $validStudents = [];

        foreach ($students as $studentId) {
            $relation = $examinerStudentModel
                ->where(
                    'examiner_id',
                    session('user_id')
                )
                ->where(
                    'student_id',
                    $studentId
                )
                ->first();

            if ($relation) {
                $validStudents[] = $studentId;
            }
        }

        if (empty($validStudents)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No valid students were selected.'
                );
        }

        $sharedCount = 0;

        foreach ($validStudents as $studentId) {
            $alreadyExists = $examStudentModel
                ->where('exam_id', $id)
                ->where(
                    'student_id',
                    $studentId
                )
                ->first();

            if (!$alreadyExists) {
                $examStudentModel->insert([
                    'exam_id' => $id,
                    'student_id' => $studentId,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $sharedCount++;
            }
        }

        if ($sharedCount === 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'The selected students have already received this examination.'
                );
        }

        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                'Examination shared successfully with ' .
                $sharedCount .
                ' student(s).'
            );
    }

    public function sendInvitations($id)
    {
        $examModel = new ExamModel();

        $examStudentModel = new ExamStudentModel();

        $examinerStudentModel = new ExaminerStudentModel();

        $exam = $examModel
            ->where('id', $id)
            ->where(
                'examiner_id',
                session('user_id')
            )
            ->first();

        if (!$exam) {
            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        if ($this->isExamDeadlinePassed($exam)) {
            return redirect()
                ->to('/exams')
                ->with(
                    'error',
                    'This examination is closed. Students can no longer be added.'
                );
        }

        $studentIds = $this->request
            ->getPost('students');

        if (
            empty($studentIds) ||
            !is_array($studentIds)
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Please select at least one student.'
                );
        }

        $examStudentModel
            ->where(
                'exam_id',
                $id
            )
            ->delete();

        $count = 0;

        foreach ($studentIds as $studentId) {
            $relation = $examinerStudentModel
                ->where(
                    'examiner_id',
                    session('user_id')
                )
                ->where(
                    'student_id',
                    $studentId
                )
                ->first();

            if (!$relation) {
                continue;
            }

            $examStudentModel->insert([
                'exam_id' => $id,
                'student_id' => $studentId,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $count++;
        }

        if ($count === 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No valid students were selected.'
                );
        }

        return redirect()
            ->to('/dashboard')
            ->with(
                'success',
                $count .
                ' student(s) selected for the examination.'
            );
    }

    private function isExamDeadlinePassed(array $exam): bool
    {
        if (
            empty($exam['exam_date']) ||
            empty($exam['end_time'])
        ) {
            return false;
        }

        $deadline = strtotime(
            $exam['exam_date'] .
            ' ' .
            $exam['end_time']
        );

        if ($deadline === false) {
            return false;
        }

        return time() > $deadline;
    }
}