<!-- =========================
     Footer
========================= -->

<footer class="bg-dark text-light mt-5">
    <div class="container py-4">

        <div class="row">

            <!-- Brand / Description -->
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="fw-bold">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    EduQuiz
                </h5>

                <p class="text-secondary mb-0">
                    A simple and secure online examination platform
                    for conducting exams and managing student results.
                </p>
            </div>

            <!-- Footer Links -->
            <div class="col-md-6 text-md-end">
                <h6 class="fw-bold mb-3">Quick Links</h6>

                <button
                    type="button"
                    class="btn btn-link text-light text-decoration-none p-0 me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#helpModal">
                    <i class="bi bi-question-circle me-1"></i>
                    Help
                </button>

                <button
                    type="button"
                    class="btn btn-link text-light text-decoration-none p-0 me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#contactModal">
                    <i class="bi bi-envelope me-1"></i>
                    Contact
                </button>

                <button
                    type="button"
                    class="btn btn-link text-light text-decoration-none p-0"
                    data-bs-toggle="modal"
                    data-bs-target="#aboutModal">
                    <i class="bi bi-info-circle me-1"></i>
                    About
                </button>
            </div>

        </div>

        <hr class="border-secondary my-4">

        <div class="text-center">
            <p class="text-secondary mb-0">
                &copy; <?= date('Y') ?> EduQuiz.
                All rights reserved.
            </p>
        </div>

    </div>
</footer>


<!-- =========================
     Help Modal
========================= -->

<div
    class="modal fade"
    id="helpModal"
    tabindex="-1"
    aria-labelledby="helpModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel">
                    <i class="bi bi-question-circle me-2"></i>
                    EduQuiz Help
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <h6 class="fw-bold">How to use EduQuiz?</h6>

                <p class="text-muted">
                    EduQuiz allows examiners to create online examinations,
                    add questions, assign exams to students and manage
                    examination results.
                </p>

                <hr>

                <h6 class="fw-bold">For Examiners</h6>

                <ul class="text-muted">
                    <li>Create and manage examinations.</li>
                    <li>Add multiple-choice questions.</li>
                    <li>Publish examinations.</li>
                    <li>Assign examinations to students.</li>
                    <li>Manage student performance and results.</li>
                </ul>

                <h6 class="fw-bold mt-3">For Students</h6>

                <ul class="text-muted">
                    <li>Login using your student account.</li>
                    <li>View assigned examinations.</li>
                    <li>Start an available examination.</li>
                    <li>Complete the examination within the given time.</li>
                    <li>View your examination result after submission.</li>
                </ul>

                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    If you are unable to access an examination,
                    please contact your examiner.
                </div>

            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>

    </div>
</div>


<!-- =========================
     Contact Modal
========================= -->

<div
    class="modal fade"
    id="contactModal"
    tabindex="-1"
    aria-labelledby="contactModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="contactModalLabel">
                    <i class="bi bi-envelope me-2"></i>
                    Contact Us
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p class="text-muted">
                    Need assistance with EduQuiz? You can contact
                    the system administrator or your examiner.
                </p>

                <div class="mb-3">
                    <div class="d-flex align-items-center">

                        <div class="me-3">
                            <i class="bi bi-envelope-fill fs-4 text-primary"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Email
                            </small>

                            <strong>
                                ishwarbachhav2611@gmail.com
                            </strong>
                        </div>

                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex align-items-center">

                        <div class="me-3">
                            <i class="bi bi-telephone-fill fs-4 text-success"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <strong>
                                +91 7620593827
                            </strong>
                        </div>

                    </div>
                </div>

                <div>
                    <div class="d-flex align-items-center">

                        <div class="me-3">
                            <i class="bi bi-clock-fill fs-4 text-warning"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">
                                Support Hours
                            </small>

                            <strong>
                                Monday - Friday, 9:00 AM - 6:00 PM
                            </strong>
                        </div>

                    </div>
                </div>

                <hr>

                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    For examination-related issues, contact your
                    respective examiner.
                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>
</div>


<!-- =========================
     About Modal
========================= -->

<div
    class="modal fade"
    id="aboutModal"
    tabindex="-1"
    aria-labelledby="aboutModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="aboutModalLabel">
                    <i class="bi bi-info-circle me-2"></i>
                    About EduQuiz
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body text-center">

                <div class="mb-3">

                    <i class="bi bi-mortarboard-fill text-primary"
                       style="font-size: 3rem;"></i>

                </div>

                <h4 class="fw-bold">
                    EduQuiz
                </h4>

                <p class="text-muted">
                    Online Examination & Result Management System
                </p>

                <p>
                    EduQuiz is an online examination platform designed
                    to simplify the process of creating, conducting and
                    managing examinations.
                </p>

                <div class="row mt-4">

                    <div class="col-4">
                        <i class="bi bi-pencil-square text-primary fs-3"></i>
                        <small class="d-block mt-2">
                            Create Exams
                        </small>
                    </div>

                    <div class="col-4">
                        <i class="bi bi-people text-success fs-3"></i>
                        <small class="d-block mt-2">
                            Manage Students
                        </small>
                    </div>

                    <div class="col-4">
                        <i class="bi bi-bar-chart text-warning fs-3"></i>
                        <small class="d-block mt-2">
                            View Results
                        </small>
                    </div>

                </div>

                <hr>

                <small class="text-muted">
                    Version 1.0
                </small>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>
</div>