<?php 
include_once('../includes/config.php');
include_once('header.php');
include_once('sidebar.php');
include_once('../includes/functions.php');

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
                <h1 class="m-0 text-dark">Student Attendance</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Date</td>
                            <td>Status</td>
                            <td>Singin Time</td>
                            <td>Singout Time</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

// Simulated attendance data
$attendance_data = array(
    '2024-05-01' => array('signin_at' => strtotime('2024-05-01 08:00:00'), 'signout_at' => strtotime('2024-05-01 16:00:00')),
    '2024-05-02' => array('signin_at' => strtotime('2024-05-02 08:05:00'), 'signout_at' => strtotime('2024-05-02 16:10:00')),
    '2024-05-03' => array('signin_at' => strtotime('2024-05-03 08:03:00'), 'signout_at' => strtotime('2024-05-03 16:02:00')),
    //'2024-05-04' => array('signin_at' => strtotime('2024-05-03 08:03:00'), 'signout_at' => strtotime('2024-05-03 16:02:00')),
    // Add more simulat
    // Add more simulated data as needed
);

foreach ($attendance_data as $date => $value) {
?>
<tr>
    <td><?php echo $date;?></td>
    <td><?php echo ($value['signin_at'])? 'Present' : 'Absent';?></td>
    <td><?php echo ($value['signin_at'])? date('d-m-Y H:i:s', $value['signin_at']) : '';?></td>
    <td><?php echo ($value['signout_at'])? date('d-m-Y H:i:s', $value['signout_at']) : '';?></td>
</tr>
<?php
}
?>



                    </tbody>
                </table>
            </div>
        </div>
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

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

<?php include('footer.php') ?>
