<?php

    require "../../../core/index.php";
    require "../../../vendor/autoload.php";
    $error = "";

    if (User::IsAuthenticated())
    {
        if (isset($_GET['id']))
        {
            $url = "../view/?id=".$_GET['id'];

            $id = base64_decode(hex2bin($_GET['id']));
            $product = Products::Get($id);

            if (isset($_POST['delete']))
            {
                if (Products::Delete($id))
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
                if (empty($_FILES['img']['name']))
                {
                    if (Products::Update(
                        $id,
                        $_POST['name'],
                        NULL,
                        NULL,
                        $_POST['price'],
                        $_POST['count'],
                        $_POST['category']
                    ))
                    {
                        header("Location: $url");
                    }
                    else
                    {
                        $error = "An error occurred";
                    }
                }
                else
                {
                    if (Products::Update(
                        $id,
                        $_POST['name'],
                        $_FILES['img']['name'],
                        $_FILES['img']['tmp_name'],
                        $_POST['price'],
                        $_POST['count'],
                        $_POST['category']
                    ))
                    {
                        header("Location: $url");
                    }
                    else
                    {
                        $error = "An error occurred";
                    }
                }
            }
        }
        else
        {
            header("Location: ../");
        }
    }
    else
    {
        header("Location: ../../../login/");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/styles/dashboard.css">
    <script src="../../../assets/js/font_awesome_main.js"></script>
    <title>StockSense Dashboard</title>

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
                <input type="text" placeholder="Product Name" name="name" value="<?php echo $product->name ?>" required> <br>
                <input type="number" placeholder="Product Price" name="price" value="<?php echo $product->price ?>" required> <br>
                <input type="number" placeholder="Product Quantity" name="count" value="<?php echo $product->count ?>" required> <br>
                <label for="" class="text-primary">Product Image</label>
                <input type="file" name="img"> <br>

                <select name="category" id="" required>
                    <option value="<?php echo $product->category ?>"><?php echo Categories::Get($product->category)->name ?></option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id ?>"> <?php echo $category->name ?> </option>
                    <?php endforeach ?>
                </select>

                <button type="submit" class="btn-gradient" name="edit">Update Product</button>
            </form>
            </div>
        </div>


    <main>
        <?php include('../../partials/dashboard_nested.php') ?>


        <div class="dashboard-area">

            <div class="micro-banner noshadow">
                <h4>View Product </h4>

                <a href="#" class="btn-gradient" id="edit-product"> Edit</a>
                <a href="#" class="btn-red" id="delete">  Delete</a>

            </div>

            <div class="view-container">

                <div class="grid-container">
                    <img src="../../../assets/uploads/<?php echo $product->image_path ?>" alt="">

                    <div class="info">
                        <small class="text-grey"><?php echo Categories::Get($product->category)->name ?></small>
                        <h3><?php echo $product->name ?></h3>
                        <h3 class="text-grey" >KSH <?php echo $product->price ?></h3>
                        <small class="text-green"> <?php echo $product->count > 0 ? "Available": "Unavailable" ?> </small>

                        <small>In stock: <?php echo $product->count ?></small>

                    </div>

                    <div class="extra">

                        <h4 class="text-gold">Product Overview</h4>

                        <h5 class="text-grey"> <i class="fas fa-check text-green"></i> <?php echo count(Products::GetOrders( intval($id))) ?> Orders </h5>
                        <h5 class="text-grey"> <i class="fas fa-check text-green"></i> <?php echo count(Products::GetSales(intval($id))) ?> sales </h5>
                        <!-- <h5 class="text-grey"> <i class="fas fa-dollar-sign text-green"></i> 50,000 Earned</h5> -->


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

        const edit = document.getElementById("edit-product")
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