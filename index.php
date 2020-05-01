<?php
require_once "inc/functions.php";
$info  = '';
$task  = $_GET['task'] ?? 'report';
$error  = $_GET['error'] ?? '0 ';

if('delete' == $task ){
    $id =  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if($id > 0 ){
        deleteStudent($id);
        header('location: index.php?task=report');
    }
}
if ( 'seed' == $task ) {
    seed();
    $info = "Seeding is complete";
}
$lname = '';
$fname = ' ';
$roll = ' ';
if(isset($_POST['submit'])){
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
   if($id){
    //Update the existing students
    if($fname != '' && $lname != '' && $roll != ''){
       $result = updateStudent($id, $fname, $lname, $roll);
       if($result){
        header('location: index.php?task=report');
       }else{
           $error = 1;
       }
    }
   }else {
       //add the new student
    if($fname != '' && $lname != '' && $roll != ''){
        $result =  addStudent($fname, $lname, $roll);
        if($result){
         header('location: index.php?task=report');
        }else{
            $error = 1;
        }
     }
   }

}

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" >
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.css" >
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2>Project - 2  - CRUD</h2>
            <p>A simple project to perform CRUD operations using plain fails and PHP</p>
           <?php include_once('inc/templates/nav.php'); ?>
           
           <hr>
           <?php 
           if($info != " "){
               echo "<p>{$info}</p>";
           }
 
           ?>
        </div>
    </div>
    <?php if('1' == $error) : ?>
    <div class="row">
    <div class="column column-60 column-offset-20">
       <blockquote>Duplicate Roll Number</blockquote>
    </div>
    </div>
    <?php endif; ?>

    <?php if('report' == $task) : ?>
    <div class="row">
    <div class="column column-60 column-offset-20">
        <?php generateReport() ?>
    </div>
    </div>
    <?php endif; ?>
    <?php if('add' == $task) : ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form action="index.php?task=add" method="POST">
                    <label for='fname'> First Name </label>
                    <input type="text" name="fname" id="fnaem" value="<?php echo $fname; ?>" >
                    <label for='lname'> Last Name </label>
                    <input type="text" name="lname" id="lname"  value="<?php echo $lname; ?>">
                    <label for='roll'> Roll</label>
                    <input type="number" name="roll" id="roll"  value="<?php echo $roll; ?>">
                    <button type="submit" class="button-primary" name="submit">Save</button>
                </form>
            </div>
    </div>
    <?php endif; ?>
    <?php if('edit' == $task) : 
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $student = getStudent($id);
        if( $student ) :
        ?>
        <div class="row">
            <div class="column column-60 column-offset-20">
                <form method="POST">
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                    <label for='fname'> First Name </label>
                    <input type="text" name="fname" id="fnaem" value="<?php echo $student['fname']; ?>" >
                    <label for='lname'> Last Name </label>
                    <input type="text" name="lname" id="lname"  value="<?php echo $student['lname']; ?>">
                    <label for='roll'> Roll</label>
                    <input type="number" name="roll" id="roll"  value="<?php echo $student['roll']; ?>">
                    <button type="submit" class="button-primary" name="submit">Update</button>
                </form>
            </div>
    </div>
    <?php
     endif;
    endif; 
     ?>
</div>

<script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>