<?php
    require "../../vendor/autoload.php";
    require "../../core/index.php";

    $error = "";
    if (!User::IsAuthenticated())
    {
        header("Location:../../index.php");
    }
    else
    {
        $data = User::Data();

        if (isset($_POST['update']))
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if (User::Update($_SESSION['user_id'], $name, $email, $phone))
            {
                header("Location:../../dashboard/edit");
            }
            else
            {
                $error = "Could not update Profile";
            }

        }

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <script src="../../assets/js/font_awesome_main.js"></script>
    <title>Supplier Dashboard</title>

</head>
<body>

    <main>
        <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">

            <div class="edit-container">


                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <p class="text-red"><?php echo $error ?></p>
                    <h2 class="text-bold text-primary">Update Profile</h2>
                    <input type="text" placeholder="Name" value="<?php echo $data->name?>" required name="name">
                    <input type="email" placeholder="Email" value="<?php echo $data->email?>" required name="email">
                    <input type="text" placeholder="Phone Number" value="<?php echo $data->phone?>" required name="phone">

                    <button class="btn-gradient" name="update">Update Profile</button>

                </form>

            </div>

        </div>

    </main>

</body>
</html>