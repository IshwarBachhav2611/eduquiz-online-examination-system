<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Share Examination | EduQuiz</title>


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


    <!-- Share Examination CSS -->

    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/share-exam.css') ?>"
    >

</head>


<body>


<div class="share-exam-page">

    <div class="container">


        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="page-header d-flex justify-content-between align-items-start">

            <div>

                <span class="page-eyebrow">

                    <i class="bi bi-send"></i>

                    Examination Sharing

                </span>


                <h1>Share Examination</h1>


                <p>
                    Select the students who should receive an invitation
                    for this examination.
                </p>

            </div>


            <a
                href="<?= base_url('dashboard') ?>"
                class="btn btn-outline-secondary dashboard-btn"
            >

                <i class="bi bi-arrow-left"></i>

                Dashboard

            </a>

        </div>



        <!-- =====================================================
             EXAM SUMMARY
        ====================================================== -->

        <div class="share-card exam-summary-card">


            <div class="exam-summary-main">

                <div class="exam-summary-icon">

                    <i class="bi bi-file-earmark-text"></i>

                </div>


                <div>

                    <span class="summary-label">
                        Examination
                    </span>


                    <h3>
                        <?= esc($exam['title']) ?>
                    </h3>


                    <p>
                        <?= esc($exam['subject']) ?>
                    </p>

                </div>

            </div>



            <div class="exam-summary-details">


                <!-- DATE -->

                <div class="summary-detail">

                    <div class="summary-detail-icon">

                        <i class="bi bi-calendar-event"></i>

                    </div>


                    <div>

                        <span>Exam Date</span>

                        <strong>
                            <?= date('d M Y', strtotime($exam['exam_date'])) ?>
                        </strong>

                    </div>

                </div>



                <!-- TIME -->

                <div class="summary-detail">

                    <div class="summary-detail-icon">

                        <i class="bi bi-clock"></i>

                    </div>


                    <div>

                        <span>Start Time</span>

                        <strong>
                            <?= date('h:i A', strtotime($exam['start_time'])) ?>
                        </strong>

                    </div>

                </div>



                <!-- DURATION -->

                <div class="summary-detail">

                    <div class="summary-detail-icon">

                        <i class="bi bi-hourglass-split"></i>

                    </div>


                    <div>

                        <span>Duration</span>

                        <strong>
                            <?= esc($exam['duration']) ?> Min
                        </strong>

                    </div>

                </div>

            </div>

        </div>



        <!-- =====================================================
             STUDENT SELECTION CARD
        ====================================================== -->

        <div class="share-card student-selection-card">


            <!-- HEADER -->

            <div class="student-selection-header">


                <div>

                    <h3>

                        <i class="bi bi-people"></i>

                        Select Students

                    </h3>


                    <p>
                        Choose the students who can attend this examination.
                    </p>

                </div>



                <div class="student-header-actions">


                    <!-- ADD STUDENT -->

                    <a
                        href="<?= base_url('students/create') ?>"
                        class="btn btn-primary add-student-btn"
                    >

                        <i class="bi bi-person-plus"></i>

                        Add Students

                    </a>



                    <!-- UPLOAD STUDENTS -->

                    <button
                        type="button"
                        class="btn btn-outline-primary upload-student-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#uploadStudentsModal"
                    >

                        <i class="bi bi-upload"></i>

                        Upload Student List

                    </button>

                </div>

            </div>



            <?php if (!empty($students)): ?>


                <!-- =================================================
                     FILTERS
                ================================================== -->

                <div class="student-filters">


                    <!-- SEARCH -->

                    <div class="student-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="studentSearch"
                            class="form-control"
                            placeholder="Search by student name or email..."
                        >

                    </div>



                    <!-- DEPARTMENT FILTER -->

                    <div class="class-filter-wrapper">

                        <i class="bi bi-funnel"></i>

                        <select id="classFilter" class="form-select">

                            <option value="all">All Departments</option>

                            <?php

                            /*
                             * Create unique department list.
                             */

                            $departments = [];

                            foreach ($students as $student) {

                                if (!empty($student['department'])) {

                                    $departments[] = trim(
                                        $student['department']
                                    );

                                }

                            }

                            $departments = array_unique($departments);

                            natcasesort($departments);

                            ?>


                            <?php foreach ($departments as $department): ?>

                                <option value="<?= esc($department) ?>">

                                    <?= esc($department) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>



                <!-- =================================================
                     SHARE FORM
                ================================================== -->

                <form
                    action="<?= base_url('exams/share/' . $exam['id']) ?>"
                    method="post"
                    id="shareExamForm"
                >

                    <?= csrf_field() ?>



                    <!-- =============================================
                         SELECTION TOOLBAR
                    ============================================== -->

                    <div class="selection-toolbar">


                        <label class="select-all-label">

                            <input
                                type="checkbox"
                                id="selectAll"
                            >

                            <span>
                                Select All Visible Students
                            </span>

                        </label>



                        <div class="selected-info">

                            <strong id="selectedCount">
                                0
                            </strong>

                            <span>
                                student(s) selected
                            </span>

                        </div>

                    </div>



                    <!-- =================================================
                         STUDENT LIST
                    ================================================== -->

                    <div
                        class="student-list"
                        id="studentList"
                    >


                        <?php foreach ($students as $student): ?>


                            <label
                                class="student-item"
                                data-name="<?= esc($student['name']) ?>"
                                data-email="<?= esc($student['email']) ?>"
                                data-department="<?= esc($student['department'] ?? '') ?>"
                            >

                                <!-- CHECKBOX -->

                                <div class="student-check">

                                    <input
                                        type="checkbox"
                                        class="student-checkbox"
                                        name="students[]"
                                        value="<?= esc($student['id']) ?>"
                                        <?= in_array($student['id'], $selectedStudents ?? []) ? 'checked' : '' ?>
                                    >

                                </div>



                                <!-- AVATAR -->

                                <div class="student-avatar">

                                    <?= strtoupper(
                                        substr($student['name'], 0, 1)
                                    ) ?>

                                </div>



                                <!-- STUDENT INFORMATION -->

                                <div class="student-info">

                                    <strong>
                                        <?= esc($student['name']) ?>
                                    </strong>


                                    <span>
                                        <?= esc($student['email']) ?>
                                    </span>

                                </div>



                                <!-- DEPARTMENT -->

                                <div class="student-department">

                                    <i class="bi bi-building"></i>

                                    <?php if (!empty($student['department'])): ?>

                                        <?= esc($student['department']) ?>

                                    <?php else: ?>

                                        No Department

                                    <?php endif; ?>

                                </div>


                            </label>


                        <?php endforeach; ?>



                        <!-- =================================================
                             NO FILTER RESULT
                        ================================================== -->

                        <div
                            class="no-filter-result"
                            id="noFilterResult"
                            style="display:none;"
                        >

                            <div class="no-filter-icon">

                                <i class="bi bi-search"></i>

                            </div>


                            <h5>
                                No Students Found
                            </h5>


                            <p>
                                Try changing your search or department filter.
                            </p>

                        </div>

                    </div>



                    <!-- =================================================
                         ACTION AREA
                    ================================================== -->

                    <div class="share-actions">


                        <div class="share-note">

                            <i class="bi bi-info-circle"></i>

                            <span>
                                Invitations will be sent only to selected students.
                            </span>

                        </div>



                        <button
                            type="submit"
                            class="btn btn-primary share-exam-btn"
                            id="shareButton"
                            disabled
                        >

                            <i class="bi bi-send"></i>

                            Share Examination

                        </button>

                    </div>


                </form>



            <?php else: ?>


                <!-- =================================================
                     EMPTY STATE
                ================================================== -->

                <div class="students-empty-state">


                    <div class="students-empty-icon">

                        <i class="bi bi-people"></i>

                    </div>


                    <h4>
                        No Students Found
                    </h4>


                    <p>
                        Add students first before sharing this examination.
                    </p>



                    <div class="empty-state-actions">


                        <a
                            href="<?= base_url('students/create') ?>"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-person-plus"></i>

                            Add Students

                        </a>


                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#uploadStudentsModal"
                        >

                            <i class="bi bi-upload"></i>

                            Upload Student List

                        </button>

                    </div>

                </div>

            <?php endif; ?>


        </div>


    </div>

