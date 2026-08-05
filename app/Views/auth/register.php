<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | EduQuiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f5f7fb;
            font-family:'Segoe UI',sans-serif;
        }

        .register-card{

            border:none;
            border-radius:18px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);

        }

        .brand{

            color:#2563eb;
            font-weight:700;

        }

        .input-group-text{

            cursor:pointer;
            background:#fff;

        }

        .strength{

            height:6px;
            border-radius:20px;
            background:#e9ecef;
            overflow:hidden;

        }

        .strength-bar{

            height:100%;
            width:0%;
            transition:.3s;

        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card register-card">

                <div class="card-body p-5">

                    <h2 class="fw-bold text-center brand">
                        EduQuiz
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Create your Examiner Account
                    </p>

                    <?php if(session()->getFlashdata('success')) : ?>

                        <div class="alert alert-success">

                            <?= session()->getFlashdata('success') ?>

                        </div>

                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')) : ?>

                        <div class="alert alert-danger">

                            <?= session()->getFlashdata('error') ?>

                        </div>

                    <?php endif; ?>

                    <form action="<?= site_url('register') ?>" method="post">

                        <?= csrf_field() ?>

                        <div class="row g-3">

                            <!-- Full Name -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        placeholder="Enter your full name"
                                        value="<?= old('name') ?>"
                                        required>

                                </div>

                                <small class="text-danger">
                                    <?= session('errors.name') ?>
                                </small>

                            </div>

                            <!-- Organization -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Organization / Institute
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-building"></i>
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="organization"
                                        placeholder="College / Company Name"
                                        value="<?= old('organization') ?>"
                                        required>

                                </div>

                                <small class="text-danger">
                                    <?= session('errors.organization') ?>
                                </small>

                            </div>

                            <!-- Designation -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Designation
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-briefcase"></i>
                                    </span>

                                    <select
                                        class="form-select"
                                        name="designation"
                                        required>

                                        <option value="">Select Designation</option>

                                        <option value="Professor" <?= old('designation')=='Professor'?'selected':'' ?>>
                                            Professor
                                        </option>

                                        <option value="Assistant Professor" <?= old('designation')=='Assistant Professor'?'selected':'' ?>>
                                            Assistant Professor
                                        </option>

                                        <option value="Lecturer" <?= old('designation')=='Lecturer'?'selected':'' ?>>
                                            Lecturer
                                        </option>

                                        <option value="Trainer" <?= old('designation')=='Trainer'?'selected':'' ?>>
                                            Trainer
                                        </option>

                                        <option value="HR" <?= old('designation')=='HR'?'selected':'' ?>>
                                            HR
                                        </option>

                                        <option value="Administrator" <?= old('designation')=='Administrator'?'selected':'' ?>>
                                            Administrator
                                        </option>

                                        <option value="Other" <?= old('designation')=='Other'?'selected':'' ?>>
                                            Other
                                        </option>

                                    </select>

                                </div>

                                <small class="text-danger">
                                    <?= session('errors.designation') ?>
                                </small>

                            </div>

                            <!-- Mobile -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Mobile Number
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-phone"></i>
                                    </span>

                                    <input
                                        type="tel"
                                        class="form-control"
                                        maxlength="10"
                                        name="mobile"
                                        placeholder="9876543210"
                                        value="<?= old('mobile') ?>"
                                        required>

                                </div>

                                <small class="text-danger">
                                    <?= session('errors.mobile') ?>
                                </small>

                            </div>

                            <!-- Email -->

                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Official Email
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>

                                    <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        placeholder="example@college.edu"
                                        value="<?= old('email') ?>"
                                        required>

                                </div>

                                <small class="text-danger">
                                    <?= session('errors.email') ?>
                                </small>

                            </div>

                            <!-- Password -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="Create Password"
                                        autocomplete="new-password"
                                        required>

                                    <span
                                        class="input-group-text"
                                        onclick="togglePassword('password',this)">

                                        <i class="bi bi-eye"></i>

                                    </span>

                                </div>

                                <div class="strength mt-2">

                                    <div
                                        class="strength-bar"
                                        id="strengthBar">
                                    </div>

                                </div>

                                <small
                                    id="strengthText"
                                    class="d-block mt-1">
                                </small>

                                <small class="text-danger d-block">
                                    <?= session('errors.password') ?>
                                </small>

                            </div>

                            <!-- Confirm Password -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Confirm Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="confirmPassword"
                                        class="form-control"
                                        name="confirm_password"
                                        placeholder="Confirm Password"
                                        autocomplete="new-password"
                                        required>

                                    <span
                                        class="input-group-text"
                                        onclick="togglePassword('confirmPassword',this)">

                                        <i class="bi bi-eye"></i>

                                    </span>

                                </div>

                                <small
                                    id="matchText"
                                    class="d-block mt-1">
                                </small>

                                <small class="text-danger d-block">
                                    <?= session('errors.confirm_password') ?>
                                </small>

                            </div>

                        </div>

                        <div class="form-check mt-4 mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="terms"
                                required>

                            <label
                                class="form-check-label"
                                for="terms">

                                I agree to the
                                <a href="#">Terms & Conditions</a>

                            </label>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2">

                            <i class="bi bi-person-plus-fill me-2"></i>

                            Create Account

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        Already have an account?

                        <a href="<?= base_url('login') ?>">
                            Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(id, element) {

    const input = document.getElementById(id);
    const icon = element.querySelector("i");

    if (input.type === "password") {

        input.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");

    } else {

        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");

    }

}

const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");

const strengthBar = document.getElementById("strengthBar");
const strengthText = document.getElementById("strengthText");
const matchText = document.getElementById("matchText");

function updateStrength() {

    let val = password.value;
    let score = 0;

    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    strengthBar.style.width = "0%";
    strengthText.innerHTML = "";

    if (val.length === 0) return;

    if (score <= 2) {

        strengthBar.style.width = "30%";
        strengthBar.style.background = "#dc3545";
        strengthText.className = "text-danger";
        strengthText.innerHTML = "Weak Password";

    } else if (score == 3) {

        strengthBar.style.width = "60%";
        strengthBar.style.background = "#ffc107";
        strengthText.className = "text-warning";
        strengthText.innerHTML = "Medium Password";

    } else if (score == 4) {

        strengthBar.style.width = "80%";
        strengthBar.style.background = "#0dcaf0";
        strengthText.className = "text-info";
        strengthText.innerHTML = "Good Password";

    } else {

        strengthBar.style.width = "100%";
        strengthBar.style.background = "#198754";
        strengthText.className = "text-success";
        strengthText.innerHTML = "Strong Password";

    }

}

function checkPasswordMatch() {

    if (confirmPassword.value === "") {

        matchText.innerHTML = "";
        return;

    }

    if (password.value === confirmPassword.value) {

        matchText.className = "text-success";
        matchText.innerHTML = "✓ Password matched";

    } else {

        matchText.className = "text-danger";
        matchText.innerHTML = "✗ Password does not match";

    }

}

password.addEventListener("input", function () {

    updateStrength();
    checkPasswordMatch();

});

confirmPassword.addEventListener("input", checkPasswordMatch);

</script>

</body>
</html>