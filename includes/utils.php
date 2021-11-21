<?php

function set_session_fail($msg){
    $_SESSION['error'] = $msg ;
}
function set_session_success($msg){
    $_SESSION['success'] = $msg ;
}
function set_session_specail($msg){
    $_SESSION['special'] = $msg ;
}
function check_session(){
    if(isset($_SESSION['special'])){
        $msg = $_SESSION['special'] ;
        unset($_SESSION['special']);
        echo '<div class="alert alert-success" role="alert">'.$msg.'</div>' ;  
    }
    if(isset($_SESSION['error'])){
        $msg = $_SESSION['error'] ;
        unset($_SESSION['error']);
        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>' ;  
        return TRUE;                         
    }elseif(isset($_SESSION['success'])){
        $msg = $_SESSION['success'] ;
        unset($_SESSION['success']);
        echo '<div class="alert alert-success" role="alert">'.$msg.'</div>' ;    
        return TRUE;                   
    }else{
        return false;
    }
}
