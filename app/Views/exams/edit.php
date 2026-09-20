<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Examination | EduQuiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="<?= base_url('assets/css/exam.css') ?>">

</head>

<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Edit Examination
            </h2>

            <p class="text-muted mb-0">
                Update your examination details.
            </p>

        </div>

        <a href="<?= base_url('/dashboard') ?>"
           class="btn btn-outline-secondary">

            ← Dashboard

        </a>

    </div>


    <?php if (session()->getFlashdata('errors')): ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php foreach (session()->getFlashdata('errors') as $error): ?>

                    <li><?= esc($error) ?></li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <form action="<?= base_url('exams/update/' . $exam['id']) ?>"
          method="post">

        <?= csrf_field() ?>


        <div class="card shadow-sm border-0">

            <div class="card-body p-4">

                <div class="row g-4">


                    <!-- Examination Title -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Examination Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="<?= esc(old('title', $exam['title'])) ?>">

                    </div>


                    <!-- Subject -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Subject
                        </label>

                        <input
                            type="text"
                            name="subject"
                            class="form-control"
                            value="<?= esc(old('subject', $exam['subject'])) ?>">

                    </div>


                    <!-- Description -->

                    <div class="col-12">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"><?= esc(old('description', $exam['description'])) ?></textarea>

                    </div>


                    <!-- Instructions -->

                    <div class="col-12">

                        <label class="form-label">
                            Instructions
                        </label>

                        <textarea
                            name="instructions"
                            class="form-control"
                            rows="4"><?= esc(old('instructions', $exam['instructions'])) ?></textarea>

                    </div>


                    <!-- Duration -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Duration (Minutes)
                        </label>

                        <input
                            type="number"
                            name="duration"
                            class="form-control"
                            min="1"
                            value="<?= esc(old('duration', $exam['duration'])) ?>">

                    </div>


                    <!-- Total Marks -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Total Marks
                        </label>

                        <input
                            type="number"
                            name="total_marks"
                            class="form-control"
                            min="1"
                            value="<?= esc(old('total_marks', $exam['total_marks'])) ?>">

                    </div>


                    <!-- Passing Marks -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Passing Marks
                        </label>

                        <input
                            type="number"
                            name="passing_marks"
                            class="form-control"
                            min="1"
                            value="<?= esc(old('passing_marks', $exam['passing_marks'])) ?>">

                    </div>


                    <!-- Exam Date -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Exam Date
                        </label>

                        <input
                            type="date"
                            name="exam_date"
                            class="form-control"
                            value="<?= esc(old('exam_date', $exam['exam_date'])) ?>">

                    </div>


                    <!-- Start Time -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Start Time
                        </label>

                        <input
                            type="time"
                            name="start_time"
                            class="form-control"
                            value="<?= esc(old('start_time', $exam['start_time'])) ?>">

                    </div>


                    <!-- End Time -->

                    <div class="col-md-4">

                        <label class="form-label">
                            End Time
                        </label>

                        <input
                            type="time"
                            name="end_time"
                            class="form-control"
                            value="<?= esc(old('end_time', $exam['end_time'])) ?>">

                    </div>


                    <!-- Status -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option
                                value="Draft"
                                <?= ($exam['status'] ?? '') === 'Draft' ? 'selected' : '' ?>>

                                Draft

                            </option>

                            <option
                                value="Published"
                                <?= ($exam['status'] ?? '') === 'Published' ? 'selected' : '' ?>>

                                Published

                            </option>

                        </select>

                    </div>


                </div>


                <!-- Action Buttons -->

                <div class="d-flex justify-content-end gap-2 mt-5">

                    <a
                        href="<?= base_url('/dashboard') ?>"
                        class="btn btn-light">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary px-4">

                        <i class="bi bi-check-circle me-1"></i>

                        Update Examination

                    </button>

                </div>


            </div>

        </div>

    </form>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>