</div>



<!-- =============================================================
     UPLOAD STUDENTS MODAL
============================================================== -->

<div
    class="modal fade"
    id="uploadStudentsModal"
    tabindex="-1"
    aria-labelledby="uploadStudentsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            <!-- HEADER -->

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="uploadStudentsModalLabel"
                    >

                        <i class="bi bi-upload"></i>

                        Upload Student List

                    </h5>


                    <small class="text-muted">

                        Add multiple students using a CSV file.

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>



            <!-- FORM -->

            <form
                action="<?= base_url('students/import') ?>"
                method="post"
                enctype="multipart/form-data"
            >

                <?= csrf_field() ?>


                <div class="modal-body">


                    <!-- FILE -->

                    <div class="mb-3">

                        <label
                            for="studentFile"
                            class="form-label"
                        >

                            Student List

                        </label>


                        <input
                            type="file"
                            class="form-control"
                            id="studentFile"
                            name="student_file"
                            accept=".csv"
                            required
                        >


                        <div class="form-text">

                            Upload a CSV file containing student information.

                        </div>

                    </div>



                    <!-- EXPECTED FORMAT -->

                    <div class="upload-format-box">

                        <div class="upload-format-title">

                            <i class="bi bi-info-circle"></i>

                            CSV Format

                        </div>


                        <p>
                            The CSV should contain:
                        </p>


                        <code>
                            name,email,department
                        </code>

                    </div>

                </div>



                <!-- FOOTER -->

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-upload"></i>

                        Upload Students

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>



