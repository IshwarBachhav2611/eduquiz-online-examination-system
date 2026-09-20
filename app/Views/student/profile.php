<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Profile | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        :root {
            --primary: #2563eb;
            --primary-light: #eff6ff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --background: #f8fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text-dark);
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        .navbar {
            height: 68px;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary) !important;
            letter-spacing: -0.4px;
        }

        .navbar-student {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
        }

        .student-name {
            font-size: 14px;
            font-weight: 600;
        }

        .dropdown-menu {
            min-width: 230px;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 9px 10px;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        .dropdown-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .page-wrapper {
            max-width: 1050px;
            margin: 0 auto;
            padding: 42px 20px 60px;
        }

        .page-heading {
            margin-bottom: 28px;
        }

        .page-heading h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.6px;
            margin-bottom: 6px;
        }

        .page-heading p {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .profile-header-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .profile-user {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .profile-avatar {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }

        .profile-name {
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .profile-email {
            color: var(--text-muted);
            font-size: 14px;
        }

        .student-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 9px;
            padding: 5px 10px;
            border-radius: 20px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
        }

        .content-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
        }

        .card-section {
            padding: 30px;
        }

        .card-section + .card-section {
            border-top: 1px solid var(--border);
        }

        .section-heading {
            margin-bottom: 22px;
        }

        .section-heading h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .section-heading p {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control {
            height: 46px;
            border-color: #dbe2ea;
            border-radius: 9px;
            font-size: 14px;
            padding: 10px 13px;
        }

        .form-control:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .input-group .form-control {
            border-left: 0;
        }

        .input-group-text {
            background: #ffffff;
            border-color: #dbe2ea;
            color: #64748b;
            border-radius: 9px 0 0 9px;
        }

        .readonly-field {
            background: #f1f5f9 !important;
            color: #64748b;
            cursor: not-allowed;
        }

        .email-note {
            color: var(--text-muted);
            font-size: 12px;
            margin-top: 7px;
        }

        .account-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .account-item {
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: #fafbfc;
        }

        .account-label {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .account-value {
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #64748b;
            padding: 5px 8px;
            z-index: 5;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .password-note {
            color: var(--text-muted);
            font-size: 12px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 25px;
        }

        .btn {
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 17px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .password-section {
            border-top: 1px solid var(--border);
            margin-top: 30px;
            padding-top: 30px;
        }

        .site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border);
            padding: 22px 0;
            margin-top: 10px;
        }

        .site-footer p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            margin: 0 8px;
            transition: 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        @media (max-width: 768px) {

            .page-wrapper {
                padding: 28px 15px 45px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .profile-header-card {
                padding: 22px;
            }

            .profile-header {
                align-items: flex-start;
            }

            .profile-user {
                align-items: flex-start;
            }

            .profile-avatar {
                width: 62px;
                height: 62px;
                font-size: 26px;
            }

            .card-section {
                padding: 22px;
            }

            .account-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
            }
        }

    </style>

</head>


<body>


<!-- =========================================================
     NAVBAR
========================================================= -->

<nav class="navbar navbar-expand-lg bg-white border-bottom">

    <div class="container">

        <a
            href="<?= base_url('/student/exams') ?>"
            class="navbar-brand"
        >

            <i class="bi bi-mortarboard-fill me-2"></i>

            EduQuiz

        </a>


        <div class="dropdown">

            <button
                class="btn border-0 p-0 navbar-student"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <div class="navbar-avatar">

                    <?= strtoupper(
                        substr(
                            session('student_name') ?? 'S',
                            0,
                            1
                        )
                    ) ?>

                </div>


                <span class="student-name d-none d-sm-block">

                    <?= esc(session('student_name')) ?>

                </span>


                <i class="bi bi-chevron-down small text-muted"></i>

            </button>


            <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                <li class="px-2 py-2">

                    <div class="fw-semibold small">

                        <?= esc(session('student_name')) ?>

                    </div>


                    <div class="text-muted small">

                        <?= esc(session('student_email')) ?>

                    </div>

                </li>


                <li>

                    <hr class="dropdown-divider">

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="<?= base_url('/student/exams') ?>"
                    >

                        <i class="bi bi-journal-text me-2"></i>

                        My Examinations

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item active"
                        href="<?= base_url('/student/profile') ?>"
                    >

                        <i class="bi bi-person me-2"></i>

                        My Profile

                    </a>

                </li>


                <li>

                    <hr class="dropdown-divider">

                </li>


                <li>

                    <a
                        class="dropdown-item text-danger"
                        href="<?= base_url('/student/logout') ?>"
                    >

                        <i class="bi bi-box-arrow-right me-2"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="page-wrapper">


    <div class="page-heading">

        <h1>My Profile</h1>

        <p>
            Manage your personal information and account details.
        </p>

    </div>


    <!-- =====================================================
         FLASH MESSAGES
    ====================================================== -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success mb-4">

            <i class="bi bi-check-circle me-2"></i>

            <?= esc(session()->getFlashdata('success')) ?>

        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger mb-4">

            <i class="bi bi-exclamation-circle me-2"></i>

            <?= esc(session()->getFlashdata('error')) ?>

        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('errors')): ?>

        <div class="alert alert-danger mb-4">

            <div class="fw-semibold mb-2">

                Please fix the following:

            </div>


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


    <!-- =====================================================
         PROFILE HEADER
    ====================================================== -->

    <div class="profile-header-card">

        <div class="profile-header">

            <div class="profile-user">

                <div class="profile-avatar">

                    <i class="bi bi-person-fill"></i>

                </div>


                <div>

                    <div class="profile-name">

                        <?= esc($student['name']) ?>

                    </div>


                    <div class="profile-email">

                        <?= esc($student['email']) ?>

                    </div>


                    <div class="student-badge">

                        <i class="bi bi-person-badge"></i>

                        Student

                    </div>

                </div>

            </div>


            <?php if (
                ($student['status'] ?? '') === 'Active'
            ): ?>

                <span
                    class="badge rounded-pill text-bg-success px-3 py-2"
                >

                    <i class="bi bi-check-circle me-1"></i>

                    Active

                </span>

            <?php else: ?>

                <span
                    class="badge rounded-pill text-bg-secondary px-3 py-2"
                >

                    <?= esc(
                        $student['status'] ?? 'Inactive'
                    ) ?>

                </span>

            <?php endif; ?>

        </div>

    </div>


    <!-- =====================================================
         PROFILE FORM
    ====================================================== -->

    <div class="content-card">

        <div class="card-section">

            <div class="section-heading">

                <h2>

                    <i class="bi bi-person me-2 text-primary"></i>

                    Personal Information

                </h2>


                <p>

                    Keep your personal details up to date.

                </p>

            </div>


            <form
                action="<?= base_url('/student/profile/update') ?>"
                method="post"
            >

                <?= csrf_field() ?>


                <div class="row g-4">


                    <!-- Full Name -->

                    <div class="col-md-6">

                        <label
                            for="name"
                            class="form-label"
                        >

                            Full Name

                        </label>


                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-person"></i>

                            </span>


                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="<?= esc(
                                    old(
                                        'name',
                                        $student['name'] ?? ''
                                    )
                                ) ?>"
                                required
                            >

                        </div>

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
                                    $student['email'] ?? ''
                                ) ?>"
                                readonly
                                disabled
                            >

                            <span class="input-group-text">

                                <i class="bi bi-lock"></i>

                            </span>

                        </div>


                        <div class="email-note">

                            <i class="bi bi-info-circle me-1"></i>

                            Email address cannot be changed.

                        </div>

                    </div>


                    <!-- Department -->

                    <div class="col-md-6">

                        <label
                            for="department"
                            class="form-label"
                        >

                            Department

                        </label>


                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-building"></i>

                            </span>


                            <input
                                type="text"
                                class="form-control"
                                id="department"
                                name="department"
                                value="<?= esc(
                                    old(
                                        'department',
                                        $student['department'] ?? ''
                                    )
                                ) ?>"
                                required
                            >

                        </div>

                    </div>


                    <!-- Phone -->

                    <div class="col-md-6">

                        <label
                            for="phone"
                            class="form-label"
                        >

                            Phone Number

                        </label>


                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-telephone"></i>

                            </span>


                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="<?= esc(
                                    old(
                                        'phone',
                                        $student['phone'] ?? ''
                                    )
                                ) ?>"
                                placeholder="Enter phone number"
                                maxlength="15"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     PASSWORD SECTION
                ================================================== -->

                <div class="password-section">

                    <div class="section-heading">

                        <h2>

                            <i class="bi bi-shield-lock me-2 text-primary"></i>

                            Change Password

                        </h2>


                        <p>

                            Leave these fields empty if you don't
                            want to change your password.

                        </p>

                    </div>


                    <div class="row g-4">


                        <!-- New Password -->

                        <div class="col-md-6">

                            <label
                                for="new_password"
                                class="form-label"
                            >

                                New Password

                            </label>


                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="new_password"
                                    name="new_password"
                                    placeholder="Enter new password"
                                    minlength="6"
                                    maxlength="255"
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="newPasswordToggle"
                                    title="Show password"
                                >

                                    <i
                                        class="bi bi-eye"
                                        id="newPasswordIcon"
                                    ></i>

                                </button>

                            </div>

                        </div>


                        <!-- Confirm Password -->

                        <div class="col-md-6">

                            <label
                                for="confirm_password"
                                class="form-label"
                            >

                                Confirm Password

                            </label>


                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="confirm_password"
                                    name="confirm_password"
                                    placeholder="Confirm new password"
                                    minlength="6"
                                    maxlength="255"
                                >


                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="confirmPasswordToggle"
                                    title="Show password"
                                >

                                    <i
                                        class="bi bi-eye"
                                        id="confirmPasswordIcon"
                                    ></i>

                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- =================================================
                         ACCOUNT INFORMATION
                    ================================================== -->

                    <div class="mt-5">

                        <div class="section-heading">

                            <h2>

                                <i class="bi bi-person-vcard me-2 text-primary"></i>

                                Account Information

                            </h2>


                            <p>

                                Your account status and registered
                                account information.

                            </p>

                        </div>


                        <div class="account-grid">


                            <!-- Account Status -->

                            <div class="account-item">

                                <div class="account-label">

                                    Account Status

                                </div>


                                <div class="account-value">

                                    <?php if (
                                        ($student['status'] ?? '')
                                        === 'Active'
                                    ): ?>

                                        <span class="text-success">

                                            <i
                                                class="bi bi-check-circle-fill me-1"
                                            ></i>

                                            Active

                                        </span>

                                    <?php else: ?>

                                        <span class="text-secondary">

                                            <?= esc(
                                                $student['status']
                                                ?? 'Inactive'
                                            ) ?>

                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <!-- Registered Email -->

                            <div class="account-item">

                                <div class="account-label">

                                    Registered Email

                                </div>


                                <div class="account-value">

                                    <?= esc(
                                        $student['email'] ?? ''
                                    ) ?>

                                </div>

                            </div>


                        </div>

                    </div>


                    <!-- =================================================
                         ACTIONS
                    ================================================== -->

                    <div class="form-actions">

                        <a
                            href="<?= base_url('/student/exams') ?>"
                            class="btn btn-light border"
                        >

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-check2 me-1"></i>

                            Save Changes

                        </button>

                    </div>


                </div>

            </form>

        </div>

    </div>

</main>


<!-- =========================================================
     FOOTER
========================================================= -->

<?= view('layouts/footer') ?>

<!-- =========================================================
     BOOTSTRAP JS
========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<!-- =========================================================
     PASSWORD TOGGLE
========================================================= -->

<script>

    function setupPasswordToggle(
        inputId,
        buttonId,
        iconId
    ) {

        const input =
            document.getElementById(inputId);

        const button =
            document.getElementById(buttonId);

        const icon =
            document.getElementById(iconId);


        if (!input || !button || !icon) {
            return;
        }


        button.addEventListener(
            'click',
            function () {

                if (input.type === 'password') {

                    input.type = 'text';

                    icon.classList.remove('bi-eye');

                    icon.classList.add('bi-eye-slash');

                    button.title = 'Hide password';

                } else {

                    input.type = 'password';

                    icon.classList.remove('bi-eye-slash');

                    icon.classList.add('bi-eye');

                    button.title = 'Show password';

                }

            }
        );

    }


    setupPasswordToggle(
        'new_password',
        'newPasswordToggle',
        'newPasswordIcon'
    );


    setupPasswordToggle(
        'confirm_password',
        'confirmPasswordToggle',
        'confirmPasswordIcon'
    );

</script>


</body>

</html>