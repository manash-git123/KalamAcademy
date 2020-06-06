<?php 
include 'Connection.php';


    if($_REQUEST['operation'] === "signup"){

        $sql = "SELECT * FROM `authentication`";
        $result = mysqli_query($con,$sql);
        $exist = 0;
        while($rows = mysqli_fetch_assoc($result)){
            if($_REQUEST['username'] == $rows['username']){
                $exist = 1;
            }
        }
         if($exist == 1){
             echo 0;
         }else{
             $hashPassword = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);   
             $sql = "INSERT INTO `authentication` (`username`,`password`) VALUES ('".$_REQUEST['username']."','".$hashPassword."')";
             $result = mysqli_query($con,$sql);
             echo $sql;
         }
    }


    if($_REQUEST['operation'] === "login"){
        $sql = "SELECT * FROM `authentication`";
        $result = mysqli_query($con,$sql);
        $exist = 0;
        while($rows = mysqli_fetch_assoc($result)){
            if($_REQUEST['username'] == $rows['username']){
                if(password_verify($_REQUEST['password'],$rows['password'])){
                    echo 1; //1 for all correct
                }else{
                    echo 2; //2 for incorrect password
                }
            }else{
                echo 0; //0 for incorrect username
            }
        }
    }


?>