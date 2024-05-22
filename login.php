<?php
session_start();
include 'config.php';

$login_error = ''; // Initialize the variable to hold the error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=PASSWORD(?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        header("Location: admin.php");
    } else {
        $login_error = "Invalid login."; // Set the error message
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: #ff0000;
            display: inline-block; /* Display error message inline with the login button */
            margin-top: 10px; /* Add some space between the button and the error message */
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .login-container {
                padding: 15px;
                max-width: 90%;
            }
            input[type="text"],
            input[type="password"] {
                padding: 10px;
                font-size: 14px;
            }
            input[type="submit"] {
                padding: 10px;
                font-size: 14px;
            }
            h1 {
                font-size: 20px;
            }
        }
        @media (max-width: 480px) {
            .login-container {
                padding: 10px;
                max-width: 100%;
            }
            input[type="text"],
            input[type="password"] {
                padding: 8px;
                font-size: 12px;
            }
            input[type="submit"] {
                padding: 8px;
                font-size: 12px;
            }
            h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
            <div class="error-message">
                <?php echo $login_error; ?>
            </div>
        </form>
    </div>
</body>
</html>
