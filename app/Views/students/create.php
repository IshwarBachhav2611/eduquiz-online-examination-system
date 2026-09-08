<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Student | EduQuiz</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {

            --primary: #2563EB;
            --primary-dark: #1D4ED8;

            --border: #E2E8F0;

            --text: #64748B;

            --heading: #0F172A;

            --background: #F8FAFC;

            --card: #FFFFFF;

        }

        body {

            background: var(--background);

            font-family:
                "Segoe UI",
                Arial,
                sans-serif;

            color: var(--heading);

        }

        .page {

            min-height: 100vh;

            padding: 45px 0 60px;

        }

        /* =====================================================
           PAGE HEADER
        ====================================================== */

        .page-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 30px;

        }

        .page-eyebrow {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            font-size: 13px;

            font-weight: 700;

            color: var(--primary);

            text-transform: uppercase;

            letter-spacing: .5px;

            margin-bottom: 8px;

        }

        .page-title {

            font-size: 34px;

            font-weight: 750;

            color: var(--heading);

            margin-bottom: 7px;

        }

        .page-subtitle {

            color: var(--text);

            margin: 0;

        }

        .back-btn {

            border-radius: 10px;

            padding: 10px 18px;

            font-weight: 600;

        }

        /* =====================================================
           MAIN CARDS
        ====================================================== */

        .student-card {

            background: var(--card);

            border: 1px solid var(--border);

            border-radius: 18px;

            box-shadow:
                0 10px 30px rgba(15, 23, 42, .05);

            height: 100%;

            overflow: hidden;

        }

        .card-header-custom {

            display: flex;

            align-items: center;

            gap: 14px;

            padding: 24px 26px;

            border-bottom: 1px solid var(--border);

        }

        .header-icon {

            width: 44px;

            height: 44px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #EFF6FF;

            color: var(--primary);

            font-size: 20px;

            flex-shrink: 0;

        }

        .card-header-custom h3 {

            font-size: 19px;

            font-weight: 700;

            margin: 0;

        }

        .card-header-custom p {

            color: var(--text);

            font-size: 14px;

            margin: 4px 0 0;

        }

        .card-body-custom {

            padding: 26px;

        }

        /* =====================================================
           FORM
        ====================================================== */

        .form-label {

            font-size: 14px;

            font-weight: 650;

            margin-bottom: 8px;

        }

        .required {

            color: #DC2626;

        }

        .input-wrapper {

            position: relative;

        }

        .input-wrapper i {

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #94A3B8;

            z-index: 2;

        }

        .input-wrapper .form-control {

            padding-left: 42px;

        }

        .form-control {

            border: 1px solid var(--border);

            border-radius: 11px;

            padding: 12px 14px;

            min-height: 46px;

            font-size: 14px;

        }

        .form-control:focus {

            border-color: var(--primary);

            box-shadow:
                0 0 0 .15rem rgba(37, 99, 235, .12);

        }

        .form-text {

            color: #94A3B8;

            font-size: 12px;

            margin-top: 6px;

        }

        /* =====================================================
           SECURITY INFO
        ====================================================== */

        .info-box {

            background: #F8FAFC;

            border: 1px solid var(--border);

            border-radius: 11px;

            padding: 13px 15px;

            color: #475569;

            font-size: 13px;

        }

        .info-box i {

            color: var(--primary);

        }

        /* =====================================================
           BUTTONS
        ====================================================== */

        .btn {

            border-radius: 10px;

            font-weight: 600;

        }

        .btn-primary {

            background: var(--primary);

            border-color: var(--primary);

        }

        .btn-primary:hover {

            background: var(--primary-dark);

            border-color: var(--primary-dark);

        }

        .form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 25px;

        }

        /* =====================================================
           SEARCH
        ====================================================== */

        .search-box {

            position: relative;

        }

        .search-box i {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #94A3B8;

        }

        .search-box input {

            padding-left: 43px;

        }

        .search-status {

            min-height: 22px;

            margin-top: 12px;

            font-size: 13px;

            color: var(--text);

        }

        /* =====================================================
           SEARCH RESULTS
        ====================================================== */

        .search-results {

            margin-top: 10px;

            max-height: 350px;

            overflow-y: auto;

        }

        .student-result {

            border: 1px solid var(--border);

            border-radius: 12px;

            padding: 14px;

            margin-bottom: 10px;

            transition: .2s ease;

            background: #fff;

        }

        .student-result:hover {

            border-color: #BFDBFE;

            background: #F8FBFF;

        }

        .student-result-main {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;

        }

        .student-info {

            min-width: 0;

        }

        .student-name {

            font-size: 14px;

            font-weight: 700;

            color: var(--heading);

        }

        .student-email {

            font-size: 13px;

            color: var(--text);

            margin-top: 3px;

            word-break: break-word;

        }

        .student-department {

            font-size: 12px;

            color: #94A3B8;

            margin-top: 3px;

        }

        .add-existing-btn {

            white-space: nowrap;

            font-size: 12px;

            padding: 7px 12px;

        }

        /* =====================================================
           EMPTY STATE
        ====================================================== */

        .empty-state {

            border: 1px dashed #CBD5E1;

            border-radius: 12px;

            padding: 30px 20px;

            text-align: center;

            background: #F8FAFC;

            color: var(--text);

        }

        .empty-state i {

            font-size: 28px;

            color: #94A3B8;

            margin-bottom: 10px;

        }

        .empty-state strong {

            display: block;

            color: #475569;

            margin-bottom: 4px;

        }

        .empty-state span {

            font-size: 13px;

        }

        /* =====================================================
           DIVIDER
        ====================================================== */

        .or-divider {

            display: flex;

            align-items: center;

            gap: 12px;

            margin: 22px 0;

            color: #94A3B8;

            font-size: 12px;

            font-weight: 600;

            text-transform: uppercase;

        }

        .or-divider::before,
        .or-divider::after {

            content: "";

            height: 1px;

            background: var(--border);

            flex: 1;

        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 991px) {

            .page {

                padding: 30px 0 50px;

            }

            .page-header {

                align-items: flex-start;

                gap: 20px;

            }

            .page-title {

                font-size: 28px;

            }

        }

        @media (max-width: 575px) {

            .page-header {

                flex-direction: column;

            }

            .back-btn {

                width: 100%;

            }

            .card-body-custom {

                padding: 20px;

            }

            .card-header-custom {

                padding: 20px;

            }

            .student-result-main {

                flex-direction: column;

                align-items: stretch;

            }

            .add-existing-btn {

                width: 100%;

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


<div class="page">

    <div class="container">


        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="page-header">

            <div>

                <span class="page-eyebrow">

                    <i class="bi bi-people-fill"></i>

                    Student Management

                </span>

                <h1 class="page-title">

                    Add Student

                </h1>

                <p class="page-subtitle">

                    Add a new student or find an existing EduQuiz student.

                </p>

            </div>


            <a
                href="<?= base_url('dashboard') ?>"
                class="btn btn-outline-secondary back-btn"
            >

                <i class="bi bi-arrow-left me-2"></i>

                Dashboard

            </a>

        </div>


        <?php

        $errors =
            session()->getFlashdata('errors') ?? [];

        ?>


        <!-- =====================================================
             ALERTS
        ====================================================== -->

        <?php if (session()->getFlashdata('success')): ?>

            <div class="alert alert-success">

                <i class="bi bi-check-circle-fill me-2"></i>

                <?= esc(session()->getFlashdata('success')) ?>

            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-circle-fill me-2"></i>

                <?= esc(session()->getFlashdata('error')) ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             SIDE BY SIDE
        ====================================================== -->

        <div class="row g-4">


            <!-- =================================================
                 LEFT
                 MANUAL ADD
            ================================================== -->

            <div class="col-lg-6">

                <div class="student-card">

                    <div class="card-header-custom">

                        <div class="header-icon">

                            <i class="bi bi-person-plus"></i>

                        </div>

                        <div>

                            <h3>Manually Add Student</h3>

                            <p>

                                Create a new student account.

                            </p>

                        </div>

                    </div>


                    <div class="card-body-custom">


                        <form
                            action="<?= base_url('students/store') ?>"
                            method="post"
                        >

                            <?= csrf_field() ?>


                            <!-- NAME -->

                            <div class="mb-4">

                                <label
                                    for="name"
                                    class="form-label"
                                >

                                    Student Name

                                    <span class="required">*</span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="bi bi-person"></i>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                        placeholder="Enter full name"
                                        value="<?= old('name') ?>"
                                        autocomplete="off"
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

                                    <span class="required">*</span>

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
                                        autocomplete="off"
                                    >

                                </div>


                                <div class="form-text">

                                    <i class="bi bi-info-circle me-1"></i>

                                    Email must be unique across EduQuiz.

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

                                    <span class="required">*</span>

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
                                        autocomplete="off"
                                    >

                                </div>


                                <?php if (isset($errors['department'])): ?>

                                    <div class="invalid-feedback d-block">

                                        <?= esc($errors['department']) ?>

                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- PASSWORD INFO -->

                            <div class="info-box mb-4">

                                <i class="bi bi-shield-lock-fill me-2"></i>

                                A secure password will be generated
                                automatically for the student.

                            </div>


                            <!-- ACTIONS -->

                            <div class="form-actions">

                                <a
                                    href="<?= base_url('dashboard') ?>"
                                    class="btn btn-light"
                                >

                                    Cancel

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="bi bi-person-plus me-1"></i>

                                    Add Student

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 RIGHT
                 SEARCH EXISTING
            ================================================== -->

            <div class="col-lg-6">

                <div class="student-card">

                    <div class="card-header-custom">

                        <div class="header-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <div>

                            <h3>Find Existing Student</h3>

                            <p>

                                Search by name or email.

                            </p>

                        </div>

                    </div>


                    <div class="card-body-custom">


                        <label
                            for="studentSearch"
                            class="form-label"
                        >

                            Search Student

                        </label>


                        <div class="search-box">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                id="studentSearch"
                                class="form-control"
                                placeholder="Start typing name or email..."
                                autocomplete="off"
                            >

                        </div>


                        <div
                            id="searchStatus"
                            class="search-status"
                        >

                            Type at least 2 characters to search.

                        </div>


                        <!-- =================================================
                             SEARCH RESULTS
                        ================================================== -->

                        <div
                            id="searchResults"
                            class="search-results"
                        >

                            <!-- Results will appear dynamically -->

                        </div>


                        <!-- =================================================
                             INITIAL EMPTY STATE
                        ================================================== -->

                        <div
                            id="searchEmpty"
                            class="empty-state"
                        >

                            <i class="bi bi-search"></i>

                            <strong>

                                Search for a student

                            </strong>

                            <span>

                                Matching students will appear here while
                                you type.

                            </span>

                        </div>


                    </div>

                </div>

            </div>


        </div>


    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const searchInput =
            document.getElementById('studentSearch');

        const resultsContainer =
            document.getElementById('searchResults');

        const emptyState =
            document.getElementById('searchEmpty');

        const status =
            document.getElementById('searchStatus');


        let timer;


        searchInput.addEventListener(
            'input',
            function () {


                const query =
                    this.value.trim();


                clearTimeout(timer);


                /*
                -----------------------------------------------------
                EMPTY SEARCH
                -----------------------------------------------------
                */

                if (query.length === 0) {

                    resultsContainer.innerHTML = '';

                    emptyState.style.display = 'block';

                    status.textContent =
                        'Type at least 2 characters to search.';

                    return;

                }


                /*
                -----------------------------------------------------
                MINIMUM CHARACTERS
                -----------------------------------------------------
                */

                if (query.length < 2) {

                    resultsContainer.innerHTML = '';

                    emptyState.style.display = 'block';

                    status.textContent =
                        'Keep typing...';

                    return;

                }


                /*
                -----------------------------------------------------
                LOADING
                -----------------------------------------------------
                */

                emptyState.style.display = 'none';

                resultsContainer.innerHTML = '';

                status.innerHTML =
                    '<i class="bi bi-arrow-repeat me-1"></i> Searching...';


                /*
                -----------------------------------------------------
                DEBOUNCE
                -----------------------------------------------------
                */

                timer = setTimeout(
                    function () {

                        fetch(
                            '<?= base_url('students/search') ?>?q='
                            + encodeURIComponent(query)
                        )

                        .then(
                            response => response.json()
                        )

                        .then(
                            students => {


                                resultsContainer.innerHTML = '';


                                /*
                                -------------------------------------
                                NO RESULTS
                                -------------------------------------
                                */

                                if (
                                    !students ||
                                    students.length === 0
                                ) {

                                    emptyState.style.display =
                                        'block';

                                    emptyState.innerHTML = `

                                        <i class="bi bi-person-x"></i>

                                        <strong>
                                            No matching student
                                        </strong>

                                        <span>
                                            No student found for
                                            "<strong>${escapeHtml(query)}</strong>".
                                            You can create a new student
                                            using the form on the left.
                                        </span>

                                    `;

                                    status.textContent =
                                        'No matching students found.';

                                    return;

                                }


                                /*
                                -------------------------------------
                                RESULTS
                                -------------------------------------
                                */

                                emptyState.style.display =
                                    'none';


                                status.innerHTML =

                                    '<i class="bi bi-check-circle me-1"></i>'
                                    + students.length
                                    + ' matching student'
                                    + (students.length > 1 ? 's' : '')
                                    + ' found.';


                                students.forEach(
                                    student => {


                                        const result =
                                            document.createElement('div');


                                        result.className =
                                            'student-result';


                                        result.innerHTML = `

                                            <div class="student-result-main">

                                                <div class="student-info">

                                                    <div class="student-name">

                                                        ${escapeHtml(student.name)}

                                                    </div>

                                                    <div class="student-email">

                                                        <i class="bi bi-envelope me-1"></i>

                                                        ${escapeHtml(student.email)}

                                                    </div>

                                                    <div class="student-department">

                                                        <i class="bi bi-building me-1"></i>

                                                        ${escapeHtml(student.department || 'Department not specified')}

                                                    </div>

                                                </div>


                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary add-existing-btn"
                                                    onclick="addExistingStudent(${student.id}, this)"
                                                >

                                                    <i class="bi bi-person-plus me-1"></i>

                                                    Add Student

                                                </button>

                                            </div>

                                        `;


                                        resultsContainer.appendChild(
                                            result
                                        );

                                    }
                                );

                            }
                        )

                        .catch(
                            error => {

                                console.error(error);

                                resultsContainer.innerHTML = '';

                                emptyState.style.display =
                                    'block';

                                emptyState.innerHTML = `

                                    <i class="bi bi-exclamation-triangle"></i>

                                    <strong>
                                        Unable to search
                                    </strong>

                                    <span>
                                        Something went wrong.
                                        Please try again.
                                    </span>

                                `;

                                status.textContent =
                                    'Search failed.';

                            }
                        );


                    },
                    300
                );

            }
        );


        /*
        =============================================================
        ESCAPE HTML
        =============================================================
        */

        function escapeHtml(value) {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;

        }


        window.escapeHtml =
            escapeHtml;

    }
);


