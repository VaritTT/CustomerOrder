<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style_register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Register</title>

</head>

<body>
    <div class="background-register"></div>
    <div class="layout-register">
        <div class="container-register">
            <div class="register-banner"></div>
            <div class="register-box">
                <h1>Register</h1>
                <form method="POST" action="./controllers/register_process.php">
                    <?php if (isset($_SESSION['success'])) { ?>
                        <div>
                            <?php echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?></div>
                    <?php } ?>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username">
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email">
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input class="password-input" type="password" name="password" placeholder="Password">
                        <i style="cursor: pointer;" class="fa-solid fa-eye show-password"></i>
                    </div>
                    <div class="password-checklist">
                        <h6 class="checklist-title">Password should be</h6>

                        <div id="passwordStrength">
                            <ul class="list-group">
                                <li class="list-item" id="length">At least 8 characters long</li>
                                <li class="list-item" id="number">At least 1 number</li>
                                <li class="list-item" id="lowercase">At least 1 lowercase letter</li>
                                <li class="list-item" id="uppercase">At least 1 uppercase letter</li>
                                <li class="list-item" id="special">At least 1 special character</li>
                            </ul>
                        </div>
                    </div>

                    <div class="input-box">
                        <input class="confirm-password-input" type="password" name="confirm_password" placeholder="Confirm Password">
                        <i style="cursor: pointer;" class="fa-solid fa-eye show-confirm-password"></i>
                    </div>
                    <div style="display: none;" class="error-message password-not-match mb-4">Password do not match</div>

                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="error-message">
                            <?php echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?></div>
                    <?php } ?>
                    <div>
                        <input type="submit" value="Register" name="register" class="register-btn">
                    </div>

                    <!-- or -->
                    <div class="divider">
                        <hr class="divider-line">
                        <span class="divider-text">or</span>
                        <hr class="divider-line">
                    </div>

                    <!-- Google -->
                    <button class="gsi-material-button">
                        <div class="gsi-material-button-state"></div>
                        <div class="gsi-material-button-content-wrapper">
                            <div class="gsi-material-button-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                    <path fill="none" d="M0 0h48v48H0z"></path>
                                </svg>
                            </div>
                            <span class="gsi-material-button-contents">Continue with Google</span>
                            <span style="display: none;">Continue with Google</span>
                        </div>
                    </button>

                    <div class="login-content">
                        <p>Have an account? <a href="login.php">Login</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        let showPasswordBtn = document.querySelector(".show-password");
        let showConfirmPasswordBtn = document.querySelector(".show-confirm-password");
        let passwordInp = document.querySelector(".password-input");
        let confirmPasswordInp = document.querySelector(".confirm-password-input");
        let passwordChecklist = document.querySelectorAll('.list-item');
        let passwordMatch = document.querySelector('.password-not-match');
        let passwordChecklistGroup = document.querySelector('.list-group');
        let containerChecklist = document.querySelector('.password-checklist');


        console.log(passwordChecklist);

        showPasswordBtn.addEventListener('click', () => {
            showPasswordBtn.classList.toggle('fa-eye');
            showPasswordBtn.classList.toggle('fa-eye-slash');

            showConfirmPasswordBtn.classList.toggle('fa-eye');
            showConfirmPasswordBtn.classList.toggle('fa-eye-slash');

            passwordInp.type = passwordInp.type === 'password' ? 'text' : 'password';
            confirmPasswordInp.type = confirmPasswordInp.type === 'password' ? 'text' : 'password';
        });

        showConfirmPasswordBtn.addEventListener('click', () => {
            showPasswordBtn.classList.toggle('fa-eye');
            showPasswordBtn.classList.toggle('fa-eye-slash');

            showConfirmPasswordBtn.classList.toggle('fa-eye');
            showConfirmPasswordBtn.classList.toggle('fa-eye-slash');

            passwordInp.type = passwordInp.type === 'password' ? 'text' : 'password';
            confirmPasswordInp.type = confirmPasswordInp.type === 'password' ? 'text' : 'password';
        });


        passwordInp.addEventListener('input', () => {
            if (passwordInp.value != confirmPasswordInp.value && confirmPasswordInp.length > 0) {
                passwordMatch.style.display = "block";
                confirmPasswordInp.style.borderColor = "red";
            } else {
                passwordMatch.style.display = "none";
                confirmPasswordInp.style.borderColor = "black";
            }
            passwordChecklistGroup.style.color = "red";
            containerChecklist.style.display = "block";
            containerChecklist.style.transition = "all 2s";
        });

        confirmPasswordInp.addEventListener('input', () => {
            if (passwordInp.value != confirmPasswordInp.value) {
                passwordMatch.style.display = "block";
                confirmPasswordInp.style.borderColor = "red";
            } else {
                passwordMatch.style.display = "none";
                confirmPasswordInp.style.borderColor = "black";
            }
        });



        let validationRegex = [{
                regex: /.{8,}/ // อย่างน้อย 8 ตัวเลข
            },
            {
                regex: /\d/ // มีตัวเลขอย่างน้อย 1 ตัว
            },
            {
                regex: /[a-z]/ // มีตัวพิมพ์เล็กอย่างน้อย 1 ตัว
            },
            {
                regex: /[A-Z]/ // มีตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว
            },
            {
                regex: /[^A-Za-z0-9]/ // มีอักขระพิเศษอย่างน้อย 1 ตัว
            }
        ];

        passwordInp.addEventListener('keyup', () => {
            validationRegex.forEach((item, i) => {
                let isValid = item.regex.test(passwordInp.value);
                if (isValid) {
                    passwordChecklist[i].classList.add('checked');
                } else {
                    passwordChecklist[i].classList.remove('checked');
                }
            });
        });
    </script>
</body>

</html>