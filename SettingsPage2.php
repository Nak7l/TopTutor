<?php
include 'db_connect.php'; 

if(!isset($_SESSION['tutor'])){
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="admin/Imgs/Icon2.png" />
    <title>Tutor Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>
<style>
    .bg {
        background-color: #e8f5e9;
    }
    .settings-container {
        max-width: 900px;
        margin: auto;
        display: flex;
        gap: 20px;
        padding: 40px;
    }
    .sidebar {
        flex: 1;
        background: #e8f5e9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(26, 17, 98, 0.5);
    }
    .sidebar a {
        display: block;
        padding: 10px;
        color: #333;
        text-decoration: none;
    }
    .sidebar a.active, .sidebar a:hover {
        font-weight: bold;
        color: #0C0B60;
    }
    .content {
        flex: 3;
        background: #e8f5e9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(26, 17, 98, 0.5);
    }
    .profile-pic {
        width: 120px;
        height: 120px;
        border-radius: 50%;
    }
    .button {
        background-color: #0C0B60 !important;
        border-color: #0C0B60!important;
    }
    .button:hover {
        background-color: #222187!important;
        border-color: #222187!important;
    }
    .text-color{
        color: #0C0B60;
    }
</style>

<body class="bg">
    <?php
        $Tutor = $_SESSION['tutor'];
    ?>
    <!-- navbar -->
    <?php require('components/navbar2.php'); ?> 


    <!-- Sidebar -->
    <div class="settings-container">
        <div class="sidebar">
            <h5 class="text-color fw-bold">Settings</h5>
            <a href="" class="tab-link active" data-tab="profile" onclick="showTab('profile')">Account</a>
            <a href="#" class="tab-link" data-tab="password" onclick="showTab('password')">Password</a>
            <a href="#" class="tab-link" data-tab="email-phone" onclick="showTab('email-phone')">Email & Phone</a>
            <a href="#" class="tab-link" data-tab="other-details" onclick="showTab('other-details')">Other Details</a>
            <a href="#" class="tab-link" data-tab="payment-methods" onclick="showTab('payment-methods')">Payment Methods</a>
            <a href="#" class="tab-link" data-tab="payment-history" onclick="showTab('payment-history')">Payment History</a>
            <a href="#" class="tab-link" data-tab="autoconfirmation" onclick="showTab('autoconfirmation')">Autoconfirmation</a>
            <a href="#" class="tab-link" data-tab="calendar" onclick="showTab('calendar')">Calendar</a>
            <a href="#" class="tab-link" data-tab="notifications" onclick="showTab('notifications')">Notifications</a>
            <a href="#" class="tab-link text-danger" data-tab="delete-account" onclick="showTab('delete-account')">Delete Account</a>
            
        </div>
        

        <div class="content text-center">
        <!-- Account Section -->
        <div id="profile" class="tab-content">
            <img src="<?php echo empty($Tutor['profile']) ? 'admin/uploads/users_img/tutors/default.png' : 'admin/uploads/users_img/tutors/'.$Tutor['profile'] ; ?>" class="rounded-circle mb-3" width="120" height="120">  

            <h2 class="fw-bold text-color"><?php echo $Tutor['name'] ?></h2>
            <form id="updateProfileForm">
                <div class="mb-3 mt-3">
                    <!-- <label class="text-start">Change Profile Picture</label> -->
                    <input type="file" class="form-control" name="profile">
                </div>
                <div class="mb-3">
                    <input type="hidden" class="form-control" name="tutor_id" value="<?php echo $Tutor['tutor_id'] ?>" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" value="<?php echo $Tutor['name'] ?>" required>
                </div>
                <button type="submit" class="btn button w-100">Save Changes</button>
            </form>
        </div>

        <!-- Password Section -->
        <div id="password" class="tab-content text-color" style="display: none;">
            <h2>Change Password</h2>
            <form id="changePasswordForm">
                <!-- <div class="mb-3">
                    <input type="password" class="form-control" name="old_password" placeholder="Current Password" required>
                </div> -->
                <div class="mb-3">
                    <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required>
                </div>
                <button type="submit" class="btn button w-100">Change Password</button>
            </form>
        </div>

        <!-- Email and phone Section -->
        <div id="email-phone" class="tab-content text-color" style="display: none;">
            <h2>Change Email & Phone</h2>
            <form>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" value="<?php echo $Tutor['email'] ?>" placeholder="New Email" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" name="phone" value="<?php echo $Tutor['phone'] ?>" placeholder="New Phone" required>
                </div>
                <button type="submit" class="btn button w-100">Save Changes</button>
            </form>
        </div>

        <!-- Other Section -->
        <div id="other-details" class="tab-content text-color" style="display: none;">
            <h2>Change Other Details</h2>
            <form id="other-details">
                <div class="row">
                    <div class="col-md-6 mb-3"><input type="text" class="form-control" name="institute" value="<?php echo $Tutor['institute'] ?>" placeholder="Institute Name"></div>
                    <div class="col-md-6 mb-3"><input type="text" class="form-control" name="city" value="<?php echo $Tutor['city'] ?>" placeholder="City"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="subject" value="<?php echo $Tutor['subject'] ?>">
                            <option>Computer Science</option>
                            <option>Mathematics</option>
                            <option>Physics</option>
                            <option>Biology</option>
                            <option>Chemistry</option>
                            <option>Web Development</option>
                            <option>Data Science</option>
                        </select>
                    </div>  
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="class" value="<?php echo $Tutor['class'] ?>">
                            <option>1st Standard</option>
                            <option>2nd Standard</option>
                            <option>3rd Standard</option>
                            <option>4th Standard</option>
                            <option>5th Standard</option>
                            <option>6th Standard</option>
                            <option>7th Standard</option>
                            <option>8th Standard</option>
                            <option>9th Standard</option>
                            <option>10th Standard</option>
                            <option>11th Standard</option>
                            <option>12th Standard</option>
                            <option>BCA</option>
                            <option>B-Tech</option>
                            <option>B.Com</option>
                            <option>BBA</option>
                            <option>BA</option>
                            <option>MCA</option>
                            <option>M-Tech</option>
                            <option>M.Com</option>
                            <option>MBA</option>
                            <option>MA</option>
                        </select>
                    </div>              
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="medium" value="<?php echo $Tutor['medium'] ?>">
                            <option>English</option>
                            <option>Gujarati</option>
                            <option>Hindi</option>
                            <option>Marathi</option>
                            <option>Tamin</option>
                            <option>Telugu</option>
                            <option>Bangali</option>
                            <option>Punjabi</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="salary" value="<?php echo $Tutor['salary'] ?>">
                            <option>2000-5000</option>
                            <option>5000-10000</option>
                            <option>10000-15000</option>
                            <option>15000-25000</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn button w-100">Save Changes</button>
            </form>
        </div>

        <!-- Payment Methods -->
        <div id="payment-methods" class="tab-content text-color" style="display: none;">
            <h2>Payment Methods</h2>
            <p>Manage your payment options here.</p>
        </div>

        <!-- Payment History -->
        <div id="payment-history" class="tab-content text-color" style="display: none;">
            <h2>Payment History</h2>
            <p>View all past transactions.</p>
        </div>

        <!-- Autoconfirmation -->
        <div id="autoconfirmation" class="tab-content text-color" style="display: none;">
            <h2>Autoconfirmation Settings</h2>
            <p>Configure autoconfirmation preferences.</p>
        </div>

        <!-- Calendar -->
        <div id="calendar" class="tab-content text-color" style="display: none;">
            <h2>Calendar</h2>
            <p>Manage your schedules and availability.</p>
        </div>

        <!-- Notifications -->
        <div id="notifications" class="tab-content text-color" style="display: none;">
            <h2>Notification Settings</h2>
            <p>Manage notification preferences.</p>
        </div>

        <!-- Delete Account -->
        <div id="delete-account" class="tab-content" style="display: none;">
            <h2 class="text-danger">Delete Account</h2>
            <p>Warning: This action is irreversible!</p>
            <button class="btn btn-danger">Delete My Account</button>
        </div>

        
            <!-- Update tutor profile -->
            <?php
            if (isset($_POST['updateProfile'])) {
                $tutor_id = $_POST['tutor_id'];
                $name = $_POST['name'];
                // $email = $_POST['email'];
                // $phone = $_POST['phone'];
                // $gender = $_POST['gender'];
                // $subject = $_POST['subject'];
                // $class = $_POST['class'];
                // $medium = $_POST['medium'];
                // $salary = $_POST['salary'];
                // $city = $_POST['city'];
                // $password = $_POST['password'];  // Only update if the user enters a new password
                // $institute = $_POST['institute'];

                $profile = $_FILES['profile']['name'];
                $temp_name = $_FILES['profile']['tmp_name'];
                $folder = "admin/uploads/users_img/tutors/";
                $imageFileType = pathinfo($folder . basename($profile), PATHINFO_EXTENSION);

                if (!empty($profile)) {
                    move_uploaded_file($temp_name, $folder . $profile);
                } else {
                    $query = "SELECT profile FROM tutors WHERE tutor_id = '$tutor_id'";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_assoc($result);
                    $profile = $row['profile'];
                }
            
                $query = "UPDATE tutors SET name='$name', profile='$profile' WHERE tutor_id='$tutor_id'";
                if (mysqli_query($db, $query)) {
                    $query = "SELECT * FROM tutors WHERE tutor_id = '$tutor_id'";
                    $result = mysqli_query($db, $query);
                    if ($result) {
                        $_SESSION['tutor'] = mysqli_fetch_assoc($result); 
                    }
            
                    echo "<script>alert('Profile updated successfully!'); window.location.href='SettingsPage.php';</script>"; 
                    exit();
                } else {
                    echo "Error updating profile: " . mysqli_error($db);
                }
            }
            ?>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            let selectedTab = document.getElementById(tabId);
            let activeLink = document.querySelector('.tab-link.active');

            // If the clicked tab is already active, do nothing
            if (activeLink && activeLink.getAttribute('data-tab') === tabId) {
                return;
            }

            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            // Remove active class from all links
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
            });

            // Show selected tab
            if (selectedTab) {
                selectedTab.style.display = 'block';
            }
           

            // Add active class to the clicked tab
            event.currentTarget.classList.add('active');
        }

    </script>












    <!-- <script>
        function showTab(tabId) {

            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('active');
            });

            document.getElementById(tabId).style.display = 'block';

            event.currentTarget.classList.add('active');


        }
    </script> -->


    <!-- Footer -->
    <?php require('components/footer2.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
