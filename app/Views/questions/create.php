<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Questions | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Add Questions
            </h2>

            <p class="text-muted mb-0">
                Create questions for your examination.
            </p>
        </div>

        <a href="<?= base_url('/dashboard') ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>

    </div>


    <!-- Exam Information -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <small class="text-muted">
                        Examination
                    </small>

                    <h5 class="fw-semibold mb-0">
                        <?= esc($exam['title']) ?>
                    </h5>
                </div>


                <div class="col-md-6">
                    <small class="text-muted">
                        Subject
                    </small>

                    <h5 class="fw-semibold mb-0">
                        <?= esc($exam['subject']) ?>
                    </h5>
                </div>

            </div>

        </div>

    </div>


    <!-- Question Form -->
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-4">
                <i class="bi bi-question-circle me-2"></i>
                Question Details
            </h5>


            <form
                action="<?= base_url('/questions/store/' . $exam['id']) ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <!-- Question -->
                <div class="mb-4">

                    <label for="question"
                           class="form-label fw-semibold">

                        Question

                    </label>

                    <textarea
                        name="question"
                        id="question"
                        rows="4"
                        class="form-control"
                        placeholder="Enter your question here..."
                        required
                    ></textarea>

                </div>


                <!-- Options -->
                <div class="row g-3">

                    <!-- Option A -->
                    <div class="col-md-6">

                        <label for="option_a"
                               class="form-label fw-semibold">

                            Option A

                        </label>

                        <input
                            type="text"
                            name="option_a"
                            id="option_a"
                            class="form-control"
                            placeholder="Enter option A"
                            required
                        >

                    </div>


                    <!-- Option B -->
                    <div class="col-md-6">

                        <label for="option_b"
                               class="form-label fw-semibold">

                            Option B

                        </label>

                        <input
                            type="text"
                            name="option_b"
                            id="option_b"
                            class="form-control"
                            placeholder="Enter option B"
                            required
                        >

                    </div>


                    <!-- Option C -->
                    <div class="col-md-6">

                        <label for="option_c"
                               class="form-label fw-semibold">

                            Option C

                        </label>

                        <input
                            type="text"
                            name="option_c"
                            id="option_c"
                            class="form-control"
                            placeholder="Enter option C"
                            required
                        >

                    </div>


                    <!-- Option D -->
                    <div class="col-md-6">

                        <label for="option_d"
                               class="form-label fw-semibold">

                            Option D

                        </label>

                        <input
                            type="text"
                            name="option_d"
                            id="option_d"
                            class="form-control"
                            placeholder="Enter option D"
                            required
                        >

                    </div>

                </div>


                <!-- Correct Option + Marks -->
                <div class="row g-3 mt-2">

                    <!-- Correct Option -->
                    <div class="col-md-6">

                        <label for="correct_option"
                               class="form-label fw-semibold">

                            Correct Option

                        </label>

                        <select
                            name="correct_option"
                            id="correct_option"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select correct option
                            </option>

                            <option value="A">
                                Option A
                            </option>

                            <option value="B">
                                Option B
                            </option>

                            <option value="C">
                                Option C
                            </option>

                            <option value="D">
                                Option D
                            </option>

                        </select>

                    </div>


                    <!-- Marks -->
                    <div class="col-md-6">

                        <label for="marks"
                               class="form-label fw-semibold">

                            Marks

                        </label>

                        <input
                            type="number"
                            name="marks"
                            id="marks"
                            class="form-control"
                            min="1"
                            placeholder="Enter marks"
                            required
                        >

                    </div>

                </div>


                <!-- Submit -->
                <div class="d-flex justify-content-end mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-plus-circle me-1"></i>

                        Add Question

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>