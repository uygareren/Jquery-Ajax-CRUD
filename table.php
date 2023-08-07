<?php
include('config.php');
?>


<table id="myTable">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Course</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php
    $query = "SELECT * FROM students";
    $q = $db->prepare($query);
    $q->execute();
    $students = $q->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $student) {
    ?>
        <tr>
            <td><?php echo $student['name']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td><?php echo $student['phone']; ?></td>
            <td><?php echo $student['course']; ?></td>
            <td><button>Edit</button></td>
            <td><button>Delete</button></td>
        </tr>
    <?php
    }
    ?>
</table>