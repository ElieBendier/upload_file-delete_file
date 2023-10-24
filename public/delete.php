<?php

if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    if(!empty($_POST['file'])){
        $avatar = $_POST['file'];
            if(file_exists($avatar)){
            unlink($avatar);
        }
    }   
}
