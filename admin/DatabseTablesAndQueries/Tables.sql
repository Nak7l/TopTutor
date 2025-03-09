CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    class VARCHAR(50) NOT NULL,
    city VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE tutors (
    tutor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    class VARCHAR(50) NOT NULL,
    medium VARCHAR(50) NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    city VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    institute VARCHAR(255) NOT NULL,
    profile VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'accepted', 'declined', 'seen') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES tutors(tutor_id ON DELETE CASCADE
);


CREATE TABLE notification_student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'seen') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);


CREATE TABLE StudentMSG (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE TutorMSG (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE my_lessons_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    class VARCHAR(100) NOT NULL,
    medium VARCHAR(100) NOT NULL,
    lesson_date DATE NOT NULL,
    lesson_time TIME NOT NULL,
    status ENUM('Pending', 'Accepted', 'Declined', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES tutors(tutor_id) ON DELETE CASCADE
);


CREATE TABLE `my_lessons_tutors` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `student_id` INT NOT NULL,
    `tutor_id` INT NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `class` VARCHAR(100) NOT NULL,
    `medium` VARCHAR(100) NOT NULL,
    `lesson_date` DATE NOT NULL,
    `lesson_time` TIME NOT NULL,
    `status` ENUM('Upcoming', 'Pending', 'Cancelled') DEFAULT 'Pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`student_id`) REFERENCES `students`(`student_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tutor_id`) REFERENCES `tutors`(`tutor_id`) ON DELETE CASCADE
);


INSERT INTO `my_lessons_tutors` (`student_id`, `tutor_id`, `subject`, `class`, `medium`, `lesson_date`, `lesson_time`, `status`) 
SELECT `student_id`, `tutor_id`, `subject`, `class`, `medium`, `lesson_date`, `lesson_time`, 'Upcoming'
FROM `lesson_requests`
WHERE `id` = 1; -- Replace 5 with actual lesson_request ID


-- Table for storing lesson requests
CREATE TABLE lesson_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    student_id INT NOT NULL,
    status ENUM('Pending', 'Accepted', 'Declined') DEFAULT 'Pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- Table for storing lessons assigned by tutors
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    student_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    lesson_date DATE NOT NULL,
    status ENUM('Upcoming', 'Pending', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES tutors(tutor_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);



