<?php
$UsernameError = "";
$PasswordError = "";

$Username = "";
$Password = "";

$LoginErrorMessage = "";
$emptyField = false;
$LoginSuccess = false;
$Message = "";
$user;

define("filepath", "data.txt");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        if (empty($_POST['username'])) {
            $UsernameError = "Username Required!";
            $emptyField = true;
        } else {
            $Username = Test_User_Input($_POST['username']);

            if (!preg_match("/^[A-Za-z0-9. ]*$/", $Username)) {
                $UsernameError = "Only Number and lowercase, Uppercase Letter are Allowed!";
                $emptyField = true;
            }
        }

        if (empty($_POST['password'])) {
            $PasswordError = "Password REQUIRED!";
            $emptyField = true;
        } else {
            $Password = Test_User_Input($_POST['password']);

            /*$UpperCase = preg_match("@[A-Z]@", $Password);
            $LowerCase = preg_match("@[a-z]@", $Password);
            $Number = preg_match("@[0-9]@", $Password);

            if (!$UpperCase || !$LowerCase || !$Number) {
                $PasswordError = "Password Incorrect!";
                $emptyField = true;
            }*/
        }

        if (!$emptyField) {
            $retrievedData = file_get_contents(filepath);
            $retrievedData = json_decode($retrievedData);
            if ($retrievedData != null) {
                for ($i = 0; $i < count($retrievedData); $i++) {
                    $user = $retrievedData[$i];
                    if ($user->userName == $Username && $user->password == $Password) {
                        $LoginSuccess = true;
                        break;
                    }
                }
            } else {
                $Message = "There is no details of any user in the file!";
            }

            if (!$LoginSuccess) {
                $Message = "Verification Failed! Please try again...";
            } else {
                header("Location: welcome-page.php");
                exit();
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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
            <legend style="text-align: center; font-size:50px;">Login</legend>

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
                <label for="error_message" style="color:red;"><?php echo $Message ?></label>
            </span>
        </fieldset>
    </form>

    <div style="width:300px; height: 100px; clear:both;">
        <button style="width:100%; height:100%; background:blue; border-radius:2px; margin:0px; float:right;">
            <a style="color: white; font-family:Cambria; font-size:50px;" href="registration-form-with-validation.php">Register</a>
        </button>
    </div>

</body>

</html>