<!-- =============================================================
     BOOTSTRAP JS
============================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>



<!-- =============================================================
     PAGE JAVASCRIPT
============================================================== -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    const selectAll =
        document.getElementById('selectAll');

    const checkboxes =
        document.querySelectorAll('.student-checkbox');

    const selectedCount =
        document.getElementById('selectedCount');

    const shareButton =
        document.getElementById('shareButton');

    const searchInput =
        document.getElementById('studentSearch');

    const classFilter =
        document.getElementById('classFilter');

    const noFilterResult =
        document.getElementById('noFilterResult');


    /*
     * ============================================================
     * UPDATE SELECTION
     * ============================================================
     */

    function updateSelection() {

        const selected =
            document.querySelectorAll(
                '.student-checkbox:checked'
            ).length;


        if (selectedCount) {
            selectedCount.textContent = selected;
        }


        if (shareButton) {
            shareButton.disabled = selected === 0;
        }


        document
            .querySelectorAll('.student-item')
            .forEach(function (item) {

                const checkbox =
                    item.querySelector('.student-checkbox');

                if (!checkbox) {
                    return;
                }


                if (checkbox.checked) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }

            });


        updateSelectAll();

    }


    /*
     * ============================================================
     * UPDATE SELECT ALL
     * ============================================================
     */

    function updateSelectAll() {

        if (!selectAll) {
            return;
        }


        const visibleCheckboxes =
            Array.from(checkboxes)
                .filter(function (checkbox) {

                    const item =
                        checkbox.closest('.student-item');

                    return item &&
                           item.style.display !== 'none';

                });


        const checkedCheckboxes =
            visibleCheckboxes.filter(function (checkbox) {

                return checkbox.checked;

            });


        selectAll.checked =
            visibleCheckboxes.length > 0 &&
            visibleCheckboxes.length ===
            checkedCheckboxes.length;


        selectAll.indeterminate =
            checkedCheckboxes.length > 0 &&
            checkedCheckboxes.length <
            visibleCheckboxes.length;

    }


    /*
     * ============================================================
     * SELECT ALL VISIBLE STUDENTS
     * ============================================================
     */

    if (selectAll) {

        selectAll.addEventListener(
            'change',
            function () {

                document
                    .querySelectorAll('.student-item')
                    .forEach(function (item) {

                        if (
                            item.style.display !== 'none'
                        ) {

                            const checkbox =
                                item.querySelector(
                                    '.student-checkbox'
                                );


                            if (checkbox) {
                                checkbox.checked =
                                    selectAll.checked;
                            }

                        }

                    });


                updateSelection();

            }
        );

    }


    /*
     * ============================================================
     * INDIVIDUAL SELECTION
     * ============================================================
     */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            updateSelection
        );

    });


    /*
     * ============================================================
     * FILTER STUDENTS
     * ============================================================
     */

    function filterStudents() {

        const searchText =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : '';


        const selectedDepartment =
            classFilter
                ? classFilter.value
                    .toLowerCase()
                    .trim()
                : 'all';


        const studentItems =
            document.querySelectorAll(
                '.student-list .student-item'
            );


        let visibleStudents = 0;


        studentItems.forEach(function (item) {

            /*
             * Student name
             */

            const name =
                (
                    item.dataset.name || ''
                )
                .toLowerCase()
                .trim();


            /*
             * Student email
             */

            const email =
                (
                    item.dataset.email || ''
                )
                .toLowerCase()
                .trim();


            /*
             * IMPORTANT:
             * Use data-department
             * NOT data-class
             */

            const department =
                (
                    item.dataset.department || ''
                )
                .toLowerCase()
                .trim();


            /*
             * Search matching
             */

            const matchesSearch =
                searchText === '' ||
                name.includes(searchText) ||
                email.includes(searchText);


            /*
             * Department matching
             */

            const matchesDepartment =
                selectedDepartment === 'all' ||
                department === selectedDepartment;


            /*
             * Final result
             */

            const shouldShow =
                matchesSearch &&
                matchesDepartment;


            if (shouldShow) {

                item.style.display = 'flex';

                visibleStudents++;

            } else {

                item.style.display = 'none';

            }

        });


        /*
         * ========================================================
         * NO STUDENTS FOUND
         * ========================================================
         */

        if (noFilterResult) {

            if (visibleStudents === 0) {

                noFilterResult.classList.add('show');

            } else {

                noFilterResult.classList.remove('show');

            }

        }


        /*
         * Update Select All after filtering
         */

        updateSelectAll();

    }


    /*
     * ============================================================
     * SEARCH
     * ============================================================
     */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterStudents
        );

    }


    /*
     * ============================================================
     * DEPARTMENT FILTER
     * ============================================================
     */

    if (classFilter) {

        classFilter.addEventListener(
            'change',
            filterStudents
        );

    }


    /*
     * ============================================================
     * INITIAL STATE
     * ============================================================
     */

    filterStudents();

    updateSelection();

});

</script>


</body>

</html>