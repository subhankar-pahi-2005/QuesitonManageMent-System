<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check if a question is requested to be deleted
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql_delete = "DELETE FROM questions WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Question deleted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to delete question.');</script>";
    }
}

// Fetch questions from the database
$sql_fetch = "SELECT * FROM questions";
$result = $conn->query($sql_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Questions</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-size: 24px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            display: inline-block;
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }
        .delete-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        /* Search bar */
        .search-container {
            text-align: left;
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 10px;
            width: 60%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 25px;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .search-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .search-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        /* Media Query for Mobile */
        @media (max-width: 200px) {
            .container {
                padding: 10px;
            }
            table {
                font-size: 14px;
            }
            th, td {
                padding: 10px;
            }
            h2 {
                font-size: 22px;
            }
            .search-container input[type="text"] {
                width: 80%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View and Delete Questions</h2>
        <!-- Search bar -->
        <div class="search-container">
            <form method="get">
                <input type="text" name="search" placeholder="Search by Subject Name, Subject Code, Branch, Exam Session, or Semester">
                <input type="submit" value="Search">
            </form>
        </div>
        <!-- Logout button -->
        <!-- <form method="post" action="logout.php">
            <input type="submit" class="logout-btn" value="Logout">
        </form> -->
        <table>
            <tr>
                <th>Subject Name</th>
                <th>Subject Code</th>
                <th>Branch</th>
                <th>Exam Session</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['subject_name']."</td>";
                    echo "<td>".$row['subject_code']."</td>";
                    echo "<td>".$row['branch']."</td>";
                    echo "<td>".$row['exam_session']."</td>";
                    echo "<td>".$row['semester']."</td>";
                    echo "<td><button class='delete-btn' onclick='deleteQuestion(".$row['id'].")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No questions found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <script>
        function deleteQuestion(id) {
            if (confirm("Are you sure you want to delete this question?")) {
                window.location.href = 'fetch_questions.php?delete=' + id;
            }
        }
    </script>
</body>
</html>
