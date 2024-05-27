<?php
    require "../../core/index.php";
    require "../../vendor/autoload.php";
    $error = "";
    if (User::IsAuthenticated())
    {
        $orders = User::Orders($_SESSION['user_id']);
        $products = User::Products($_SESSION['user_id']);
        $categories = Categories::All();

        if(isset($_POST['add_order']))
        {
            if (Orders::Create(
                $_SESSION['user_id'],
                Products::GetId($_POST['product']),
                $_POST['qty'],
                $_POST['customer'],
                $_POST['phone'],
                $_POST['location'],
                $_POST['due_date']
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
                <h3 class="text-primary text-bold">Record New Order </h3>
                <small class="text-red"> <?php echo $error ?> </small>
                <input type="text" list="options" id="myInput" placeholder="Product Name" name="product">
                <datalist id="options">
                <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product->name ?>"> <?php echo $product->name ?> </option>
                    <?php endforeach ?>
                </datalist>
                <input type="number" placeholder="Quantity" name="qty" required>

                <input type="text" placeholder="Customer Name" name="customer" required> 
                <input type="text" placeholder="Customer Phone" name="phone" required> 

                <input type="text" placeholder="Location" name="location" required> 
                <label for="">Due Date</label>
                <input type="date" name="due_date" id="">

                <button type="submit" class="btn-gradient" name="add_order">Add Order</button>
            </form>
            </div>
    </div>

    <main>
        <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">

        <div class="micro-banner noshadow">
                <h4>My Orders </h4>

                <a href="#" class="btn-gradient" id="add-order" style="padding: 10px 20px;"> <i class="fas fa-plus text-light" style="margin-right: 5px; margin-top: 4px; font-size: 13px;"></i> Add </a>

            </div>
            <div class="products-container">

                <div class="products">


                    <div class="container">


                    <?php if (count($orders) == 0) : ?>
                        <div class="product">
                            <p style="letter-spacing: 1px;">Orders will appear here</p>
                        </div>
                    <?php endif ?>


                        <?php foreach ($orders as $order):?>

                        <div class="product">
                            <img src="../../assets/img/<?php echo Products::Get($order->product_id)->image_path ?>" alt="">
                            <p><?php echo Products::Get($order->product_id)->name ?></p>
                            <p>KES <?php echo Products::Get($order->product_id)->price ?></p>
                            <a href="./view?id=<?php echo bin2hex(base64_encode($order->id)) ?>"> View <i class="fas fa-arrow-right"></i> </a>
                        </div>
                        <?php endforeach ?>
                    </div>

                </div>

                <div class="stats y-start">



                </div>

            </div>
        </div>

    </main>
    <script>
        const modal = document.getElementById('modal');
        const addOrder = document.getElementById('add-order');
        const closer = document.getElementById('closer');
        modal.style.display = 'none';

        addOrder.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        closer.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    </script>
</body>
</html>