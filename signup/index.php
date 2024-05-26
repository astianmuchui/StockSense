<?php

    require "../vendor/autoload.php";
    require "../core/index.php";
    $error = "";

    if (isset($_POST['signup']))
    {
        if (User::Exists($_POST['email']))
        {
            $error = "User already exists";
        }
        else
        {
            User::Create($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password']);
            header("Location: ../dashboard");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/style.css">
    <title>Stocksense | Signup</title>
</head>
<body>
    <?php include('../partials/header.php') ?>
    <main>
        <div class="auth signup">
            <h2 class="text-primary text-bold">Let's Get Started</h3>
            <p class="text-red"> <?php echo $error ?> </p>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <input type="text" placeholder="Full Name" name="name" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <input type="phone" placeholder="Phone Number" name="phone" required>
                <button type="submit" class="btn-gradient" name="signup"> Submit </button>
            </form>
        </div>
    </main>

</body>
</html>