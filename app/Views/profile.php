<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Profile | EduQuiz</title>


    <!-- Bootstrap 5 -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        body {
            background-color: #f8f9fa;
        }


        .profile-container {
            max-width: 900px;
            margin: 40px auto;
        }


        .profile-card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
        }


        .profile-header {
            background: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 24px 28px;
        }


        .profile-body {
            padding: 30px;
        }


        .profile-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #0d6efd;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 600;
        }


        .form-label {
            font-weight: 600;
        }


        .readonly-field {
            background-color: #f1f3f5;
            cursor: not-allowed;
        }


        .email-lock {
            color: #6c757d;
            font-size: 13px;
        }


        .section-title {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 20px;
        }

    </style>

</head>


<body>


<div class="container">

    <div class="profile-container">


        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    My Profile
                </h3>

                <p class="text-muted mb-0">
                    Update your examiner account information
                </p>

            </div>


            <a
                href="<?= base_url('dashboard') ?>"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-1"></i>

                Back to Dashboard

            </a>

        </div>



        <!-- =====================================================
             SUCCESS MESSAGE
        ====================================================== -->

        <?php if (session()->getFlashdata('success')): ?>

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i class="bi bi-check-circle me-2"></i>

                <?= esc(session()->getFlashdata('success')) ?>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        <?php endif; ?>



        <!-- =====================================================
             ERROR MESSAGE
        ====================================================== -->

        <?php if (session()->getFlashdata('error')): ?>

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >

                <i class="bi bi-exclamation-circle me-2"></i>

                <?= esc(session()->getFlashdata('error')) ?>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        <?php endif; ?>



        <!-- =====================================================
             VALIDATION ERRORS
        ====================================================== -->

        <?php if (session()->getFlashdata('errors')): ?>

            <div class="alert alert-danger">

                <strong>
                    Please correct the following:
                </strong>

                <ul class="mb-0 mt-2">

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



        <!-- =====================================================
             PROFILE CARD
        ====================================================== -->

        <div class="card profile-card shadow-sm">


            <!-- Header -->

            <div class="profile-header">

                <div class="d-flex align-items-center gap-3">


                    <div class="profile-avatar">

                        <?= strtoupper(
                            substr(
                                $user['name'] ?? 'U',
                                0,
                                1
                            )
                        ) ?>

                    </div>


                    <div>

                        <h5 class="fw-bold mb-1">

                            <?= esc($user['name']) ?>

                        </h5>


                        <p class="text-muted mb-0">

                            <?= esc(
                                $user['designation']
                                ?? 'Examiner'
                            ) ?>

                        </p>

                    </div>

                </div>

            </div>



            <!-- Body -->

            <div class="profile-body">


                <form
                    action="<?= base_url('profile/update') ?>"
                    method="post"
                >

                    <?= csrf_field() ?>



                    <!-- =================================================
                         PERSONAL INFORMATION
                    ================================================== -->

                    <div class="section-title">

                        <i class="bi bi-person me-2"></i>

                        Personal Information

                    </div>


                    <div class="row g-4">


                        <!-- Full Name -->

                        <div class="col-md-6">

                            <label
                                for="name"
                                class="form-label"
                            >

                                Full Name

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="<?= esc(
                                    old(
                                        'name',
                                        $user['name'] ?? ''
                                    )
                                ) ?>"
                                required
                            >

                        </div>



                        <!-- Email -->

                        <div class="col-md-6">

                            <label
                                for="email"
                                class="form-label"
                            >

                                Email Address

                            </label>


                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-envelope"></i>

                                </span>


                                <input
                                    type="email"
                                    class="form-control readonly-field"
                                    id="email"
                                    value="<?= esc(
                                        $user['email'] ?? ''
                                    ) ?>"
                                    readonly
                                >


                                <span class="input-group-text">

                                    <i class="bi bi-lock"></i>

                                </span>

                            </div>


                            <div class="email-lock mt-1">

                                <i class="bi bi-info-circle me-1"></i>

                                Email address cannot be changed.

                            </div>

                        </div>



                        <!-- Organization -->

                        <div class="col-md-6">

                            <label
                                for="organization"
                                class="form-label"
                            >

                                Organization / Institute

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="organization"
                                name="organization"
                                value="<?= esc(
                                    old(
                                        'organization',
                                        $user['organization'] ?? ''
                                    )
                                ) ?>"
                                required
                            >

                        </div>



                        <!-- Designation -->

                        <div class="col-md-6">

                            <label
                                for="designation"
                                class="form-label"
                            >

                                Designation

                            </label>


                            <input
                                type="text"
                                class="form-control"
                                id="designation"
                                name="designation"
                                value="<?= esc(
                                    old(
                                        'designation',
                                        $user['designation'] ?? ''
                                    )
                                ) ?>"
                                required
                            >

                        </div>



                        <!-- Mobile -->

                        <div class="col-md-6">

                            <label
                                for="mobile"
                                class="form-label"
                            >

                                Mobile Number

                            </label>


                            <input
                                type="tel"
                                class="form-control"
                                id="mobile"
                                name="mobile"
                                value="<?= esc(
                                    old(
                                        'mobile',
                                        $user['mobile'] ?? ''
                                    )
                                ) ?>"
                                maxlength="15"
                                required
                            >

                        </div>

                    </div>



                    <!-- =================================================
                         PASSWORD
                    ================================================== -->

                    <hr class="my-5">


                    <div class="section-title">

                        <i class="bi bi-shield-lock me-2"></i>

                        Change Password

                    </div>


                    <p class="text-muted small mb-4">

                        Leave these fields empty if you do not want
                        to change your password.

                    </p>


                    <div class="row g-4">


                        <!-- New Password -->

                        <div class="col-md-6">

                            <label
                                for="new_password"
                                class="form-label"
                            >

                                New Password

                            </label>


                            <input
                                type="password"
                                class="form-control"
                                id="new_password"
                                name="new_password"
                                placeholder="Enter new password"
                            >

                        </div>



                        <!-- Confirm Password -->

                        <div class="col-md-6">

                            <label
                                for="confirm_password"
                                class="form-label"
                            >

                                Confirm Password

                            </label>


                            <input
                                type="password"
                                class="form-control"
                                id="confirm_password"
                                name="confirm_password"
                                placeholder="Confirm new password"
                            >

                        </div>

                    </div>



                    <!-- =================================================
                         ACTIONS
                    ================================================== -->

                    <div class="d-flex justify-content-end gap-2 mt-5">


                        <a
                            href="<?= base_url('dashboard') ?>"
                            class="btn btn-outline-secondary"
                        >

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary px-4"
                        >

                            <i class="bi bi-check-circle me-1"></i>

                            Update Profile

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>

<?= view('layouts/footer') ?>

<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>