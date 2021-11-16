<?php

function set_session_fail($msg){
    $_SESSION['error'] = $msg ;
}
function set_session_success($msg){
    $_SESSION['success'] = $msg ;
}
function check_session(){
    if(isset($_SESSION['error'])){
        $msg = $_SESSION['error'] ;
        unset($_SESSION['error']);
        echo "<p>".$msg."</p>" ;  
        return TRUE;                         
    }elseif(isset($_SESSION['success'])){
        $msg = $_SESSION['success'] ;
        unset($_SESSION['success']);
        echo "<p>".$msg."</p>" ;     
        return TRUE;                   
    }else{
        return false;
    }
}
