<?php
session_start();

if (isset($_POST['start'])) {
    $_SESSION['signup_started'] = true;
    header("Location: terms.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Nubpack</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="landing">

    <nav class="navbar">
        <div class="logo">NUBPACK</div>
        <button class="login-btn">Login</button>
    </nav>

    <div class="hero">

        <div class="hero-content">

            <span class="small-title">WELCOME</span>

            <h1>
                Build your profile.<br>
                Connect with people.
            </h1>

            <p>
                Create your account and complete your profile
                in a few simple steps.
            </p>

            <form method="POST">
                <button
                    type="submit"
                    name="start"
                    class="primary-btn"
                >
                    Create Account →
                </button>
            </form>

        </div>

    </div>

</div>

</body>
</html>