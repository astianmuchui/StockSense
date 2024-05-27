<?php
    require "../../vendor/autoload.php";
    require "../../core/index.php";

    $error = "";

    if (User::IsAuthenticated())
    {
        $products = User::Products($_SESSION['user_id']);
        $error = "";
        $sales = User::Sales($_SESSION['user_id']);
        if(isset($_POST['add_sale']))
        {
            if (Sales::Create (
                $_SESSION['user_id'],
                Products::GetId($_POST['product']),
                $_POST['qty'],
                $_POST['customer'],
                $_POST['payment_method'],
                $_POST['payment_code'],
                $_POST['date']
            ))
            {
                header("Location: ./");
            }
            else
            {
                $error = "An error occurred";
            }
        }
    }
    else
    {
        header("Location: ../../login");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <script src="../../assets/js/font_awesome_main.js"></script>
    <title>Stocksense Dashboard</title>

</head>
<body>



    <div class="modal flex-column" id="modal">
        <div class="modal-content flex-column">
            <span id="closer" >&times;</span>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="" method="POST" enctype="multipart/form-data">
                <h3 class="text-primary text-bold">Record New Sale </h3>
                <small class="text-red"> <?php echo $error ?> </small>
                <input type="text" list="options" id="myInput" placeholder="Product Name" name="product">
                <datalist id="options">
                <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product->name ?>"> <?php echo $product->name ?> </option>
                    <?php endforeach ?>
                </datalist>
                <input type="number" placeholder="Quantity" name="qty" required>

                <input type="text" placeholder="Customer Name" name="customer" required> 
                <input type="text" placeholder="Payment Method" name="payment_method" required> 

                <input type="text" placeholder="Payment Code" name="payment_code" required> 
                <label for="">Date</label>
                <input type="date" name="date" id="">

                <button type="submit" class="btn-gradient" name="add_sale">Add Sale</button>
            </form>
            </div>
    </div>

    <main>
        <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">
        <div class="micro-banner noshadow">
                <h4>My Sales </h4>

                <a href="#" class="btn-gradient" id="add-sale" style="padding: 10px 20px;"> <i class="fas fa-plus text-light" style="margin-right: 5px; margin-top: 4px; font-size: 13px;"></i> Add </a>

            </div>
            <div class="products-container">

                <div class="products">

                    <div class="container">

                    <?php if (count($sales) == 0): ?>
                        <div class="product">
                            <p>Sales you add will appear here</p>
                        </div>
                    <?php endif ?>


                    <?php foreach ($sales as $sale): ?>
                        <div class="product">
                            <img src="../../assets/uploads/<?php echo Products::Get($sale->product_id)->image_path ?>" alt="">
                            <p><?php echo Products::Get($sale->product_id)->name ?></p>
                            <p>Kes <?php echo Products::Get($sale->product_id)->price * $sale->item_count ?></p>
                            <a href="./view?id=<?php echo bin2hex(base64_encode($sale->id)) ?>"> View <i class="fas fa-arrow-right"></i> </a>
                        </div>
                    <?php endforeach ?>

                    </div>

                </div>

                <div class="stats">

                    <div class="card">
                        <i class="fas fa-boxes"></i>
                        <h3>Count of Sales</h3>
                        <h3> <?php echo count($sales) ?> </h3>
                    </div>


                    <div class="card">
                        <i class="fas fa-money-bill-wave"></i>
                        <h3>Revenue</h3>
                        <h3> KES <?php echo User::Revenue($_SESSION['user_id']) ?> </h3>
                    </div>

                </div>

            </div>
        </div>

    </main>
    <script>
        const modal = document.getElementById('modal');
        const addSale = document.getElementById('add-sale');
        const closer = document.getElementById('closer');
        modal.style.display = 'none';

        addSale.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        closer.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    </script>
</body>
</html>