/*
=====================================================================
ADD EXISTING STUDENT
=====================================================================
*/

function addExistingStudent(
    studentId,
    button
) {


    const originalText =
        button.innerHTML;


    button.disabled =
        true;


    button.innerHTML =

        '<span class="spinner-border spinner-border-sm me-1"></span>'
        + 'Adding...';


    fetch(
        '<?= base_url('students/add-existing/') ?>'
        + studentId,
        {

            method: 'POST',

            headers: {

                'X-Requested-With':
                    'XMLHttpRequest',

                'Content-Type':
                    'application/x-www-form-urlencoded'

            },

            body:
                '<?= csrf_token() ?>='
                + encodeURIComponent(
                    '<?= csrf_hash() ?>'
                )

        }
    )

    .then(
        response => {

            if (!response.ok) {

                throw new Error(
                    'Request failed'
                );

            }

            return response.json();

        }
    )

    .then(
        data => {


            if (data.success) {

                button.classList.remove(
                    'btn-outline-primary'
                );

                button.classList.add(
                    'btn-success'
                );


                button.innerHTML =

                    '<i class="bi bi-check-lg me-1"></i>'
                    + 'Added';


            } else {

                button.disabled =
                    false;

                button.innerHTML =
                    originalText;

                alert(
                    data.message ||
                    'Unable to add student.'
                );

            }

        }
    )

    .catch(
        error => {

            console.error(error);

            button.disabled =
                false;

            button.innerHTML =
                originalText;

            alert(
                'Unable to add student. Please try again.'
            );

        }
    );

}

</script>


</body>

</html>