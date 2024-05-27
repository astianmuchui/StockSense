<?php
    require "../../vendor/autoload.php";
    require "../../core/index.php";
    $error = "";

    if (User::IsAuthenticated())
    {
        $products = User::Products($_SESSION['user_id']);
        $categories = Categories::All();

        if(isset($_POST['add_category']))
        {
            if (Categories::Create($_POST['category'], $_FILES['img']['name'], $_FILES['img']['tmp_name']))
            {
                header("Location: ./");
            }
            else
            {
                $error = "An error occurred";
            }
        }

        if(isset($_POST['add_product']))
        {
            if (Products::Create(
                $_SESSION['user_id'],
                $_POST['name'],
                $_FILES['img']['name'],
                $_FILES['img']['tmp_name'],
                $_POST['price'],
                $_POST['count'],
                $_POST['category']
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

    <div class="modal-z flex-column" id="modalz">
        <div class="modal-content flex-column x-start">
            <span id="closez">&times;</span>
            <h3 class="text-primary text-bold">Add New Category</h3>
            <small class="text-red"> <?php echo $error ?> </small>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Category Name" name="category" required style="border: 1px solid;"> <br> <br>
                <input type="file" name="img" required style="border: 2px solid;"> <br> <br>

                <button type="submit" class="btn-gradient" name="add_category">Add Category</button>
            </form>
        </div>
    </div>

    <div class="modal flex-column" id="modal">
        <div class="modal-content flex-column">
            <span id="closer" >&times;</span>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="" method="POST" enctype="multipart/form-data">
                <h3 class="text-primary text-bold">Create New Product</h3>
                <small class="text-red"> <?php echo $error ?> </small>
                <input type="text" placeholder="Product Name" name="name" required> <br>
                <input type="number" placeholder="Product Price" name="price" required> <br>
                <input type="number" placeholder="Product Quantity" name="count" required> <br>
                <label for="" class="text-primary">Product Image</label>
                <input type="file" name="img" required> <br>

                <select name="category" id="" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id ?>"> <?php echo $category->name ?> </option>
                    <?php endforeach ?>
                </select>

                <button type="submit" class="btn-gradient" name="add_product">Add Product</button>
            </form>
            </div>
        </div>

    <main>

        <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">

            <div class="products-container">

                <div class="products">

                    <h4 class="text-primary">
                        My Products

                    </h4>

                    <div class="container">

                    <?php if (count($products) == 0) : ?>
                        <div class="product">
                            <p style="letter-spacing: 1px;">Products you add will appear here</p>
                        </div>
                    <?php endif ?>

                    <?php foreach ($products as $product): ?>
                        <div class="product">

                            <img src="../../assets/uploads/<?php echo $product->image_path ?>" alt="">
                            <p> <?php echo $product->name ?> </p>
                            <p>KES <?php echo $product->price ?></p>
                            <a href="./view/?id=<?php echo bin2hex(base64_encode($product->id)) ?>"> View <i class="fas fa-arrow-right"></i> </a>
                        </div>
                    <?php endforeach ?>

                    </div>

                </div>

                <div class="stats">

                    <div class="card">
                        <i class="fas fa-plus"></i>
                        <h3>Add Product</h3>
                        <a href="#" class="btn-primary-bordered" id="add-product">Add Now</a>
                    </div>


                    <div class="card">
                        <i class="fas fa-book"></i>
                        <h3>Add Category</h3>
                        <a href="#" class="btn-primary-bordered" id="add-category">Add Now</a>
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

        const add_product = document.getElementById("add-product")
        const add_category = document.getElementById("add-category")

        const closer = document.getElementById("closer")
        const closez = document.getElementById("closez")

        add_product.addEventListener("click", () => {
            modal.style.display = "flex"
        })

        add_category.addEventListener("click", () => {
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