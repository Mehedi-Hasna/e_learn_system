<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 3/21/2021
 * Time: 9:02 PM
 */

    session_start();
    require_once '../php/db_connect.php';


    if (isset($_POST['course_id'])){
        $course_id   = $_POST['course_id'];

        $sql = "SELECT * FROM courses WHERE course_id = '$course_id'";
        $res = mysqli_query($connect, $sql);

        $m_data = mysqli_fetch_assoc($res);

        echo json_encode($m_data);
    }

    if (isset($_POST['add_price'])){
        $course_id  = $_POST['course_id'];
        $price       = $_POST['course_price'];

        if ($price){

            $add_price     = "UPDATE courses SET course_price = '$price' WHERE course_id = $course_id";
            $res_add_price = mysqli_query($connect, $add_price);

            $_SESSION['success'] = 'Course Fee Added successfully';

            header('Location: manage-course.php');
        }else{
            $_SESSION['error'] = 'Course Fee Added Failed...!!';

            header('Location: manage-course.php');
        }
    }
?>

