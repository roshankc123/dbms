<?php
    include 'main.php';
    $conn = mysqli_connect("127.0.0.1","root","","DBMS_project");
    $subject = $_GET['subject'];
    $class = $_GET['class'];
    $roll = $_GET['roll'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, td {
            border:1px solid black;
        }
    </style>
    <title>e-attendance</title>
</head>
<body>
    <?php
            if(!$class){
                ///////for who
                $query = mysqli_query($conn,"select class from classes;");
                $data = mysqli_fetch_all($query, MYSQLI_NUM);
                $i=0;
                while($a = $data[$i]){
                    echo '<a href="viewall.php?class='.$a[0].'">'.$a[0].'</a><br>';
                    $i++;
                }
            }else if(!$roll){
                $query = mysqli_query($conn, "select total_students from classes where class = '".$class."';");
                $data = mysqli_fetch_all($query);
                $i=1;
                while($i <= $data[0][0]){
                    $a = $i;
                    if($a < 10){
                        $a = '00'.$a;
                    }else if($a < 100){
                        $a = '0'.$a;
                    }
                    echo '<a href="viewall.php?class='.$class."&roll=".$class.$a.'">'.$a.'</a><br>';
                    $i++;
                }
            }else{
                $query = mysqli_query($conn,"select records.a_date,subjects.s_name from records 
                                                inner join subjects on records.s_code=subjects.s_code
                                                where records.s_roll='".$roll."';");
                $data = mysqli_fetch_all($query, MYSQLI_NUM);
                $i=0;
                echo '<table><tr><th>date</th><th>subject</th></tr>';
                while($a = $data[$i]){
                    echo "<tr><td>".$data[$i][0]."</td><td>".$data[$i][1]."</td></tr>";
                    $i++;
                }
                echo "<table>";
            }
             
    ?>
</body>
</html>