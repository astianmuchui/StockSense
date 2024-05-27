<?php
    require "../../../vendor/autoload.php";
    require "../../../core/index.php";

    $error = "";

    if (User::IsAuthenticated())
    {
        $id = base64_decode(hex2bin($_GET['id']));

        $sale = Sales::Get($id);
        $product = Products::Get($sale->product_id);

        if (isset($_POST['delete']))
        {
            if (Sales::Delete($id))
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
            if (Sales::Update(
                $id,
                Products::GetId($_POST['product']),
                $_POST['qty'],
                $_POST['customer'],
                $_POST['payment_method'],
                $_POST['payment_code'],
                $_POST['date']
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

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $_GET['id'] ?>" class="" method="POST" enctype="multipart/form-data">
                <h3 class="text-primary text-bold">Update Sale Information </h3>
                <small class="text-red"> <?php echo $error ?> </small>
                <input type="text" list="options" id="myInput" placeholder="Product Name" name="product" value="<?php echo $product->name ?>">
                <datalist id="options">
                <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product->name ?>"> <?php echo $product->name ?> </option>
                <?php endforeach ?>
                </datalist>
                <input type="number" placeholder="Quantity" name="qty" required value="<?php echo $sale->item_count ?>">

                <input type="text" placeholder="Customer Name" name="customer" required value="<?php echo $sale->customer_name ?>"">
                <input type="text" placeholder="Payment Method" name="payment_method" required value="<?php echo $sale->payment_method ?>">

                <input type="text" placeholder="Payment Code" name="payment_code" required value="<?php echo $sale->payment_code ?>"">
                <label for="">Date</label>
                <input type="date" name="date" id="" value="<?php echo $sale->date ?>">

                <button type="submit" class="btn-gradient" name="edit">Update </button>
            </form>
            </div>
    </div>


    <main>
        <?php include('../../partials/dashboard_nested.php') ?>

        <div class="dashboard-area">

            <div class="micro-banner">
                <h4>View Sale </h4>


                <a href="#" class="btn-gradient" id="edit-sale">  Edit</a>
                <a href="#" class="btn-red" id="delete">  Delete</a>

            </div>

            <div class="view-container">

                <div class="grid-container">
                    <img src="../../../assets/uploads/<?php echo $product->image_path ?>" alt="">

                    <div class="info">
                        <small class="text-grey"><?php echo Categories::Get($product->category)->name ?></small>
                        <h3><?php echo $product->name ?></h3>
                        <h5 class="text-grey"><?php echo $sale->item_count ?> items</h5>

                        <h3 class="text-primary" >KES <?php echo $sale->item_count * $product->price ?></h3>


                </div>

                    <div class="extra">

                        <h4 class="text-primary">Sale Details</h4>

                        <h5 class="text-grey"> <i class="fas fa-user text-primary"></i> <?php echo $sale->customer_name ?> </h5>
                        <h5 class="text-grey"> <i class="fas fa-money-bill-wave-alt text-primary"></i> Via <?php echo $sale->payment_method ?> </h5>

                        <h5 class="text-grey"> <i class="fas fa-handshake text-primary"></i> <?php echo $sale->payment_code ?> </h5>
                        <h5 class="text-grey"> <i class="fas fa-calendar text-primary"></i> <?php echo $sale->date ?></h5>


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

        const edit = document.getElementById("edit-sale")
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