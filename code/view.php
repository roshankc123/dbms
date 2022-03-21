<?php
    include 'main.php';
    $conn = mysqli_connect("127.0.0.1","roshan","helloworld","dbms_project");
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
                    echo '<a href="view.php?class='.$a[0].'">'.$a[0].'</a><br>';
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
                    echo '<a href="view.php?class='.$class."&roll=".$class.$a.'">'.$a.'</a><br>';
                    $i++;
                }
            }else if(!$subject){
                $query = mysqli_query($conn,"select s_code,s_name from subjects;");
                $data = mysqli_fetch_all($query, MYSQLI_NUM);
                $i=0;
                while($a = $data[$i]){
                    echo '<a href="view.php?class='.$class.'&roll='.$roll.'&subject='.$a[0].'">'.$a[1].'</a><br>';
                    $i++;
                }
            }else{
                $query = mysqli_query($conn,"select count(s_roll),
                                                (select count(distinct a_date) from records 
                                                where substr(records.s_roll,1,9) = '".$class."' and 
                                                s_code='".$subject."') from records 
                                                where records.s_roll='".$roll."' and 
                                                records.s_code='".$subject."';");
                echo mysqli_error($conn);
                $data = mysqli_fetch_all($query, MYSQLI_NUM);
                echo $data[0][0]." out of ".$data[0][1]." days";
            }
            
            
        
    ?>
</body>
</html>