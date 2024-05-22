CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL,
    subject_code VARCHAR(20) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    exam_session VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (username, password) VALUES ('admin', PASSWORD('admin'));
