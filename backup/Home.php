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

    // Get Friends Update(paginated) API
    if($_REQUEST['operation']=="getUpdates"){
        $friendList = $_REQUEST['friendList'];
        $username = $_REQUEST['username'];
        $updates_per_page = 20; 
        if(isset($_REQUEST["page"]))  {  
            $page = $_REQUEST["page"];  
        }  
        else  {  
            $page = 1;  
        }
        $start_from = ($page - 1)*$updates_per_page;
        $sql = "SELECT * FROM `updates` WHERE `author`<>'$username' ORDER BY id DESC LIMIT $start_from, $updates_per_page";
        $result = mysqli_query($con,$sql);
        $output = "<div class='container mt-5'>";
        $total_updates = 1;
        while($rows = mysqli_fetch_array($result))  {

            foreach ($friendList as $friend) {
                if($rows['author']==$friend){
                    $author = $rows['author'];
                    $output = $output . "<p>Update from <i>".$author."</i>
                                            <br>
                                            <span class='border border-dark' style='padding-left:5px;padding-right:5px;'>".$rows['update']."</span>
                                        </p>";
                    
                }
            }$total_updates++;
        }  
        $output .= '</div><br /><div align="center">';    
        $total_pages = ceil($total_updates/$updates_per_page); 
        for($i=1; $i<=$total_pages; $i++)  
        {  
             $output .= "<span class='page_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."' onclick='getUpdates(".$i.")'>".$i."</span>";  
        }  
        $output .= '</div><br /><br />';  
        echo $output; 
    }



 
 
  
?>