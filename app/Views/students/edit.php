<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Student | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="mb-4">

                <a
                    href="<?= base_url('students') ?>"
                    class="text-decoration-none"
                >
                    <i class="bi bi-arrow-left"></i>
                    Back to Students
                </a>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h3 class="mb-1">
                        Edit Student
                    </h3>

                    <p class="text-muted mb-4">
                        Update the student's information.
                    </p>


                    <?php if (session()->getFlashdata('error')): ?>

                        <div class="alert alert-danger">

                            <?= esc(
                                session()->getFlashdata('error')
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <?php if (session()->getFlashdata('errors')): ?>

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                <?php foreach (
                                    session()->getFlashdata('errors')
                                    as $error
                                ): ?>

                                    <li>
                                        <?= esc($error) ?>
                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        </div>

                    <?php endif; ?>


                    <form
                        action="<?= base_url(
                            'students/update/' . $student['id']
                        ) ?>"
                        method="post"
                    >

                        <?= csrf_field() ?>


                        <!-- NAME -->

                        <div class="mb-3">

                            <label class="form-label">
                                Student Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?= esc(
                                    old(
                                        'name',
                                        $student['name']
                                    )
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="<?= esc(
                                    old(
                                        'email',
                                        $student['email']
                                    )
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- DEPARTMENT -->

                        <div class="mb-4">

                            <label class="form-label">
                                Department
                            </label>

                            <input
                                type="text"
                                name="department"
                                class="form-control"
                                value="<?= esc(
                                    old(
                                        'department',
                                        $student['department']
                                    )
                                ) ?>"
                                required
                            >

                        </div>


                        <!-- ACTIONS -->

                        <div class="d-flex gap-2">

                            <a
                                href="<?= base_url('students') ?>"
                                class="btn btn-outline-secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-check-lg"></i>
                                Update Student
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>