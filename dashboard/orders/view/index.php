<?php
    require "../../../vendor/autoload.php";

    require "../../../core/index.php";
    $error = "";

    if (User::IsAuthenticated())
    {
        $id = base64_decode(hex2bin($_GET['id']));

        $order = Orders::Get($id);
        $product = Products::Get($order->product_id);

        if (isset($_POST['delete']))
        {
            if (Orders::Delete($id))
            {
                header("Location: ../");
            }
            else
            {
                $error = "An error occurred";
            }

        }

        if (isset($_POST['edit']))
        {
            if (Orders::Update(
                $id,
                Products::GetId($_POST['product']),
                $_POST['qty'],
                $_POST['customer'],
                $_POST['phone'],
                $_POST['location'],
                $_POST['due_date']
            ))
            {
                header("Location: ./?id=".$_GET['id']);

            }
            else
            {
                $error = "An error occurred";
            }
        }
    }
    else
    {
        header("Location: ../../../login");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/dashboard.css">
    <script src="../../../assets/js/font_awesome_main.js"></script>
    <title>Stocksense Dashboard</title>

</head>
<body>

    <div class="modal-z flex-column" id="modalz">
        <div class="modal-content flex-column x-start">
            <span id="closez" class="btn-red">&times;</span>
            <h1 class="text-red text-bold">Are you sure you want to take this action?</h1>
            <small class="text-red"> <?php echo $error ?> </small>
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'] ?>" method="post" enctype="multipart/form-data">

                <button type="submit" class="btn-red" name="delete"><i class="fas fa-trash"></i> Delete  </button>
            </form>
        </div>
    </div>

    <div class="modal flex-column" id="modal">
        <div class="modal-content flex-column">
            <span id="closer" >&times;</span>

            <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'] ?>" class="" method="POST" enctype="multipart/form-data">
                <h3 class="text-primary text-bold">Edit Product</h3>
                <small class="text-red"> <?php echo $error ?> </small>
                <input type="text" list="options" id="myInput" placeholder="Product Name" value="<?php echo $product->name ?>" name="product">
                <datalist id="options">
                <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product->name ?>"> <?php echo $product->name ?> </option>
                    <?php endforeach ?>
                </datalist>
                <input type="number" placeholder="Quantity" name="qty" required value="<?php echo $order->item_count ?>">

                <input type="text" placeholder="Customer Name" name="customer" value="<?php echo $order->customer_name ?>" required>
                <input type="text" placeholder="Customer Phone" name="phone" value="<?php echo $order->customer_phone ?>" required>

                <input type="text" placeholder="Location" name="location" value="<?php echo $order->location ?>" required>
                <label for="">Due Date</label>
                <input type="date" name="due_date" id="" value="<?php echo $order->due_date ?>">


                <button type="submit" class="btn-gradient" name="edit">Update Order</button>
            </form>
            </div>
        </div>



    <main>
        <?php include('../../partials/dashboard_nested.php') ?>

        <div class="dashboard-area">

            <div class="micro-banner">
                <h4>View Order </h4>


                <a href="#" class="btn-gradient" id="edit-order"> Edit</a>
                <a href="#" class="btn-red" id="delete">  Delete </a>

            </div>

            <div class="view-container">

                <div class="grid-container">
                    <img src="../../../assets/img/<?php echo $product->image_path ?>" alt="">

                    <div class="info">
                        <small class="text-grey"><?php echo Categories::Get($product->category)->name ?></small>
                        <h3><?php echo $product->name ?> </h3>
                        <h5 class="text-grey"><?php echo $order->item_count ?> items</h5>

                        <h3 class="text-primary" >KES <?php echo $product->price * $order->item_count ?></h3>

                    </div>

                    <div class="extra">

                        <h4 class="text-primary">Order Details</h4>

                        <h5 class="text-grey"> <i class="fas fa-map-marker text-primary"></i> <?php echo $order->location ?> </h5>

                        <h5 class="text-grey"> <i class="fas fa-user text-primary"></i> <?php echo $order->customer_name ?> </h5>
                        <h5 class="text-grey"> <i class="fas fa-phone-alt text-primary"></i> <?php echo $order->customer_phone ?> </h5>
                        <h5 class="text-grey"> <i class="fas fa-calendar text-primary"></i> Due <?php echo $order->due_date ?></h5>


                    </div>
                </div>


            </div>

        </div>

    </main>

    <script>

        const modal =  document.getElementById("modal")
        const modalz =  document.getElementById("modalz")
        modal.style.display = "none"
        modalz.style.display = "none"

        const edit = document.getElementById("edit-order")
        const delete_category = document.getElementById("delete")

        const closer = document.getElementById("closer")
        const closez = document.getElementById("closez")

        edit.addEventListener("click", () => {
            modal.style.display = "flex"
        })

        delete_category.addEventListener("click", () => {
            modalz.style.display = "flex"
        })

        closer.addEventListener("click", () => {
            modal.style.display = "none"
        })

        closez.addEventListener("click", () => {
            modalz.style.display = "none"
        })

    </script>

</body>
</html>