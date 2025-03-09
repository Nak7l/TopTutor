<?php
    require('../db_connect.php');   

     // Delete for single StudentMSG
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $db->prepare("DELETE FROM tutorMSG WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Message has been deleted.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href='tutorMessages.php';
                    });
                  </script>";
        } else {
            echo "<script>Swal.fire('Error!', 'Failed to delete message.', 'error');</script>";
        }

        $stmt->close();
    }

     // Delete for All StudentMSG
    if (isset($_GET['del']) && $_GET['del'] == 'all') {
        
        $query = "DELETE FROM tutorMSG";
    
        if (mysqli_query($db, $query)) {
            echo "<script>
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'All messages have been deleted.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href='tutorMessages.php';
                    });
                  </script>";
        } else {
            echo "<script>Swal.fire('Error!', 'Failed to delete messages.', 'error');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" href="Imgs/Icon2.png" />
    <link rel="stylesheet" href="css/style.css">
    <style>
        a {
            text-decoration: none;
        }


        .fonrf {
            font-family: Forte;
        }

        #hading1 {
            color: red;
            font-size: xx-large;
            font-weight: bolder;
            font-family: Forte;

        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }


        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            background-position: center;
            background-size: cover;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
        }

        .custom-bg {
            background-color: #2ec1ac;
            border: 1px solid #2ec1ac;

        }

        .custom-bg:hover {
            background-color: #279e8c;
            border: 1px solid #279e8c;

        }

        .avalibility-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .avalibility-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }

        footer {
            background-color: rgb(54, 51, 51);
            /* border-radius: 10px; */

        }

        .ft {
            color: yellow;
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

            /* width */
            ::-webkit-scrollbar {
            width: 10px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
            background: #f1f1f1;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
            background: rgb(36,36,36);
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
            background: #555;
            }
        }





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
        .bg-header{
            background-color: #28a745;
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
            background: #28a745;
        }
        .table-bg{
            background: #28a745;
            color: white !important;
        }
        .table-height{
            max-height: 200px;
        }
        .table-bg th {
            color: white !important;
        }
    </style>

    <title>Admin Panel - User Queries</title>
</head>

<body class="body">

    <?php require("header.php"); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">



            <div class="border-0 mb-4">
                <div class="card-body">

                    <div class="text-end mb-4 d-flex justify-content-between">
                        <h3 class="mb-0">Tutor's Queries</h3>
                        <?php 
                            $q = "SELECT * FROM `tutorMSG` ORDER BY `id` DESC";
                            $data = mysqli_query($db, $q);
                            $totalRows = mysqli_num_rows($data);
                            if ($totalRows > 0) : 
                        ?> 
                        <a href="#" class="btn btn-danger rounded-pill shadow-none btn-sm" onclick="confirmDeleteAll()">
                            <i class="bi bi-trash"></i> Delete all
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- Search Form -->
                    <form method="get" action="" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search by name, email or message" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="btn btn-success table-bg" type="submit">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead class="bg-header text-light">
                                <tr>
                                    <th scope="col">Sr</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Get the search term from the URL
                                    $search_term = isset($_GET['search']) ? $_GET['search'] : '';

                                    // Modify the query based on the search term
                                    if ($search_term) {
                                        $q = "SELECT * FROM `tutorMSG` WHERE `name` LIKE '%$search_term%' OR `email` LIKE '%$search_term%' OR `message` LIKE '%$search_term%' ORDER BY `id` DESC";
                                    } else {
                                        $q = "SELECT * FROM `tutorMSG` ORDER BY `id` DESC";
                                    }

                                    // Execute the query
                                    $data = mysqli_query($db, $q);

                                    if (mysqli_num_rows($data) > 0) { // Check if any messages exist
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($data)) {
                                            echo "
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[name]</td>
                                                <td>$row[email]</td>
                                                <td>$row[message]</td>
                                                <td>
                                                    <button class='btn btn-sm btn-danger' onclick='confirmDelete($row[id])'>Delete</button>
                                                </td>
                                            </tr>
                                            ";
                                            $i++;
                                        }
                                    } else {
                                        // Display message when no data is found
                                        echo "
                                        <tr>
                                            <td colspan='5' class='text-center text-danger fw-bold'>No messages found.</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            </div>
        </div>


        <!-- sweetalert for single delete msg -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#0C0B60",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "tutorMessages.php?id=" + id;
                    }
                });
            }
        </script>
        <!-- sweetalert for single delete msg -->

        <!-- sweetalert for all delete msg -->
        <script>
            function confirmDeleteAll() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will permanently delete all messages!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#0C0B60",
                    confirmButtonText: "Yes, delete all!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "tutorMessages.php?del=all";
                    }
                });
            }
        </script>
        <!-- sweetalert for all delete msg -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
       

</body>

</html>