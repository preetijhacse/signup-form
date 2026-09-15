<?php

session_start();

if (
    !isset($_SESSION['terms_accepted']) ||
    $_SESSION['terms_accepted'] !== true
) {
    header("Location: index.php");
    exit;
}

$step = isset($_GET['step'])
    ? (int) $_GET['step']
    : 1;

if ($step < 1 || $step > 4) {
    $step = 1;
}

if (!isset($_SESSION['form'])) {

    $_SESSION['form'] = [
        'email' => '',
        'name' => '',
        'age' => '',
        'pronouns' => '',
        'state' => '',
        'city' => '',
        'college' => '',
        'phone' => ''
    ];
}

$form = $_SESSION['form'];
$errors = [];

$cities = [
    "Haryana" => [
        "Gurugram",
        "Faridabad",
        "Panipat",
        "Rohtak"
    ],

    "Delhi" => [
        "New Delhi",
        "North Delhi",
        "South Delhi"
    ],

    "Punjab" => [
        "Amritsar",
        "Ludhiana",
        "Jalandhar"
    ],

    "Rajasthan" => [
        "Jaipur",
        "Udaipur",
        "Jodhpur"
    ]
];

$colleges = [
    "Delhi University",
    "Amity University",
    "Manav Rachna University",
    "Gurugram University"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $form['email'] =
        trim($_POST['email'] ?? $form['email']);

    $form['name'] =
        trim($_POST['name'] ?? $form['name']);

    $form['age'] =
        trim($_POST['age'] ?? $form['age']);

    $form['pronouns'] =
        trim($_POST['pronouns'] ?? $form['pronouns']);

    $form['state'] =
        trim($_POST['state'] ?? $form['state']);

    $form['city'] =
        trim($_POST['city'] ?? $form['city']);

    $form['college'] =
        trim($_POST['college'] ?? $form['college']);

    $form['phone'] =
        trim($_POST['phone'] ?? $form['phone']);


    /* STEP 1 */

    if ($step === 1) {

        if ($form['email'] === '') {

            $errors['email'] =
                "Email is required.";

        } elseif (
            !filter_var(
                $form['email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors['email'] =
                "Please enter a valid email address.";
        }
    }


    /* STEP 2 */

    if ($step === 2) {

        if ($form['name'] === '') {

            $errors['name'] =
                "Name is required.";

        } elseif (strlen($form['name']) > 50) {

            $errors['name'] =
                "Name cannot exceed 50 characters.";
        }


        if ($form['age'] === '') {

            $errors['age'] =
                "Age is required.";

        } elseif (
            !ctype_digit($form['age'])
        ) {

            $errors['age'] =
                "Age must contain numbers only.";

        } elseif ((int)$form['age'] < 18) {

            $errors['age'] =
                "You must be at least 18 years old.";

        } elseif ((int)$form['age'] > 100) {

            $errors['age'] =
                "Please enter a valid age.";
        }


        if ($form['pronouns'] === '') {

            $errors['pronouns'] =
                "Please select your pronouns.";
        }
    }


    /* STEP 3 */

    if ($step === 3) {

        if ($form['state'] === '') {

            $errors['state'] =
                "Please select a state.";
        }

        if ($form['city'] === '') {

            $errors['city'] =
                "Please select a city.";
        }

        if ($form['college'] === '') {

            $errors['college'] =
                "Please select your college.";
        }
    }


    /* STEP 4 */

    if ($step === 4) {

        if ($form['phone'] === '') {

            $errors['phone'] =
                "Phone number is required.";

        } elseif (
            !preg_match(
                '/^[0-9]{10}$/',
                $form['phone']
            )
        ) {

            $errors['phone'] =
                "Enter a valid 10-digit phone number.";
        }
    }


    if (empty($errors)) {

        $_SESSION['form'] = $form;

        if ($step < 4) {

            header(
                "Location: signup.php?step="
                . ($step + 1)
            );

            exit;

        } else {

            $_SESSION['signup_complete'] = true;

            header("Location: success.php");

            exit;
        }

    } else {

        $_SESSION['form'] = $form;
    }
}

function errorMessage($errors, $field)
{
    if (isset($errors[$field])) {

        return
            '<span class="error-message">'
            . htmlspecialchars($errors[$field])
            . '</span>';
    }

    return '';
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

    <title>
        Signup - Step <?= $step ?>
    </title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="signup-page">

    <div class="signup-card">

        <div class="logo">
            NUBPACK
        </div>


        <!-- PROGRESS -->

        <div class="progress">

            <?php for ($i = 1; $i <= 4; $i++): ?>

                <div
                    class="
                        progress-number
                        <?= $i <= $step ? 'active' : '' ?>
                    "
                >
                    <?= $i < $step ? '✓' : $i ?>
                </div>

                <?php if ($i < 4): ?>

                    <div
                        class="
                            progress-line
                            <?= $i < $step ? 'active' : '' ?>
                        "
                    ></div>

                <?php endif; ?>

            <?php endfor; ?>

        </div>


        <form method="POST">


            <!-- STEP 1 -->

            <?php if ($step === 1): ?>

                <span class="step-label">
                    STEP 1 OF 4
                </span>

                <h1>
                    Let's get started
                </h1>

                <p>
                    Enter your email address to begin.
                </p>


                <div class="form-group">

                    <label>
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?= htmlspecialchars($form['email']) ?>"
                        placeholder="you@example.com"
                    >

                    <?= errorMessage($errors, 'email') ?>

                </div>

            <?php endif; ?>


            <!-- STEP 2 -->

            <?php if ($step === 2): ?>

                <span class="step-label">
                    STEP 2 OF 4
                </span>

                <h1>
                    Tell us about you
                </h1>

                <p>
                    Add some basic information.
                </p>


                <div class="form-group">

                    <label>
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        maxlength="50"
                        value="<?= htmlspecialchars($form['name']) ?>"
                        placeholder="Enter your name"
                    >

                    <?= errorMessage($errors, 'name') ?>

                </div>


                <div class="form-group">

                    <label>
                        Age
                    </label>

                    <input
                        type="number"
                        name="age"
                        min="18"
                        max="100"
                        value="<?= htmlspecialchars($form['age']) ?>"
                        placeholder="Enter your age"
                    >

                    <?= errorMessage($errors, 'age') ?>

                </div>


                <div class="form-group">

                    <label>
                        Pronouns
                    </label>

                    <select name="pronouns">

                        <option value="">
                            Select Pronouns
                        </option>

                        <?php

                        $pronouns = [
                            "He/Him",
                            "She/Her",
                            "They/Them",
                            "Prefer not to say"
                        ];

                        foreach ($pronouns as $pronoun):

                        ?>

                            <option
                                value="<?= $pronoun ?>"
                                <?= $form['pronouns'] === $pronoun
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= $pronoun ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?= errorMessage(
                        $errors,
                        'pronouns'
                    ) ?>

                </div>

            <?php endif; ?>


            <!-- STEP 3 -->

            <?php if ($step === 3): ?>

                <span class="step-label">
                    STEP 3 OF 4
                </span>

                <h1>
                    Where are you from?
                </h1>

                <p>
                    Tell us about your location and education.
                </p>


                <div class="form-group">

                    <label>
                        State
                    </label>

                    <select
                        name="state"
                        onchange="this.form.submit()"
                    >

                        <option value="">
                            Select State
                        </option>

                        <?php foreach (
                            $cities as $state => $cityList
                        ): ?>

                            <option
                                value="<?= htmlspecialchars($state) ?>"
                                <?= $form['state'] === $state
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($state) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?= errorMessage($errors, 'state') ?>

                </div>


                <div class="form-group">

                    <label>
                        City
                    </label>

                    <select name="city">

                        <option value="">
                            Select City
                        </option>

                        <?php

                        if (
                            $form['state'] &&
                            isset($cities[$form['state']])
                        ):

                            foreach (
                                $cities[$form['state']]
                                as $city
                            ):

                        ?>

                            <option
                                value="<?= htmlspecialchars($city) ?>"
                                <?= $form['city'] === $city
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($city) ?>
                            </option>

                        <?php

                            endforeach;

                        endif;

                        ?>

                    </select>

                    <?= errorMessage($errors, 'city') ?>

                </div>


                <div class="form-group">

                    <label>
                        College / University
                    </label>

                    <select name="college">

                        <option value="">
                            Select College
                        </option>

                        <?php foreach (
                            $colleges as $college
                        ): ?>

                            <option
                                value="<?= htmlspecialchars($college) ?>"
                                <?= $form['college'] === $college
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= htmlspecialchars($college) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?= errorMessage(
                        $errors,
                        'college'
                    ) ?>

                </div>

            <?php endif; ?>


            <!-- STEP 4 -->

            <?php if ($step === 4): ?>

                <span class="step-label">
                    STEP 4 OF 4
                </span>

                <h1>
                    Almost there!
                </h1>

                <p>
                    Add your phone number to complete
                    your profile.
                </p>


                <div class="form-group">

                    <label>
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        maxlength="10"
                        value="<?= htmlspecialchars($form['phone']) ?>"
                        placeholder="10 digit phone number"
                    >

                    <?= errorMessage(
                        $errors,
                        'phone'
                    ) ?>

                </div>


                <div class="summary">

                    <h3>Your Details</h3>

                    <p>
                        <strong>Email:</strong>
                        <?= htmlspecialchars($form['email']) ?>
                    </p>

                    <p>
                        <strong>Name:</strong>
                        <?= htmlspecialchars($form['name']) ?>
                    </p>

                    <p>
                        <strong>Location:</strong>
                        <?= htmlspecialchars($form['city']) ?>,
                        <?= htmlspecialchars($form['state']) ?>
                    </p>

                </div>

            <?php endif; ?>


            <div class="wizard-buttons">

                <?php if ($step > 1): ?>

                    <a
                        href="signup.php?step=<?= $step - 1 ?>"
                        class="back-btn"
                    >
                        ← Back
                    </a>

                <?php endif; ?>


                <button
                    type="submit"
                    class="primary-btn continue-btn"
                >
                    <?= $step === 4
                        ? 'Complete Profile'
                        : 'Continue' ?>
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>