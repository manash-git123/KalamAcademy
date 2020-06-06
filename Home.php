<?php
    include "Connection.php";

    // Send Update API
    if($_REQUEST['operation']==="sendUpdate"){
        $message = $_REQUEST['message'];
        $author = $_REQUEST['author'];
        $sql = "INSERT INTO `updates` (`author`,`update`) VALUES ('$author','$message')";
        if(mysqli_query($con,$sql)){
            echo 1;
        }else{
            echo 0;
        }
        
    }

    // Get Friends API
    if($_REQUEST['operation']=="getUpdates"){
        $friendList = $_REQUEST['friendList'];
        $username = $_REQUEST['username'];
        $sql = "SELECT * FROM `updates` WHERE `author`<>'$username' ORDER BY id DESC";
        $result = mysqli_query($con,$sql);
        $output = "";
        $total_updates = 0;
        while($rows = mysqli_fetch_array($result))  {

            foreach ($friendList as $friend) {
                if($rows['author']==$friend){
                    $author = $rows['author'];
                    $output = $output .$rows['author']."<-->".$rows['update']."||end||";
                    $total_updates++;       
                }
            }
        }  
        echo $output; 
    }



 
 
  
?>