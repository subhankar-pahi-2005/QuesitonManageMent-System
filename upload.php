<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['question_image'])) {
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $branch = $_POST['branch'];
    $exam_session = $_POST['exam_session'];
    $semester = $_POST['semester'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["question_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["question_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    // Check file size
    if ($_FILES["question_image"]["size"] > 5000000) { // 5MB
        echo "Sorry, your file is too large.";
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES["question_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO questions (subject_name, subject_code, branch, exam_session, semester, image_path)
                VALUES ('$subject_name', '$subject_code', '$branch', '$exam_session', '$semester', '" . basename($target_file) . "')";
        if ($conn->query($sql) === TRUE) {
            echo "The file " . htmlspecialchars(basename($target_file)) . " has been uploaded.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload New Question</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
        text-align: center;
        background-color: #007BFF;
        color: white;
        padding: 20px;
        border-radius: 10px;
        width: 50%; /* Set width to 100% */
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            text-align: left;
            max-width: 400px;
            width: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="file"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 25px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <h1>Upload New Question</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="subject_name">Subject Name:</label>
        <input type="text" id="subject_name" name="subject_name" required><br>
        <label for="subject_code">Subject Code:</label>
        <input type="text" id="subject_code" name="subject_code" required><br>
        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" required><br>
        <label for="exam_session">Exam Session:</label>
        <input type="text" id="exam_session" name="exam_session" required><br>
        <label for="semester">Semester:</label>
        <input type="text" id="semester" name="semester" required><br>
        <label for="question_image">Select image to upload:</label>
        <input type="file" id="question_image" name="question_image" required><br>
        <input type="submit" value="Upload Question">
    </form>
</body>
</html>
