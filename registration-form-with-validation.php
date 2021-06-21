<?php
$FirstNameError = "";
$LastNameError = "";
$GenderError = "";
$DoBError = "";
$ReligionError = "";
$EmailError = "";
$UsernameError = "";
$PasswordError = "";

$FirstName = "";
$LastName = "";
$Gender = "";
$Religion = "";
$Email = "";
$Username = "";
$Password = "";
$DoB = "";
$flag = 0;

$emptyField = false;
$SuccessfulMessage = "";


define("filepath", "data.txt");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        if (empty($_POST['firstName'])) {
            $FirstNameError = "First Name is Required!";
            $emptyField = true;
            $flag = 1;
        }
        if (empty($_POST['lastName'])) {
            $LastNameError = "Last Name is Required!";
            $emptyField = true;
            $flag = 1;
        }
        if ($flag == 0) {
            $FirstName = Test_User_Input($_POST['firstName']);
            $LastName = Test_User_Input($_POST['lastName']);
            if (!preg_match("/^[A-Za-z. ]*$/", $FirstName)) {
                $FirstNameError = "Only Letters and White Spaces are Allowed!";
                $emptyField = true;
            }
            if (!preg_match("/^[A-Za-z. ]*$/", $LastName)) {
                $LastNameError = "Only Letters and White Spaces are Allowed!";
                $emptyField = true;
            }
        }

        if (empty($_POST['gender'])) {
            $GenderError = "Gender is Required!";
            $emptyField = true;
        } else {
            $Gender = Test_User_Input($_POST['gender']);
        }

        if (empty($_POST['dob'])) {
            $DoBError = "Date of Birth Required!";
            $emptyField = true;
        } else {
            $DoB = Test_User_Input($_POST['dob']);
        }

        if (empty($_POST['religion']) || Test_User_Input($_POST['religion']) == "None") {
            $ReligionError = "Religion Required!";
            $emptyField = true;
        } else {
            $Religion = Test_User_Input($_POST['religion']);
        }

        if (empty($_POST['email'])) {
            $EmailError = "Email is Required!";
            $emptyField = true;
        } else {
            $Email = Test_User_Input($_POST['email']);
            if (!preg_match("/[a-zA-Z0-9._]{3,}@[a-zA-Z0-9._]{3,}[.]{1}[a-zA-Z0-9._]{2,}/", $Email)) {
                $EmailError = "Invalid Format";
                $emptyField = true;
            }
        }

        if (empty($_POST['username'])) {
            $UsernameError = "Username REQUIRED!";
            $emptyField = true;
        } else {
            $Username = Test_User_Input($_POST['username']);

            if (!preg_match("/^[A-Za-z0-9. ]*$/", $Username)) {
                $UsernameError = "Only Number and lowercase, Uppercase Letter are Allowed!";
                $emptyField = true;
            }
        }

        if (empty($_POST['password'])) {
            $PasswordError = "You must Enter a Password!";
            $emptyField = true;
        } else {
            $Password = Test_User_Input($_POST['password']);

            $UpperCase = preg_match("@[A-Z]@", $Password);
            $LowerCase = preg_match("@[a-z]@", $Password);
            $Number = preg_match("@[0-9]@", $Password);

            if (!$UpperCase || !$LowerCase || !$Number) {
                $PasswordError = "Password must contain 1 UPPERCASE, 1 LOWERCASE and 1 NUMBER";
                $emptyField = true;
            }
        }

        if (!$emptyField) {
            $data = array(
                "firstName" => $FirstName, "lastName" => $LastName, "gender" => $Gender, "dob" => $DoB, "religion" => $Religion,
                "presentAddress" => Test_User_Input($_POST['presentAddress']), "permanentAddress" => Test_User_Input($_POST['permanentAddress']),
                "phoneNumber" => Test_User_Input($_POST['phoneNumber']), "email" => $Email, "userName" => $Username, "password" => $Password,
                "personalWebsite" => Test_User_Input($_POST['url'])
            );

            if (file_get_contents(filepath) != null) {

                $retrievedData = json_decode(file_get_contents(filepath));
                $retrievedData[] = $data;
                $result = file_put_contents(filepath, json_encode($retrievedData, JSON_PRETTY_PRINT));
                if ($result) {
                    $SuccessfulMessage = "Successfully Saved!";
                } else {
                    $SuccessfulMessage = "Error Saving Information!";
                }
            } else {
                $retrievedData[] = $data;
                $result = file_put_contents(filepath, json_encode($retrievedData, JSON_PRETTY_PRINT));
                if ($result) {
                    $SuccessfulMessage = "Successfully Saved!";
                } else {
                    $SuccessfulMessage = "Error Saving Information!";
                }
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
    <meta name="description" content="registration-form-with-validation">
    <title>Registration Form</title>
</head>

<body>

    <body>
        <h1>Registration form</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <fieldset>
                <legend>Basic Information</legend>

                <p>
                    <label for="input_firstname">First Name:</label>
                    <input type="text" id="input_firstname" placeholder="First Name" name="firstName">
                    <span><label for="input_firstNameError" style="color: red;"><?php echo $FirstNameError ?></label></span>
                </p>

                <p>
                    <label for="input_lastname">Last Name:</label>
                    <input type="text" id="input_lastname" placeholder="Last Name" name="lastName">
                    <span><label for="input_lastNameError" style="color: red;"><?php echo $LastNameError ?></label></span>
                </p>

                <p>
                    <label for="gender_option">Gender</label>
                    <input type="radio" id="gender_option" name="gender" value="Male">Male</input>
                    <input type="radio" id="gender_option" name="gender" value="Female">Female</input>
                    <span><label for="input_genderError" style="color: red;"><?php echo $GenderError ?></label></span>
                </p>

                <p>
                    <label for="input_dob">Date of Birth:</label>
                    <input type="date" id="input_dob" name="dob">
                    <span><label for="input_dobError" style="color: red;"><?php echo $DoBError ?></label></span>
                </p>

                <p>
                    <label for="select_religion">Religion</label>
                    <select name="religion" id="select_religion" value="None">
                        <option>None</option>
                        <option>Muslim</option>
                        <option>Hindu</option>
                        <option>Christian</option>
                    </select>
                    <span><label for="select_religionError" style="color: red;"><?php echo $ReligionError ?></label></span>
                </p>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>

                <p>
                    <span><label for="input_presentAddress">Present Address:</label></span>
                    <br>
                    <span>
                        <textarea name="presentAddress" id="input_presentAddress" cols="50" rows="5" placeholder="Enter Present Address Here"></textarea>
                    </span>
                </p>

                <p>
                    <span><label for="input_permanentAddress">Permanent Address</label></span>
                    <br>
                    <span><textarea name="permanentAddress" id="input_permanentAddress" cols="50" rows="5" placeholder="Enter Permanent Address Here"></textarea></span>
                </p>

                <p>
                    <label for="input_phonenumber">Phone:</label>
                    <input id="input_phonenumber" type="tel" placeholder="(+88) 0xxxxxxxxxx" name="phoneNumber">
                </p>

                <p>
                    <label for="input_email">Email:</label>
                    <input type="email" id="input_email" placeholder="something@domain.com" name="email">
                    <span><label for="input_emailerror" style="color: red"><?php echo $EmailError; ?></label></span>
                </p>

                <p>
                    <label for="input_personalWebsite">Personal Website Link:</label>
                    <input id="input_personalWebsite" type="url" placeholder="http://somesite.com" name="url">
                </p>
            </fieldset>

            <fieldset>
                <legend>Account Information</legend>

                <p>
                    <span><label for="input_username">Username:</label></span>
                    <span><input type="text" id="input_username" placeholder="Username" name="username"></span>
                    <span><label for="input_usernameerror" style="color: red"><?php echo $UsernameError; ?></label></span>
                </p>

                <p>
                    <span><label for="input_password">Password:</label></span>
                    <span><input type="password" id="input_password" placeholder="Password" name="password"></span>
                    <span><label for="input_passworderror" style="color: red"><?php echo $PasswordError; ?></label></span>
                </p>

            </fieldset>

            <p>
                <input type="submit" name="submit"> &nbsp;&nbsp;
                <input type="reset" value="Clear Form">
            </p>
        </form>
        <div style="width:300px; height: 100px">
            <button style="width:100%; height:100%; background:blue; border-radius:2px; margin:0px;">
                <a style="border: 0px; background:transparent; text-decoration: none; color: white; font-size: 50px; text-align:center; font-family:cambria" href="login-form.php">Login</a>
            </button>
        </div>

        <span><label for="successful_input" style="color: green;"><b><?php echo $SuccessfulMessage ?></b></label></span>
    </body>

</html>