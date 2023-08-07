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
            'status' => 500,
            "message" =>"Students cannot be deleted!",
        ];

        echo json_encode($res);
        return false;
    }

}
if(isset($_GET['student_id'])){

    $student_id = $_GET['student_id'];

    $query = "SELECT * FROM students WHERE id = ?";
    $q = $db->prepare($query);
    $q->execute([$student_id]);
    $result = $q->fetch(PDO::FETCH_ASSOC); // Tek bir satırı al

    if($result){
        $res = [
            'status' => 200,
            "message" => "Successful",
            "data" => $result
        ];

        echo json_encode($res);
    }else{
        $res = [
            'status' => 400,
            "message" => "Student not found",
            "data" => null
        ];

        echo json_encode($res);
    }
}
if(isset($_POST['update_student'])){
    $student_id = $_POST['student_id'];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $course = $_POST["course"];

    $query = "UPDATE students SET name=?, email=?, phone=?, course=? WHERE id=?";

    $q = $db->prepare($query);
    $result = $q->execute([$name, $email, $phone, $course, $student_id]);

    if($result && $q->rowCount() > 0){
        $res = [
            'status' => 200,
            "message" => "Successful",
        ];

        echo json_encode($res);
    } else {
        $res = [
            'status' => 400,
            "message" => "Student update failed",
        ];

        echo json_encode($res);
    }
}
if(isset($_GET['delete_student'])){
    $student_id = $_GET['student_id']; // Doğru GET parametresini alın

    $query = "DELETE FROM students WHERE id=?";
    $q = $db->prepare($query);
    $result = $q->execute([$student_id]); // ID'yi execute'ye verin

    if($result && $q->rowCount() > 0){
        $res = [
            'status' => 200,
            "message" => "Successful",
        ];

        echo json_encode($res);
    } else {
        $res = [
            'status' => 500,
            "message" => "Student delete failed",
        ];

        echo json_encode($res);
    }
}



?>