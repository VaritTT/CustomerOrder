<?php
session_start();
if (isset($_SESSION['customer_id']) && $_SESSION['user_type'] == 'user') {
    die(header("Location: homepage_customer.php"));
} else if (isset($_SESSION['customer_id']) && $_SESSION['user_type'] == 'admin') {
    die(header("Location: ../admin/report_order_all.php"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <title>Login</title>
</head>

<body>
    <?php include './menu_user.php'; ?>
    <div class="background-login"></div>
    <div class="layout-login">
        <div class="container-login">
            <div class="login-banner"></div>
            <div class="login-box">
                <h1>Login</h1>
                <h3>to start ordering</h3>
                <form method="POST" action="./controllers/login_process.php">
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input class="password-input" type="password" name="password" placeholder="Password" required>
                        <i style="cursor: pointer;" class="fa-solid fa-eye show-password"></i>
                    </div>
                    <?php if (isset($_SESSION['err_msg'])) { ?>
                        <div class="error-message">
                            <?php echo $_SESSION['err_msg'];
                            unset($_SESSION['err_msg']);
                            ?></div>
                    <?php } ?>
                    <div>
                        <input type="submit" value="Login" name="login" class="login-btn">
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
                        <p>Don't have an account? <a href="register.php">Register</a></p>
                        <p>Continue as <a href="homepage_customer.php">Guest</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let showPasswordBtn = document.querySelector(".show-password");
        let passwordInp = document.querySelector(".password-input");

        showPasswordBtn.addEventListener('click', () => {
            showPasswordBtn.classList.toggle('fa-eye');
            showPasswordBtn.classList.toggle('fa-eye-slash');

            passwordInp.type = passwordInp.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>

</html>