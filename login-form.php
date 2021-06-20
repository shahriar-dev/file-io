<?php
$UsernameError = "";
$PasswordError = "";

$Username = "";
$Password = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        if (empty($_POST['username'])) {
            $UsernameError = "Username Required!";
        } else {
            $Username = Test_User_Input($_POST['username']);

            if (!preg_match("/^[A-Za-z0-9. ]*$/", $Username)) {
                $UsernameError = "Only Number and lowercase, Uppercase Letter are Allowed!";
            }
        }

        if (empty($_POST['password'])) {
            $PasswordError = "Password REQUIRED!";
        } else {
            $Password = Test_User_Input($_POST['password']);

            $UpperCase = preg_match("@[A-Z]@", $Password);
            $LowerCase = preg_match("@[a-z]@", $Password);
            $Number = preg_match("@[0-9]@", $Password);

            if (!$UpperCase || !$LowerCase || !$Number) {
                $PasswordError = "Password Incorrect!";
            }
        }
    }
}

function Test_User_Input($Data)
{
    return trim(htmlspecialchars(stripslashes($Data)));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="login-form">
    <title>Login Form</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="position:absolute; padding: 30em 75em 0 75em" method="POST">
        <fieldset>
            <legend style="text-align: center;">Login</legend>

            <p>
                <span>
                    <label for="input_username">Username:</label>
                    <input type="text" id="input_username" placeholder="Username" name="username">
                    <label for="input_username_error" style="color: red;"><?php echo $UsernameError; ?></label>
                </span>
            </p>

            <p>
                <span>
                    <label for="input_password">Password:</label>
                    <input type="password" id="input_password" placeholder="Password" name="password">
                    <label for="input_password_error" style="color: red;"><?php echo $PasswordError; ?></label>
                </span>
            </p>

            <span>
                <input type="submit" id="input_submit" name="submit">
                <input type="reset" value="Clear Form">
            </span>

        </fieldset>


    </form>
</body>

</html>