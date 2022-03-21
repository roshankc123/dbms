<?php
    include 'main.php';
    $conn = mysqli_connect("127.0.0.1","roshan","helloworld","dbms_project");
    $subject = $_GET['subject'];
    $class = $_GET['class'];
    if(!$class){
        $query = mysqli_query($conn,"select * from classes;");
        $data = mysqli_fetch_all($query, MYSQLI_NUM);
        $i=0;
        while($a = $data[$i]){
            echo '<a href="attendance.php?class='.$a[0].'">'.$a[0].'</a><br>';
            $i++;
        }
        die();
    }
    if(!$subject){
        $query = mysqli_query($conn,"select subjects.s_code,subjects.s_name from subjects;");
        $data = mysqli_fetch_all($query, MYSQLI_NUM);
        $i=0;
        while($a = $data[$i]){
            echo '<a href="attendance.php?class='.$class.'&subject='.$a[0].'">'.$a[1].'</a><br>';
            $i++;
        }
        session_start();
        $_SESSION['id'] = hash("md5",time());
        $query = mysqli_query($conn,"select total_students from classes where class = substr('".$class."',1,9);");
        $data = mysqli_fetch_all($query, MYSQLI_NUM);
        $_SESSION['max'] = $data[0][0];
        die();
    }else{
        $subject = $_GET['subject'];
        // echo $subject;
    }
    session_start();
    if(!isset($_SESSION['id'])){
        echo "please choose appropriate subject and class.";
    }
    $current_roll = $_GET['roll'];
    if($current_roll < 10){
        $roll = $class.'00'.$current_roll;
    }else if($current_roll < 100){
        $roll = $class.'0'.$current_roll;
    }else{
        $roll = $class.$current_roll;
    }
    $next_roll = $current_roll + 1;
    if($next_roll > $_SESSION['max']){
        session_unset();
        session_destroy();
        echo "record saved successfully. <a href=\"/\" >home</a>";
        die;
    }
    $presence = $_GET['presence'];
    if($presence == "yes"){
        if(!(mysqli_query($conn, "insert into records values (0,'".$roll."',curdate(),'".$subject."')"))){
            echo "something error";
            // echo mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-attendance</title>
</head>
<body>
    <h3><?=$class?> </h3>
    <h3>roll: <?=$next_roll?></h3>
    <form action="" method="get">
        <input type="hidden" name="class" value="<?=$class?>">
        <input type="hidden" name="roll" value="<?=$next_roll?>">
        <input type="hidden" name="subject" value="<?=$subject?>">
        <input type="submit" name="presence" value="yes">
        <input type="submit" name="presence" value="no">
    </form>
</body>
</html>