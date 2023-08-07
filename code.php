<?php

include('config.php');

if(isset($_POST['save_student'])){
    $name = $_POST["name"];
    $email=  $_POST["email"];
    $phone = $_POST["phone"];
    $course = $_POST["course"];



    if($name == NULL || $email == NULL || $phone == NULL || $course == NULL){
        $res = [
            'status' => 400,
            "message" =>"Please fill all the fields",
        ];

        echo json_encode($res);
        return false;
    }

    $query = "INSERT INTO students(name, phone, email, course) VALUES (?, ?, ?, ?)";

    $q = $db->prepare($query);
    $result = $q->execute([$name, $phone, $email, $course]);
    
    if($result){
        $res = [
            'status' => 200,
            "message" =>"Succesfull",
        ];

        echo json_encode($res);
        return true;
    }else{
        $res = [
            'status' => 400,
            "message" =>"Students cannot be added!",
        ];

        echo json_encode($res);
        return false;
    }

}

?>