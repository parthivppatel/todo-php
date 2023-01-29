<?php
 
 $servername='localhost:3307';
 $username='root';
 $password='';
 $db='notes';
 $insert;
 $delete;
 $update;
 
 $conn=mysqli_connect($servername,$username,$password,$db);
#insert data
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(!isset($_POST['eid']) ){
    $title=$_POST['title'];
    $description=$_POST['description'];

    if(!$conn){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      connection error
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
 
    }
    else{
      $today=date("Y-m-d h:i:s");
      $sql="insert into note(title,description,time) values ('$title','$description','$today')" ;
      $result=mysqli_query($conn,$sql);
      global $insert; 

      if(!$result){
        echo "hello";
        $insert= false;
      }
      else{
        $insert = true;
      }
    }
  }
  else{
    $title=$_POST['editTitle'];
    $description=$_POST['editDescription'];
    $id=$_POST['eid'];
    if(!$conn){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      connection error
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
 
    }
    else{
      $sql="update note set title= '$title', description='$description' where id =$id" ;
      $result=mysqli_query($conn,$sql);
      global $update; 

      if(!$result){
        $update= false;
      }
      else{
        $update = true;
      }
    }
  }
}

if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action'])){ 
  if($_GET['action']=="delete"){
    $id=(int)$_GET['id'];
    $sql= "delete from note where id=$id";
    $result=mysqli_query($conn,$sql);
    if($result){
      $delete=true;
      // header("Location:http://localhost/notes/index.php");

    }
    else{
      $delete=false;
      //  header("Location:http://localhost/notes/index.php");
    }
  }

}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

  </head>
  <body>
    <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
    });
      </script>
<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <!-- Navbar content -->
  <div class="container-fluid">
    <a class="navbar-brand" href="#">MyNotes</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About us </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact us </a>
        </li>
        
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<!-- Edit Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="http://localhost/notes/index.php" method="post">
          <input type="hidden" name="eid" id="eid" >
          <div class="mb-3 mx-5">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" class="form-control" id="editTitle"name="editTitle" required aria-describedby="emailHelp">
          </div>
          <div class="mb-3 mx-5">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" name="editDescription" id="editDescription" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
global $insert;
if ($insert==false && $insert!=null){
echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Data not Inserted
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}
else if($insert){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        Data Inserted Succesfully
        </div>";
}
?>
<?php
global $delete;
if ($delete==false && $delete!=null){
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  Data Not Deleted
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
else if($delete){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          Data Deleted Succesfully
          </div>";
}
?>
<?php
global $update;
if ($update==false && $update!=null){
  echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  Data Not Updated
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
else if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          Data Updated Succesfully
          </div>";
}
?>


<div class="container my-4">
    <h4 class="mx-5 mb-3">Add Note</h4>
    <form action="http://localhost/notes/index.php" method="post">
  <div class="mb-3 mx-5">
    <label for="exampleInputEmail1" class="form-label">Title</label>
    <input type="text" class="form-control" id="exampleInputEmail1"name="title" required aria-describedby="emailHelp">
  </div>
  <div class="mb-3 mx-5">
    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-success mx-5">Add Note</button>
</form>
</div>
<div class="container my-5">
    <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">title </th>
            <th scope="col">Description </th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $sql="select * from note";
          $result=mysqli_query($conn,$sql);
          $num=mysqli_num_rows($result);

          if($num>0){
            $no=1;
            while($row=mysqli_fetch_assoc($result)){
              
              echo "<tr>
              <th>".$no."</th>
              <td>".$row['title']."</td>
              <td>".$row['description']."</td>
              <td>".$row['time']."</td>
              <td><button class='edit btn btn-sm btn-primary' id=".$row['id'].">Edit</button>    <a href='http://localhost/notes/index.php/?action=delete&id={$row['id']}' class='btn btn-sm btn-danger'>Delete</button></a>
            </tr>";
            $no++; 
            
            }
          }
          else{
            echo "<tr align='center'>
            <td colspan='5'>No Data</td></tr>";
          }
          ?>

        </tbody>
      </table>
</div>


 
  <script>
   if(!$("td").hasClass("edit")){
     edit=document.getElementsByClassName('edit');
     Array.from(edit).forEach((element)=>{
       element.addEventListener("click",(e)=>{
       //  console.log(e);
       //  console.log("Edit",e.target.parentNode.parentNode);
       tr=e.target.parentNode.parentNode;
       title=tr.getElementsByTagName("td")[0].innerText;
       description=tr.getElementsByTagName("td")[1].innerText;
       id=e.target.id;
       // console.log(title);
       // console.log(description);
       // console.log(id);
       $("#EditModal").modal('toggle');
       //through id
       editTitle.value=title;
       editDescription.value=description;
       eid.value=id;
       })
     })
   }
    
    </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>