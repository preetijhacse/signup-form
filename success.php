<?php

session_start();

if (
    !isset($_SESSION['signup_complete']) ||
    $_SESSION['signup_complete'] !== true
) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Profile Completed</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="center-page">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <h1>
            Profile Completed!
        </h1>

        <p>
            Your profile has been successfully created.
        </p>

        <a
            href="index.php"
            class="primary-btn full"
        >
            Back to Home
        </a>

    </div>

</div>

</body>
</html>