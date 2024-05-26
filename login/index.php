<?php

    require "../vendor/autoload.php";
    require "../core/index.php";
    $error = "";

    if (isset($_POST['login']))
    {
        if (User::Authenticate($_POST['email'], $_POST['password']))
        {
            header("Location: ../dashboard");
        }
        else
        {
            $error = "Invalid email or password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/style.css">
    <title>Stocksense | Login</title>
</head>
<body>

    <?php include('../partials/header.php') ?>

    <main>
        <div class="auth login">
            <h2 class="text-primary text-bold">Feels good to be back, right ?</h3>
            <p class="text-red"> <?php echo $error ?> </p>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <input type="email" placeholder="Email" name="email">
                <input type="password" placeholder="Password" name="password">
                <button type="submit" class="btn-gradient" name="login"> Login </button>
            </form>
        </div>
    </main>

</body>
</html>