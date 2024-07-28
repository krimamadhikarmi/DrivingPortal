<?php
session_start();


$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "driving_license";


$username_input = "";
$password_input = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

  
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_input);
    $stmt->execute();
    $result = $stmt->get_result();

   
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
       
        if (password_verify($password_input, $row['password'])) {
            
            $_SESSION['username'] = $username_input;
            header("Location: index.php"); 
            exit();
        } else {
            $message = "<p class='error-message'>Invalid password.</p>";
        }
    } else {
        $message = "<p class='error-message'>No user found with that username.</p>";
    }

    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #5cb85c;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
        .login-option {
            display: flex;
            align-items: center; 
            margin-left: 90px;
        }

        .login-option p {
            margin-right: 10px; 
            
        }

        .login-option a {
            text-decoration: none; 
            color: green; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username_input); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php echo $message; ?>
            <button type="submit">Login</button>
        </form>
        <div class="login-option">
            <p>Donot have an account?</p>
            <a href="register_user.php">Register</a>
        </div>
    </div>
</body>
</html>
