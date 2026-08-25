<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Student | EduQuiz</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- Page CSS -->

    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/student-create.css') ?>"
    >

</head>


<body>


<div class="student-page">

    <div class="container">

        <?php
             $errors = session()->getFlashdata('errors') ?? [];
        ?>
        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="page-header">

            <div>

                <span class="page-eyebrow">

                    <i class="bi bi-person-plus"></i>

                    Student Management

                </span>


                <h1>Add Student</h1>


                <p>

                    Add students who can be invited to your examinations.

                </p>

            </div>


            <a
                href="<?= base_url('dashboard') ?>"
                class="btn btn-outline-secondary back-btn"
            >

                <i class="bi bi-arrow-left"></i>

                Dashboard

            </a>

        </div>



        <!-- =====================================================
             STUDENT FORM CARD
        ====================================================== -->

        <div class="student-form-card">


            <div class="form-card-header">

                <div class="form-icon">

                    <i class="bi bi-person"></i>

                </div>


                <div>

                    <h3>Student Information</h3>

                    <p>

                        Enter the student's details below.

                    </p>

                </div>

            </div>



            <!-- SUCCESS MESSAGE -->

            <?php if (session()->getFlashdata('success')): ?>

                <div class="alert alert-success">

                    <i class="bi bi-check-circle-fill"></i>

                    <?= session()->getFlashdata('success') ?>

                </div>

            <?php endif; ?>



            <!-- ERROR MESSAGE -->

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <?= session()->getFlashdata('error') ?>

                </div>

            <?php endif; ?>



            <!-- =====================================================
                 FORM
            ====================================================== -->

            <form
                action="<?= base_url('students/store') ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <!-- STUDENT NAME -->

                <div class="mb-4">

                    <label
                        for="name"
                        class="form-label"
                    >

                        Student Name

                    </label>


                    <div class="input-wrapper">

                        <i class="bi bi-person"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                            placeholder="Enter student's full name"
                            value="<?= old('name') ?>"
                        >

                    </div>


                    <?php if (isset($errors['name'])): ?>

                        <div class="invalid-feedback d-block">

                            <?= esc($errors['name']) ?>

                        </div>

                    <?php endif; ?>

                </div>



                <!-- EMAIL -->

                <div class="mb-4">

                    <label
                        for="email"
                        class="form-label"
                    >

                        Email Address

                    </label>


                    <div class="input-wrapper">

                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            placeholder="student@example.com"
                            value="<?= old('email') ?>"
                        >

                    </div>


                    <?php if (isset($errors['email'])): ?>

                        <div class="invalid-feedback d-block">

                            <?= esc($errors['email']) ?>

                        </div>

                    <?php endif; ?>

                </div>

                <!-- DEPARTMENT -->

                <div class="mb-4">

                    <label
                        for="department"
                        class="form-label"
                    >
                        Department
                    </label>

                    <div class="input-wrapper">

                        <i class="bi bi-building"></i>

                        <input
                            type="text"
                            id="department"
                            name="department"
                            class="form-control <?= isset($errors['department']) ? 'is-invalid' : '' ?>"
                            placeholder="e.g. Computer Science"
                            value="<?= old('department') ?>"
                        >

                    </div>

                    <?php if (isset($errors['department'])): ?>

                        <div class="invalid-feedback d-block">

                            <?= esc($errors['department']) ?>

                        </div>

                    <?php endif; ?>

                </div>
                

                <!-- ACTIONS -->

                <div class="form-actions">


                    <a
                        href="<?= base_url('dashboard') ?>"
                        class="btn btn-light cancel-btn"
                    >

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary add-student-btn"
                    >

                        <i class="bi bi-person-plus"></i>

                        Add Student

                    </button>


                </div>


            </form>


        </div>


    </div>

</div>


</body>

</html>