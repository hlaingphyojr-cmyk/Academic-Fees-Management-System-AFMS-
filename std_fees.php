<?php include 'db_connect.php' ?>
<?php
header('Content-Type: application/json');

if(isset($_POST['student_id'])){
    $student_id = $_POST['student_id'];

    $sql = "SELECT id_no FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode($row['id_no']);
    $stmt->close();
    $conn->close();
}
?>