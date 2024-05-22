<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }
        .admin-header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .admin-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            margin: 40px auto;
        }
        .admin-buttons {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .admin-buttons a {
            display: inline-block;
            margin: 10px;
            padding: 12px 24px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .admin-buttons a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Admin Panel</h1>
    </div>
    <div class="admin-container">
        <div class="admin-buttons">
            <a href="upload.php">Upload New Question</a>
            <a href="fetch_questions.php">View/Delete Questions</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
