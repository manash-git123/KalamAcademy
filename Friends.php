<?php
    include 'Connection.php';
    // Get All Users API
    if($_REQUEST['operation']==="getUsers"){
        $sql = "SELECT `username` FROM `authentication`";
        $result = mysqli_query($con,$sql);
        $allUsers = "";
        while($rows = mysqli_fetch_array($result)){
            if($allUsers == null){
                $allUsers = $rows[0];
            }else{
                $allUsers = $allUsers.",".$rows[0];
            }
        }
        echo $allUsers;
    }  
    
    // Get Friend List API
    if ($_REQUEST['operation']=="listFriends") {
        $username = $_REQUEST['username'];
        $sql = "SELECT * FROM `friend_request` WHERE `status`= 1";
        $result = mysqli_query($con,$sql);
        $allFriends= "";
        while($rows = mysqli_fetch_array($result)){
            if($rows['user_from']==$username){
                $temp = $rows['user_to'];
            }else if($rows['user_to']==$username){
                $temp = $rows['user_from'];
            }else{
                $temp= "";
            }
            if($allFriends== null){
                $allFriends= $temp;
            }else{
                $allFriends= $allFriends.",".$temp;
            }
        }
        echo $allFriends;
    }

    // Send Friend Request API
    if($_REQUEST['operation']==="sendRequest"){
        $sql = "INSERT INTO `friend_request` (`user_to`,`user_from`,`status`) VALUES ('".$_REQUEST['to']."','".$_REQUEST['from']."',0)";
        if(mysqli_query($con,$sql)){
            echo 1;
        }else{
            echo 0;
        }
    }

    // Display Friend Request API
    if($_REQUEST['operation']==="recievedRequests"){
        $username = $_REQUEST['username'];
        $sql = "SELECT `user_from` FROM `friend_request` WHERE `user_to` = '".$username."' AND `status`= 0";
        $result = mysqli_query($con,$sql);
        $recieved = "";
        while($rows = mysqli_fetch_array($result)){
            if($recieved == null){
                $recieved = $rows[0];
            }else{
                $recieved = $recieved.",".$rows[0];
            }
        }
        echo $recieved;
    }

    // API to check wether a user has sent Friend Request 
    if($_REQUEST['operation']==="checkSent"){
        $to = $_REQUEST['to'];
        $from = $_REQUEST['from'];
        $sql = "SELECT * FROM `friend_request` WHERE `user_to` = '".$to."' AND `user_from` = '".$from."' AND `status`= 0";
        $result = mysqli_query($con,$sql);
        if($rows = mysqli_fetch_array($result)){
            echo 1;
        }else{
            echo 0;
        }
    }

// Accept Friend Request API
    if ($_REQUEST['operation']=="acceptRequest") {
        $to = $_REQUEST['to'];
        $from = $_REQUEST['from'];
        $sql = "UPDATE `friend_request` SET `status`= 1 WHERE `user_to` = '".$to."' AND `user_from` = '".$from."' AND `status`= 0";
        if(mysqli_query($con,$sql)){
            echo 1;
        }else{
            echo 0;
        }

    }

// Delete Friend Request API
    if ($_REQUEST['operation']=="deleteRequest") {
        $to = $_REQUEST['to'];
        $from = $_REQUEST['from'];
        $sql = "DELETE FROM `friend_request` WHERE `user_to` = '".$to."' AND `user_from` = '".$from."' AND `status`= 0";
        if(mysqli_query($con,$sql)){
            echo 1;
        }else{
            echo 0;
        }

    }

// Unfriend A userHandle API

    if($_REQUEST['operation']=="unfriend"){
        $username = $_REQUEST['username'];
        $exFriend = $_REQUEST['userHandle'];
        $sql = "DELETE FROM `friend_request` WHERE `user_from`='$username' AND `user_to`='$exFriend' OR `user_from`='$exFriend' AND `user_to`='$username'";
        if(mysqli_query($con,$sql)){
            echo 1;
        }else{
            echo 0;
        }
    }

?>