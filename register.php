<?php
session_start();
include 'db.php';


//if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
   // header("Location: home.php");
    //exit;
//}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // confirmation
    if ($password === '' || $confirm_password === '' || $nom === '' || $email === '') {
        $error = "Please fill all required fields.";
    }
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    }
    // check the email in the right form
    if (strpos($email, '@') === false) {
        $error = "Invalid email: Missing @ symbol";
    } 

    // Check if name or email already exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $error = "Email  already exists";
    }

    // insertion de donnée et envoyer vers base donnée
    // INSERT ONLY if no error
if ($error === "") {
    $sql = "INSERT INTO users(nom, prenom, email, password, confirm_password)
            VALUES ('$nom', '$prenom', '$email', '$password', '$confirm_password')";

   if (mysqli_query($conn, $sql)) {
    header("Location: login.php?success=1");
    exit;
}

}

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>page de register</title>
    <style>
    body {
    background-color: #faf9f5; /* crème sophistiqué */
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Formulaire centré comme le login */
form {
    width: 350px;
    margin: 70px auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Labels */
label {
    font-weight: bold;
    display: block;
    margin-bottom: 6px;
}

/* Inputs */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-bottom: 15px;
    outline: none;
    transition: 0.2s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color:  #B8860B;
    box-shadow: 0 6px 20px rgba(212,175,55,0.5);
}

/* Bouton comme le login */
input[type="submit"] {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, #D4AF37, #B8860B);
    color: white;
    border: none;
    font-size: 17px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}

input[type="submit"]:hover {
    background: linear-gradient(135deg, #B8860B, #8B6508);
    box-shadow: 0 6px 20px rgba(212,175,55,0.5);
}
/* Navigation sous le formulaire */
nav {
    text-align: center;
    margin-top: 15px;
}

nav ul {
    list-style: none;
    padding: 0;
}

nav li {
    display: inline-block;
    margin: 0 10px;
}

nav a {
    color: #D4AF37;
    text-decoration: none;
    font-weight: 600;
}

nav a:hover {
    color: #B8860B;
    text-decoration: underline;
}

</style>
</head>
<body>
     <?php if ($error): ?>
        <div style="color: red; text-align:center; margin-bottom:15px;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <label>nom</label>
        <input type="text" name="nom" placeholder="ton nom" required> <br><br>

        <label>prenom</label>
        <input type="text" name="prenom" placeholder="ton prenom" required> <br><br>

        <label>email</label>
        <input type="text" name="email" placeholder="ton email" required> <br><br>

        <label>password</label>
        <input type="password" name="password" placeholder="ecrit un password " required> <br><br>

        <label>confirm_password</label>
        <input type="password" name="confirm_password" placeholder="confirme password" required> <br><br>

        <input type="submit" value="sign_in">
    </form>
    <nav>
        <ul>
            <li><a href="login.php">login</a></li>
        </ul>
        <ul>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</body>
</html>