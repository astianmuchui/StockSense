<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    require "../../vendor/autoload.php";
    require "../../core/index.php";

    if (User::IsAuthenticated())
    {
        if (User::HasApiKey($_SESSION['user_id']))
        {
            $api_key = User::ApiKey($_SESSION['user_id']);
        }
        else
        {
            User::GenerateApiKey($_SESSION['user_id']);
            $api_key = User::ApiKey($_SESSION['user_id']);
        }

        if (isset($_POST['generate']))
        {
            User::GenerateApiKey($_SESSION['user_id']);
            $api_key = User::ApiKey($_SESSION['user_id']);
            header("Location: ./");
        }
    }
    else
    {
        header("Location: ../../login/");
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

    <main>

    <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">
            <a href="#" class="btn-primary btn-left"> <i class="fas fa-arrow-circle-left"></i>  Menu </a>

            <div class="edit-container" style="height: 40% !important;">

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <h2 class="text-primary text-bold">My API KEY</h2>

                    <input type="password" id="apiKeyInput" disabled value="<?php echo $api_key ?>">
                    <div class="grid-2">
                        <button type="button" id="copyButton" class="btn-gradient"> <i class="fas fa-clipboard"></i> Copy</button>
                        <button class="btn-gradient" name="generate"> <i class="fas"></i> Generate new</button>
                    </div>
                </form>

            </div>

        </div>

    </main>

    <script>
        document.getElementById('copyButton').addEventListener('click', () => {
            var apiKeyInput = document.getElementById('apiKeyInput');
            apiKeyInput.disabled = false;
            apiKeyInput.type = "text";
            apiKeyInput.select();
            apiKeyInput.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(apiKeyInput.value).then(() => {
                alert('API Key copied to clipboard');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });

            apiKeyInput.disabled = true;
        });
    </script>

</body>
</html>
