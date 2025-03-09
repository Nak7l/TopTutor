<?php
    require('../db_connect.php');
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Imgs/Icon2.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="icon" href="../more/Icon-B.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        a {
            text-decoration: none;

        }
        html,
        body {
            position: relative;
            height: 100%;
        }
        body {
            background: #e8f5e9;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        @media screen and (max-width: 575px) {
            .avalibility-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }
        #dashboard-menu {
            position: fixed;
            height: 100%;
            z-index: 11;

        }
        @media screen and (max-width: 992px) {
            #dashboard-menu {
                height: auto;
                width: 100%;
            }
            #main-content {
                margin-top: 60px;
            }
        }
        .body{
            background-color: #e8f5e9;
        }
        .table-container {
            width: 100%;
            overflow-x: auto; 
            white-space: nowrap;
        }
        .table-container::-webkit-scrollbar {
            height: 8px; 
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #fff;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #0C0B60;
        }
        .table-bg{
            background: #0C0B60 !important;
            color: white !important;
        }
        .table-height{
            max-height: 200px;
        }
        .table-bg th {
            color: white !important;
        }
        .pagi-text{
            color: #0C0B60 !important;
        }
    </style>

    <title>Admin Panel - Dashboard</title>
</head>

<body class="body">

    <?php 
        require("header.php");
    ?>

    <!-- Student Details -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-auto">

                <div class="container mt-4">
                    <h2 class="text-start">Tutor List</h2>

                    <!-- Search and pagination -->
                    <?php
                        $records_per_page = 4;

                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $records_per_page;

                        $search_term = isset($_GET['search']) ? $_GET['search'] : '';

                        if ($search_term) {
                            $query = "SELECT * FROM `tutors` WHERE `name` LIKE '%$search_term%' OR `email` LIKE '%$search_term%' OR `phone` LIKE '%$search_term%' OR `subject` LIKE '%$search_term%' OR `class` LIKE '%$search_term%' OR `medium` LIKE '%$search_term%' OR `city` LIKE '%$search_term%' OR `institute` LIKE '%$search_term%' ORDER BY `tutor_id` DESC LIMIT $offset, $records_per_page";
                            // $query = "SELECT * FROM tutors WHERE name LIKE '%$search_term%' ORDER BY created_at DESC";
                        } else {
                            $query = "SELECT * FROM tutors ORDER BY created_at DESC LIMIT $offset, $records_per_page";
                        }

                        $students = mysqli_query($db, $query);

                        if ($search_term) {
                            $count_query = "SELECT COUNT(*) FROM tutors WHERE name LIKE '%$search_term%'";
                        } else {
                            $count_query = "SELECT COUNT(*) FROM tutors";
                        }
                        
                        $count_result = mysqli_query($db, $count_query);
                        $total_records = mysqli_fetch_array($count_result)[0];

                        $total_pages = ceil($total_records / $records_per_page);
                    ?>

                    <!-- Search Form -->
                    <form method="get" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search by name, email, phone, subject, class, medium, city or institute" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="btn btn-success table-bg" type="submit">Search</button>
                        </div>
                    </form>

                    <!-- Student table -->
                    <div class="table-container" style="overflow-x: scroll;">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead class="table-bg">
                                <tr>
                                    <th>Sr</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Medium</th>
                                    <th>Salary</th>
                                    <th>City</th>
                                    <th>Institute</th>
                                    <th>Registered On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $tmp = $offset; 
                                    if (mysqli_num_rows($students) > 0) { 
                                        while ($student = mysqli_fetch_assoc($students)) { 
                                            $tmp += 1;
                                ?>
                                <tr>
                                    <td><?php echo $tmp; ?></td>
                                    <td>
                                        <div>
                                            <img src="uploads/users_img/tutors/<?php echo $student['profile']; ?>" width="55px" class="mb-1"> <br>
                                        </div>
                                    </td>
                                    <td><?php echo $student['name']; ?></td>
                                    <td><?php echo $student['email']; ?></td>
                                    <td><?php echo $student['phone']; ?></td>
                                    <td><?php echo $student['gender']; ?></td>
                                    <td><?php echo $student['subject']; ?></td>
                                    <td><?php echo $student['class']; ?></td>
                                    <td><?php echo $student['medium']; ?></td>
                                    <td><?php echo $student['salary']; ?></td>
                                    <td><?php echo $student['city']; ?></td>
                                    <td><?php echo $student['institute']; ?></td>
                                    <td><?php echo date("d-M-Y", strtotime($student['created_at'])); ?></td>
                                </tr>
                                <?php 
                                        }  
                                    } else { 
                                ?>
                                <tr>
                                    <td colspan="9" class="text-center text-danger fw-bold">
                                        <?php echo $search_term ? 'No tutors found for your search.' : 'No tutos found.'; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($total_records > $records_per_page) { ?>
                        <nav>
                            <ul class="pagination justify-content-end">
                                <?php if ($page > 1) { ?>
                                    <li class="page-item">
                                        <a class="page-link bg-success table-bg text-white" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search_term; ?>">Previous</a>
                                    </li>
                                <?php } ?>

                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link bg-white pagi-text" href="?page=<?php echo $i; ?>&search=<?php echo $search_term; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>

                                <?php if ($page < $total_pages) { ?>
                                    <li class="page-item">
                                        <a class="page-link bg-success table-bg text-white" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search_term; ?>">Next</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    <?php } ?>



                   

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>


































