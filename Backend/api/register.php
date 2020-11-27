<?php
    error_reporting(E_ALL);

    ini_set("display_errors", 1);
    
    $id = $_GET['id'];
    $pw = $_GET['pw'];

    // 기초적인 타입체크 후 오류 잡아내기 //
    if($id == NULL || $pw == NULL)                  { echo '{ "Res": "Error", "Code": "SendValueNull" }'; } // 값이 없음
    if(preg_replace('/[0-9]/', '', $id) != NULL)    { echo '{ "Res": "Error", "Code": "IdIsntNumber" }'; } // 학번이 숫자로 주어지지 않음
    if(strlen($id) != 5)                            { echo '{ "Res": "Error", "Code": "WrongId" }'; } // 아이디가 길거나 짧음
    if(mb_strlen($pw, "UTF-8") > 20)                { echo '{ "Res": "Error", "Code": "TooLongPw" }'; } // 비밀번호가 김

    // 데이터베이스 연결 //
    $sql = mysqli_connect('localhost','testaccount','testpassword','iruo-backend');
    if (mysqli_connect_errno($sql)){ echo '{ "Res": "Error", "Code": "DatabaseConnectFail" }'; } // 데이터베이스 연결 실패
    else{
        $query = 'SELECT `id` FROM `account` WHERE `id` ='.$id;
        $result=mysqli_query($sql,$query);
        
        if(mysqli_affected_rows($sql) != 0){ echo '{ "Res": "Error", "Code": "AlreadyUseId" }'; }
        else{
            $query = 'INSERT INTO `account`(`id`, `pw`, `state`, `rank`) VALUES ('.$id.',"'.$pw.'","off",0)';
            $result= mysqli_query($sql,$query);
            echo '{ "Res": "Done" }';
        }
    }
    
?>