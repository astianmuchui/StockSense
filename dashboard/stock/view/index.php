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
                <h4>View Product </h4>

                <a href="#" class="btn-primary"> Edit</a>
                <a href="#" class="btn-red">  Delete</a>

            </div>

            <div class="view-container">

                <div class="grid-container">
                    <img src="../../../assets/img/pexels-castorly-stock-3682293.jpg" alt="">

                    <div class="info">
                        <small class="text-grey">Shoes</small>
                        <h3>Generic High Heels</h3>
                        <h3 class="text-gold" >KSH 2500</h3>
                        <small class="text-green">Available</small>

                        <small>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aliquam, id ad corporis dignissimos nesciunt ipsum laboriosam quis sequi dicta soluta molestias quia debitis vero impedit et, hic consequatur nam similique, facilis harum qui saepe. Nihil fugiat voluptatum ex dolor libero unde laborum soluta, quibusdam neque saepe qui quam possimus provident?</small>

                    </div>

                    <div class="extra">

                        <h4 class="text-gold">Product Overview</h4>

                        <h5 class="text-grey"> <i class="fas fa-check text-green"></i> 50 Orders </h5>
                        <h5 class="text-grey"> <i class="fas fa-check text-green"></i> 5 sales </h5>
                        <h5 class="text-grey"> <i class="fas fa-check text-green"></i> 5 In Cart</h5>
                        <h5 class="text-grey"> <i class="fas fa-dollar-sign text-green"></i> 50,000 Earned</h5>
                        <h5 class="text-grey"> <i class="fas fa-thumbs-up text-green"></i> 50 positive reveiws</h5>
                        <h5 class="text-grey"> <i class="fas fa-thumbs-down text-red"></i> 2 negative reveiws</h5>


                    </div>
                </div>


            </div>

        </div>

    </main>

</body>
</html>