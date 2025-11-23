<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

session_start();
include 'db.php';

//if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    //header("Location: home.html");
    //exit;
    
//}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST['valider'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

         // Check if fields are empty
        if (empty($email) || empty($password)) {
            $error = "Please fill all fields";
        }

       if (!$error) {
        // Check if account exists
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['logged_in'] = true;
            header("Location: home.html");
           exit;
           
        } else {
            $error = "Invalid email or password";
       
    }
    }
 }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>page de login</title>
     <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Playfair Display', serif;
        }

        body {
            background-color: #faf9f5; /* crème sophistiqué */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* LOGIN BOX */
        .login-container {
            background: #ffffff;
            padding: 40px 55px;
            border-radius: 25px;
            width: 420px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8e0d5;
            text-align: center;
        }

        .login-container h2 {
            font-size: 32px;
            margin-bottom: 25px;
            color: #2B2B2B;
            letter-spacing: 2px;
        }

        .login-container label {
            display: block;
            font-weight: 600;
            text-align: left;
            margin-bottom: 5px;
            color: #2B2B2B;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #d7cec2;
            background-color: #fafafa;
            margin-bottom: 18px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .login-container input:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 8px rgba(212,175,55,0.35);
            outline: none;
        }

        /* BUTTON */
        .login-container input[type="submit"] {
            padding: 12px 30px;
            background: linear-gradient(135deg, #D4AF37, #B8860B);
            color: white;
            border: none;
            border-radius: 35px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            letter-spacing: 1px;
            text-transform: uppercase;
            width: 100%;
            margin-top: 10px;
        }

        .login-container input[type="submit"]:hover {
            background: linear-gradient(135deg, #B8860B, #8B6508);
            box-shadow: 0 6px 20px rgba(212,175,55,0.5);
        }

        /* LINK */
        .login-container p {
            margin-top: 18px;
            font-size: 14px;
            color: #2B2B2B;
        }

        .login-container a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
        }

        .login-container a:hover {
            color: #B8860B;
            text-decoration: underline;
        }

        /* ERROR */
        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <h2>Login</h2>
    <?php if ($error): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <label>name or email</label>
        <input type="text" name="email" placeholder="your@email.com" required>

        <label>password</label>
        <input type="password" name="password" placeholder="mot de passe" required>

        <input type="submit" name="valider" value="valider">
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
