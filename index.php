<?php
include 'config.php';

$searchQuery = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchQuery = $_POST['search'];
}

$sql = "SELECT * FROM questions 
        WHERE subject_name LIKE '%$searchQuery%' 
        OR branch LIKE '%$searchQuery%' 
        OR exam_session LIKE '%$searchQuery%' 
        OR semester LIKE '%$searchQuery%' 
        ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Previous Year Questions</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            color: #495057;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        header h1 {
            text-align: center;
            margin: 0;
            font-size: 2.5rem;
        }
        .admin-login {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .search-container {
            text-align: center;
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
            background-color: #007BFF;
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
        .question-container {
            width: 80%;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .question-container h2 {
            margin: 0 0 10px;
            color: #333;
        }
        .question-container p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px 0 0;
            color: white;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 25px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button-container {
            text-align: right;
        }
        .no-results {
            text-align: center;
            font-size: 1.2rem;
            color: #6c757d;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }
            .admin-login {
                top: 10px;
                right: 10px;
            }
            .search-container input[type="text"] {
                width: 80%;
            }
            .question-container {
                width: 90%;
            }
        }
        @media (max-width: 480px) {
            header h1 {
                font-size: 1.5rem;
            }
            .search-container input[type="text"] {
                width: 90%;
                margin-bottom: 10px;
            }
            .search-container input[type="submit"] {
                width: 90%;
                padding: 10px;
            }
            .button {
                width: 100%;
                text-align: center;
            }
            .button-container {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Previous Year Questions</h1>
        <div class="admin-login">
            <a class="button" href="login.php">Admin Login</a>
        </div>
    </header>
    <div class="search-container">
        <form method="post" action="">
            <input type="text" name="search" placeholder="Search by subject, branch, session, or semester" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="Search">
        </form>
    </div>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='question-container'>";
            echo "<h2>Theory Name: " . $row['subject_name'] . "</h2>";
            echo "<p>Subject Code: " . $row['subject_code'] . "</p>";
            echo "<p>Branch: " . $row['branch'] . "</p>";
            echo "<p>Exam Session: " . $row['exam_session'] . "</p>";
            echo "<p>Semester: " . $row['semester'] . "</p>";
            echo "<div class='button-container'>";
            echo "<a class='button' href='uploads/" . $row['image_path'] . "' target='_blank'>View</a>";
            echo "<a class='button' href='uploads/" . $row['image_path'] . "' download>Download</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        if(empty($searchQuery)) {
            echo "<p class='no-results'>No questions found.</p>";
        } else {
            echo "<p class='no-results'>No matching questions found.</p>";
        }
    }
    $conn->close();
    ?>
</body>
</html>
