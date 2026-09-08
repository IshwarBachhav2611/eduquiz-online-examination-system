<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            min-height: 100vh;
            background: #f8fafc;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
        }

        .login-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto;
        }

        .form-control {
            padding: 12px 14px;
        }

        .btn-login {
            padding: 12px;
            font-weight: 600;
        }

    </style>

</head>


<body>

<div class="login-wrapper">

    <div class="container px-3">

        <div class="login-card shadow-sm mx-auto">

            <div class="card-body p-4 p-md-5">


                <!-- Header -->

                <div class="text-center mb-4">

                    <div class="login-icon mb-3">

                        <i class="bi bi-mortarboard-fill"></i>

                    </div>

                    <h3 class="fw-bold mb-1">
                        Student Login
                    </h3>

                    <p class="text-muted mb-0">
                        Sign in to access your examinations.
                    </p>

                </div>


                <!-- Success -->

                <?php if (session()->getFlashdata('success')): ?>

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle me-2"></i>

                        <?= esc(session()->getFlashdata('success')) ?>

                    </div>

                <?php endif; ?>


                <!-- Error -->

                <?php if (session()->getFlashdata('error')): ?>

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-circle me-2"></i>

                        <?= esc(session()->getFlashdata('error')) ?>

                    </div>

                <?php endif; ?>


                <!-- Validation Errors -->

                <?php if (session()->getFlashdata('errors')): ?>

                    <div class="alert alert-danger">

                        <?php foreach (
                            session()->getFlashdata('errors')
                            as $error
                        ): ?>

                            <div>
                                <?= esc($error) ?>
                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>


                <!-- Login Form -->

                <form
                    action="<?= base_url('/student/login') ?>"
                    method="post"
                >

                    <?= csrf_field() ?>


                    <!-- Email -->

                    <div class="mb-3">

                        <label
                            for="email"
                            class="form-label fw-semibold"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Enter your email"
                            value="<?= old('email') ?>"
                            required
                            autofocus
                        >

                    </div>


                    <!-- Password -->

                    <div class="mb-4">

                        <label
                            for="password"
                            class="form-label fw-semibold"
                        >
                            Password
                        </label>

                        <div class="input-group">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter your password"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword()"
                            >

                                <i
                                    class="bi bi-eye"
                                    id="passwordIcon"
                                ></i>

                            </button>

                        </div>

                    </div>


                    <!-- Login -->

                    <button
                        type="submit"
                        class="btn btn-primary btn-login w-100"
                    >

                        <i class="bi bi-box-arrow-in-right me-1"></i>

                        Login

                    </button>

                </form>


                <!-- Footer -->

                <div class="text-center mt-4">

                    <small class="text-muted">
                        Exam credentials are provided by your examiner.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

function togglePassword()
{
    const password = document.getElementById('password');

    const icon = document.getElementById('passwordIcon');

    if (password.type === 'password') {

        password.type = 'text';

        icon.classList.remove('bi-eye');

        icon.classList.add('bi-eye-slash');

    } else {

        password.type = 'password';

        icon.classList.remove('bi-eye-slash');

        icon.classList.add('bi-eye');

    }
}

</script>

</body>

</html>