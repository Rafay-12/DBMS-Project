<?php
include_once('../includes/config.php');
include_once('header.php');
include_once('sidebar.php');
include_once('../includes/functions.php');

// Initialize message variable
$message = "";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if attendance status data is present in the request
    if (isset($_POST['attendance_status']) && !empty($_POST['attendance_status'])) {
        // Process each attendance status
        foreach ($_POST['attendance_status'] as $date => $status) {
            // Update the database with the new attendance status
            $date = mysqli_real_escape_string($db_conn, $date);
            $status = mysqli_real_escape_string($db_conn, $status);
            $sql = "UPDATE attendance SET status = '$status' WHERE attendance_date = '$date'";
            $result = mysqli_query($db_conn, $sql);
            if ($result) {
                $message = "Attendance updated successfully.";
            } else {
                $message = "Error updating attendance: " . mysqli_error($db_conn);
            }
        }
    } else {
        // Handle the case where attendance status data is missing
        $message = "Error: Attendance status data is missing.";
    }
}

// Retrieve $std_id from the database
$sql = "SELECT id FROM accounts WHERE type = 'student'";
$query = mysqli_query($db_conn, $sql);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    $std_id = $row['id'];

    // Check if $std_id is defined and not empty
    if (!empty($std_id)) {
        // Retrieve user metadata using $std_id
        $usermeta = get_user_metadata($std_id);
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Manage Student Attendance</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Student</a></li>
                    <li class="breadcrumb-item active">Attendance</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if (!empty($message)) : ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Detail</h3>
            </div>
            <div class="card-body">
                <strong>Name: </strong><?php echo get_users(array('id' => $std_id))[0]->name ?><br>
                <strong>Class: </strong><?php echo $usermeta['class'] ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance</h3>
            </div>
            <div class="card-body">
                <!-- Attendance marking form -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Dummy attendance data
                            $dummy_attendance = array(
                                '2024-05-01' => 'absent',
                                '2024-05-02' => 'absent',
                                '2024-05-03' => 'absent',
                                //'2024-05-04' => 'absent',
                                // Add more dummy attendance data as needed
                            );

                            // Loop through dummy attendance data and display in table rows
                            foreach ($dummy_attendance as $date => $status) {
                                ?>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td>
                                        <select name="attendance_status[<?php echo $date; ?>]">
                                            <option value="present" <?php echo ($status == 'present') ? 'selected' : ''; ?>>Present</option>
                                            <option value="absent" <?php echo ($status == 'absent') ? 'selected' : ''; ?>>Absent</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

<?php include('footer.php'); ?>

<?php
    } else {
        // Handle the case where $std_id is missing or invalid
        echo "Error: \$std_id is missing or invalid.";
    }
} else {
    // Handle the case where the database query fails
    echo "Error: Database query failed.";
}
?>
