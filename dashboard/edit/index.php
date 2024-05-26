<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/dashboard.css">
    <script src="../../assets/js/font_awesome_main.js"></script>
    <title>Supplier Dashboard</title>

</head>
<body>

    <main>
        <?php include('../partials/dashboard.php') ?>

        <div class="dashboard-area">
            <a href="#" class="btn-primary btn-left"> <i class="fas fa-arrow-circle-left"></i>  Menu </a>

            <div class="edit-container">
                <h4>Edit Profile</h4>

                <form action="#">

                    <input type="text" placeholder="Name">
                    <input type="text" placeholder="Email">
                    <input type="text" placeholder="Phone Number">
                    <input type="text" placeholder="Coordinates in lattitude">
                    <input type="text" placeholder="Coordinates in longitude">

                    <select name="county" required>
                        <option value="">Select County</option>
                        <option value="mombasa">Mombasa</option>
                        <option value="mombasa">Kwale</option>
                        <option value="kilifi">Kilifi</option>
                        <option value="Tana river">Tana river</option>
                        <option value="Lamu">Lamu</option>
                        <option value="Taita">Taita taveta</option>
                        <option value="Garrisa">Garissa</option>
                        <option value="Wajir">Wajir</option>
                        <option value="Mandera">Mandera</option>
                        <option value="Marsabit">Marsabit</option>
                        <option value="Isiolo">Isiolo</option>
                        <option value="Meru">Meru</option>
                        <option value="Tharaka nithi">Tharaka nithi</option>
                        <option value="Embu">Embu</option>
                        <option value="kitui">Kitui</option>
                        <option value="machakos">Machakos</option>
                        <option value="makueni">Makueni</option>
                        <option value="Nyandarua">Nyandarua</option>
                        <option value="Nyeri">Nyeri</option>
                        <option value="Kirinyaga">Kirinyaga</option>
                        <option value="Muranga">Muranga</option>
                        <option value="Kiambu">Kiambu</option>
                        <option value="Turkana">Turkana</option>
                        <option value="West pokot">West pokot</option>
                        <option value="Samburu">Samburu</option>
                        <option value="Trans nzoia">Trans nzoia</option>
                        <option value="Uasin gishu">Uasin gishu</option>
                        <option value="Elgeyo marakwet">Elgeyo marakwet</option>
                        <option value="Nandi">Nandi</option>
                        <option value="Baringo">Baringo</option>
                        <option value="Laikipia">Laikipia</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Narok">Narok</option>
                        <option value="Kajiado">Kajiado</option>
                        <option value="Kericho">Kericho</option>
                        <option value="Bomet">Bomet</option>
                        <option value="Kakamega">Kakamega</option>
                        <option value="Vihiga">Vihiga</option>
                        <option value="Bungoma">Bungoma</option>
                        <option value="Busia">Busia</option>
                        <option value="Siaya">Siaya</option>
                        <option value="kisumu">Kisumu</option>
                        <option value="Homabay">Homabay</option>
                        <option value="Migori">Migori</option>
                        <option value="Kisii">Kisii</option>
                        <option value="Nyamira">Nyamira</option>
                        <option value="Nairobi">Nairobi</option>
                    </select>

                    <button class="btn-primary">Update Profile</button>

                </form>

            </div>

        </div>

    </main>

</body>
</html>