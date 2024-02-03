<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy books', 'Please buy Books From Store', current_timestamp());

$insert = false;
$update = false;
$delete = false;
// connect to the database

$servername = "localhost:4306";
$username = "root";
$password = "";
$database = "notes";

// create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// die if connection was not successful

if (!$conn) {
  die("Sorry we failed to connect : " . mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `sno` = $sno";
  $result=mysqli_query($conn,$sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    // update the record 
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    // sql query to be executed

    $sql = "UPDATE `notes` SET `title`= '$title' , `description`='$description' WHERE `notes`.`sno`=$sno";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update=true;
    }
    else{
      echo "we could not update the record successfully";
    }
  } else {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // sql query to be executed

    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      // echo "The record has been inserted successfully.<br>";
      $insert = true;
    } else {
      echo "The record was not inserted successfully because of this error----------->" . mysqli_error($conn);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iNote - so taking made easy</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



</head>

<body>

  <!--edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

  <!-- edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="./Index.php" method="post">
        <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" aria-describedby="emailHelp" name="titleEdit">
            </div>

            <div class="form-group">
              <label for="description" class="mb-2">Note Desciption</label>
              <textarea class="form-control" id="descriptionEdit" rows="3" name="descriptionEdit"></textarea>
            </div>
          
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">INotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
   <?php
  if ($delete) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>
   <?php
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
  }
  ?>

  <!-- container------------------------------------------ -->

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="./Index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
      </div>

      <div class="form-group">
        <label for="description" class="mb-2">Note Desciption</label>
        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary my-3">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <?php
    // $sql = "SELECT * FROM `notes`";
    // $result = mysqli_query($conn, $sql);
    // while ($row = mysqli_fetch_assoc($result)) {
    //   // echo var_dump($row)
    //   echo $row['sno'] . "Title " . $row['title'] . " Desc is " . $row['description'];
    //   echo "<br>";
    // }

    ?>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <!-- <th scope="col" class="table-primary ">S.No</th>
          <th scope="col" class="table-primary">Title</th>
          <th scope="col" class="table-primary">Desciption</th>
          <th scope="col" class="table-primary">Actions</th> -->

          <th scope="col" class="">S.No</th>
          <th scope="col" class="">Title</th>
          <th scope="col" class="">Desciption</th>
          <th scope="col" class="">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo " <tr>
      <th scope='row'>" . $sno . "</th>
      <td>" . $row['title'] . "</td>
      <td>" . $row['description'] . "</td>
      <td> <button class='edit btn btn-sm btn-dark' id=" . $row['sno'] . ">Edit</button> <button class='btn btn-sm btn-dark delete' id=d" . $row['sno'] . ">Delete</button></td>
    </tr>";
          // echo $row['sno']."Title ".$row['title']. " Desc is ". $row['description'];
          // echo "<br>";
        }

        ?>


      </tbody>
    </table>
  </div>
  <hr>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit')
    Array.from(edits).forEach((element) => {
      element.addEventListener('click', (e) => {
        console.log("edit ", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName('td')[0].innerText;
        description = tr.getElementsByTagName('td')[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle')
      })
    })

    deletes = document.getElementsByClassName('delete')
    Array.from(deletes).forEach((element) => {
      element.addEventListener('click', (e) => {
        console.log("delete ", );
        sno=e.target.id.substr(1,)
        if(confirm("Are You Sure You Want To Delete This Note!")){
          console.log("yes");
          window.location=`./index.php?delete=${sno}`;

          // TODO : Create a form and use post request to submit a form
        }
        else{
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>