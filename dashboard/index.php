<?php

    require "../vendor/autoload.php";
    require "../core/index.php";

    if (User::IsAuthenticated())
    {
        $products = User::Products($_SESSION['user_id']);
    }
    else
    {
        header("Location: ../login");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/dashboard.css">
    <script src="../assets/js/font_awesome_main.js"></script>
    <title>Stocksense Dashboard</title>

</head>
<body>

    <main>

        <div class="side-bar">

            <ul>
                <li><a href="./"> <i class="fas fa-home"></i> Dashboard </a></li>
                <li><a href="./api_key/"> <i class="fas fa-key"></i> API Key </a></li>

                <li><a href="./edit/"><i class="fas fa-pencil-alt"></i> Edit Profile </a></li>
                <li><a href="./stock/"> <i class="fas fa-boxes"></i> Manage Stock </a></li>
                <li><a href="./orders/"> <i class="fas fa-truck"></i> Manage Orders </a></li>
                <li><a href="./sales/"> <i class="far fa-chart-bar"></i> Manage Sales </a></li>

                <li><a href="../logout/"> <i class="fas fa-sign-out-alt"></i> Log Out</a></li>
            </ul>
        </div>

        <div class="dashboard-area">

            <div class="overview">

                <div class="cta">

                    <div class="cta-item">

                        <i class="fas fa-key"></i>

                        <h3 class="text-primary">My API Key </h3>

                        <a href="./api_key/" class="btn-primary-bordered"> View </a>
                    </div>


                    <div class="cta-item">
                        <i class="fas fa-boxes"></i>

                        <h3 class="text-primary">My Products</h3>

                        <a href="./stock/" class="btn-primary-bordered"> Manage </a>
                    </div>


                    <div class="cta-item">
                        <i class="fas fa-truck"></i>

                        <h3 class="text-primary">Manage Orders</h3>

                        <a href="./orders/" class="btn-primary-bordered"> View </a>
                    </div>


                    <div class="cta-item">
                        <i class="fas fa-dollar-sign"></i>

                        <h3 class="text-primary">Sales </h3>

                        <a href="./sales/" class="btn-primary-bordered"> Manage </a>
                    </div>

                </div>

                <h4> My Overview </h4>

                <div class="grid-container">

                    <div class="card">
                        <i class="fas fa-boxes"></i>

                        <div>
                            <h3>100</h3>
                            <span>Products</span>
                        </div>


                    </div>

                    <div class="card">

                        <i class="fas fa-check-circle"></i>

                        <div>
                            <h3>29</h3>
                            <span>Available</span>
                        </div>

                    </div>

                    <div class="card">

                        <i class="far fa-chart-bar"></i>

                        <div>
                            <h3>50</h3>
                            <span>Purchases</span>
                        </div>


                    </div>


                    <div class="card">

                        <i class="fas fa-money-bill-wave"></i>

                        <div>
                            <h3>100,999</h3>
                            <span>Earned</span>
                        </div>


                    </div>


                    <i class=""></i>
                    </div>

                </div>


                </div>


            </div>
        </div>

    </main>

    <script src="../assets/js/menu.js"></script>

</body>
</html>