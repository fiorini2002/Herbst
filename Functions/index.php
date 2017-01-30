<!DOCTYPE html>
<?php include 'masterFunctions.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="register-form">

            <h1>Login</h1>

            <?php
            if (isset($_SESSION['login'])) {
                $table_name = "admin_users";
                $table_rows = array("id", "first_name", "last_name", "email", "created", "access_id");
                loginFromDatabase($table_name, $table_rows);
            }
            else {
                ?>


                <form action="" method = "POST">

                    <p><label>User Name : </label>

                        <input id = "email" type = "email" name = "email" placeholder = "username" /></p>


                    <p><label>Password&nbsp;
                            &nbsp;
                            : </label>

                        <input id = "password" type = "password" name = "password" placeholder = "password" /></p>



                    <input class = "btn register" type = "submit" name = "submit" value = "Login" />

                </form>
                <?php
            }
            ?>

        </div>

    </body>
</html>
