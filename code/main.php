<?php
    function classes($conn){
        $query = mysqli_query($conn,"select * from classes;");
        return mysqli_fetch_all($query, MYSQLI_NUM);
    }

    function subjects($conn){
        $query = mysqli_query($conn,"select subjects.s_code,subjects.s_name from subjects;");
        return mysqli_fetch_all($query, MYSQLI_NUM);
    }

    function total_students($conn, $class){
        $query = mysqli_query($conn,"select total_students from classes where class = substr('".$class."',1,9);");
        return mysqli_fetch_all($query, MYSQLI_NUM)[0][0];
    }

    function insert_attendance($conn, $roll, $subject){
        if(!(mysqli_query($conn, "insert into records values (0,'".$roll."',curdate(),'".$subject."','".$_SESSION['id']."')"))){
            return -1;
        }
        return 1;
    }

    function fetch_presence_specific($conn, $subject, $roll, $class){
        $query = mysqli_query($conn,"select count(s_roll),
                                    (select count(distinct id) from records 
                                    where substr(records.s_roll,1,9) = '".$class."' and 
                                    s_code='".$subject."') from records 
                                    where records.s_roll='".$roll."' and 
                                    records.s_code='".$subject."';");
        return mysqli_fetch_all($query, MYSQLI_NUM);
    }

    function fetch_presence_all($conn,$roll){
        $query = mysqli_query($conn,"select records.a_date,subjects.s_name from records 
                                                inner join subjects on records.s_code=subjects.s_code
                                                where records.s_roll='".$roll."';");
        return mysqli_fetch_all($query, MYSQLI_NUM);
    }
?>