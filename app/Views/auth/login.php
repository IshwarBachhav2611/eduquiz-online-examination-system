<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Examiner Login | EduQuiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{

            background:#f5f7fb;
            font-family:'Segoe UI',sans-serif;

        }

        .login-card{

            border:none;
            border-radius:18px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);

        }

        .brand{

            color:#2563EB;
            font-weight:700;

        }

        .input-group-text{

            cursor:pointer;

        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card login-card">

                <div class="card-body p-5">

                    <h2 class="text-center brand">

                        EduQuiz

                    </h2>

                    <p class="text-center text-muted mb-4">

                        Examiner Login

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

                    <form method="post"
                          action="<?= site_url('login') ?>">

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                value="<?= old('email') ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="loginPassword"
                                    class="form-control"
                                    name="password"
                                    required>

                                <span
                                    class="input-group-text"
                                    onclick="togglePassword()">

                                    <i id="eye"
                                       class="bi bi-eye"></i>

                                </span>

                            </div>

                        </div>

                        <div class="d-flex justify-content-between mb-4">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="checkbox">

                                <label class="form-check-label">

                                    Remember Me

                                </label>

                            </div>

                            <a href="#">

                                Forgot Password?

                            </a>

                        </div>

                        <button
                            class="btn btn-primary w-100 py-2">

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        Don't have an account?

                        <a href="<?= site_url('register') ?>">

                            Register

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(){

    let input=document.getElementById("loginPassword");

    let eye=document.getElementById("eye");

    if(input.type=="password"){

        input.type="text";

        eye.classList.replace("bi-eye","bi-eye-slash");

    }else{

        input.type="password";

        eye.classList.replace("bi-eye-slash","bi-eye");

    }

}

</script>

</body>

</html>