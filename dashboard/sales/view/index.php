<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/dashboard.css">
    <script src="../../../assets/js/font_awesome_main.js"></script>
    <title>Supplier Dashboard</title>

</head>
<body>

    <main>
        <?php include('../../partials/dashboard_nested.php') ?>

        <div class="dashboard-area">

            <div class="micro-banner">
                <h4>View Sale </h4>


                <a href="#" class="btn-red">  Delete</a>

            </div>

            <div class="view-container">

                <div class="grid-container">
                    <img src="../../../assets/img/pexels-castorly-stock-3682293.jpg" alt="">

                    <div class="info">
                        <small class="text-grey">Shoes</small>
                        <h3>Generic High Heels</h3>
                        <h5 class="text-grey">2 items</h5>

                        <h3 class="text-gold" >KES 5000</h3>

                        <h4>Reveiw</h4>

                        <small class="flex-row" style="width: max-content;"> <!-- Will transfer this to the css file -->
                                <i class="fas fa-star text-gold"></i><i class="fas fa-star text-gold"></i><i class="fas fa-star text-gold"></i><i class="fas fa-star text-gold"></i><i class="fas fa-star text-gold"></i>

                        </small>

                </div>

                    <div class="extra">

                        <h4 class="text-gold">Sale Details</h4>

                        <h5 class="text-grey"> <i class="fas fa-user text-primary"></i> Sebastian Muchui </h5>
                        <h5 class="text-grey"> <i class="fas fa-phone-alt text-primary"></i> 0797061691 </h5>
                        <h5 class="text-grey"> <i class="far fa-envelope text-primary"></i> sebastianmuchui79@gmail.com</h5>

                        <h5 class="text-grey"> <i class="fas fa-dollar-sign text-primary"></i> 4800 Earned</h5>
                        <h5 class="text-grey"> <i class="fas fa-calendar text-primary"></i> 2023-04-08</h5>


                    </div>
                </div>


            </div>

        </div>

    </main>

</body>
</html>