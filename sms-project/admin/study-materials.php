<?php
include_once('../includes/config.php');
include_once('header.php');
include_once('sidebar.php');
include_once('../includes/functions.php');



// Retrieve $std_id from the database
$sql = "SELECT id FROM accounts where type= 'student'";
$query = mysqli_query($db_conn, $sql);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  // Retrieve form data
  $title = $_POST['title'];
  $class = $_POST['class'];
  $subject = $_POST['subject'];
  $publish_date = $_POST['publish_date'];
 

  // Insert data into the database
  // Write your SQL INSERT query here
  
  // You need to validate and sanitize the form inputs before inserting into the database to prevent SQL injection and other security vulnerabilities
}


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
   
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Study Material</button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add Study Material</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to add study material -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label>Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Class:</label>
                                <input type="text" name="class" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Subject:</label>
                                <input type="text" name="subject" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Publish Date:</label>
                                <input type="date" name="publish_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>File Attachment:</label>
                                <!-- Input field for file attachment -->
                                <!-- Add input field or file upload button as per your design -->
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info boxes -->
        <div class="card">
          <!-- Card content goes here -->
        </div>
    </div>
</section>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Study Materials</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Student</a></li>
                    <li class="breadcrumb-item active">Study Materials</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="card">
          <div class="card-header py-2">
            <h3 class="card-title">
              Study Materials
            </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive bg-white">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Attachment</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                      <?php
                      $usermeta = get_user_metadata($std_id);
                      $class = $usermeta['class'];
                      $count = 1;
                      $query = mysqli_query($db_conn, "SELECT * FROM `posts` as p INNER JOIN `metadata` as m ON p.id = m.item_id WHERE p.`type` = 'study-material' AND m.meta_key = 'class' AND m.meta_value = $class");
                      while ($att = mysqli_fetch_object($query)) {
                        
                        //   $class_id = get_metadata($att->id, 'class')[0]->meta_value;

                          $class = get_post(['id' => $class]);

                          $subject_id = get_metadata($att->item_id, 'subject')[0]->meta_value;

                          $subject = get_post(['id' => $subject_id]);

                          $file_attachment = get_metadata($att->item_id, 'file_attachment')[0]->meta_value;


                          ?>
                      <tr>
                          <td><?=$count++?></td>
                          <td><?=$att->title?></td>
                          <td><a href="<?="../dist/uploads/".$file_attachment; ?>">Download File</a></td>
                          <td><?=$class->title?></td>
                          <td><?=$subject->title?></td>
                          <td><?=$att->publish_date?></td>
                        </tr>
                      <?php } }}?>
                    
                    <!--  <tr>
                           <td>1</td>
                          <td>pdf for english</td>
                          <td><a href="<?="../dist/uploads/".$file_attachment; ?>">Download File</a></td>
                          <td>class-1</td>
                          <td>english</td>
                          <td>2024-05-16</td>-->
                      </tr>
                    </toby>
              </table>
            </div>
          </div>
        </div>
        <!-- /.row -->
    </div>
</section>


<?php include('footer.php') ?>


