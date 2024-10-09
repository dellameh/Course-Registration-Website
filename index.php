<?php


require_once 'includes/dbh.inc.php';
require_once 'includes/config.session.inc.php';

$course = $pdo->query('SELECT * FROM show_course;');
if(isset($_SESSION["user_id"])){
    $sid=$_SESSION["user_id"];


#Query search
if (isset($_GET['search'])) {
    $serch = $_GET['search'];
    $course = $pdo->prepare("SELECT * FROM show_course WHERE name LIKE :search OR professor_name LIKE :search");
    $course->execute(["search" => "%$serch%"]);
 
    if ($serch == "all") {
        $course = $pdo->query('SELECT * FROM show_course');
    }
}


if (isset($_GET["action"])) {
    $id = $_GET["id"];

   
    
    if ($_GET["action"] == 'add') {
        // برای تکرار درس
        $sql = "SELECT EXISTS(SELECT 1 FROM course_std WHERE id_course = :id AND id_std= :sid)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["sid" => $sid, "id" => $id]);
        $exists = $stmt->fetchColumn();
        if ($exists == '1') {
            $x = " این درس قبلا انتخاب شده است";



        } else{

            $selected_course = $pdo->prepare("INSERT INTO course_std(id_std,id_course) VALUES (:sid,:id)");
            $selected_course->execute(["sid" => $sid, "id" => $id]);
             //برای تداخل زمانی 

         $sql_t = "SELECT 
         a.id_std,
         a.id_course AS id_1,
         b.id_course AS id_2,
         a.date,
         a.time AS time_1,
         b.time AS time_2
     FROM
         (SELECT 
             sc.id AS id_course, 
             sc.time AS time, 
             sc.date AS date,
             cs.id_std AS id_std 
         FROM 
             show_course sc
         JOIN 
             course_std cs 
         ON 
             sc.id = cs.id_course) a
     JOIN
         (SELECT 
             sc.id AS id_course, 
             sc.time AS time, 
             sc.date AS date,
             cs.id_std AS id_std 
         FROM 
             show_course sc
         JOIN 
             course_std cs 
         ON 
             sc.id = cs.id_course) b
     ON 
         a.id_std = b.id_std 
         AND a.id_course < b.id_course
         AND a.date = b.date
     WHERE 
         (CAST(SUBSTRING_INDEX(a.time, '-', 1) AS SIGNED) <= CAST(SUBSTRING_INDEX(b.time, '-', -1) AS SIGNED)
         AND 
         CAST(SUBSTRING_INDEX(a.time, '-', -1) AS SIGNED) >= CAST(SUBSTRING_INDEX(b.time, '-', 1) AS SIGNED));";
 
 
         $result = $pdo->query($sql_t);
 
         if ($result->rowCount() > 0) {
             // while($row = $result->fetch(PDO::FETCH_ASSOC)) {
             //     echo "Student ID: " . $row["id_std"]. " - Course 1 ID: " . $row["id_1"]. " - Course 2 ID: " . $row["id_2"]. " - Date: " . $row["date"]. " - Time 1: " . $row["time_1"]. " - Time 2: " . $row["time_2"]. "<br>";
             //     $x="تداخل زمانی دارد!!!!";
             // }
 
             $x = "برخی دروس تداخل زمانی دارند";
             $selected_course = $pdo->prepare("DELETE FROM course_std WHERE id_course=:id AND id_std= :sid;");
            $selected_course->execute(["sid" => $sid, "id" => $id]);
 
         }


        }
        
    } elseif ($_GET["action"] == 'delete') {
        $selected_course = $pdo->prepare("DELETE FROM course_std WHERE id_course=:id AND id_std= :sid;");
        $selected_course ->bindParam(":sid", $sid);
        $selected_course ->bindParam(":id", $id);
        $selected_course -> execute();


    }}
    // header("Location:index.php");
    // exit;


$selected_course = $pdo->prepare('SELECT * FROM course_std WHERE id_std=:sid');
$selected_course->execute(["sid" => $sid]);}
?>

<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم انتخاب واحد</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body dir="rtl">
    <div class="container">
        <h1>صفحه انتخاب واحد دانشجو</h1>
        <?php 
        $userid = $pdo->query("SELECT * FROM user WHERE id= $sid;")->fetch();
        echo "<div id='userid'> کاربر ", $userid['username'],"</div>";
        ?>
        <form action="#" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="جستجو ..." />
                <button class="btn btn-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <br>
        <br>
        <button id="logout"><a href="./logout.php">خروج</a></button>
        <?php if (isset($x)): ?>
            <div id='errorMessage'>
                <?= $x; ?>
            </div>
        <?php endif ?>
        <table>
            <thead>
                <tr>
                    <th>دروس ارائه شده</th>
                    <th>نام استاد</th>
                    <th>روز و ساعت</th>
                    <th>انتخاب</th>
                </tr>
            </thead>
            <?php if ($course->rowCount() > 0): ?>
            <tbody>
                    <?php foreach ($course as $row): ?>
                        <tr>
                            <td>
                                <span id="name"><?= $row["name"], " (", $row["unit"], " واحد)" ?></span>
                            </td>
                            <td>
                                <span><?= $row["professor_name"] ?></span>
                            </td>
                            <td>
                                <span><?= $row["date"], " : ", $row["time"] ?></span>
                            </td>
                            <td class="button-align">
                                <a href="index.php?action=add&id=<?= $row["id"] ?>" class="select-button btn"
                                    data-units="<?= $row["unit"]; ?>" data-time="<?= $row["time"]; ?>"
                                    data-day="<?= $row["date"]; ?>">انتخاب</a>
                            </td>



                        </tr>

                    <?php endforeach ?>


                </tbody>
            <?php endif ?>
        </table>

        <table id="selectedCourse">
            <thead>
                <tr>
                    <th>دروس اانتخاب شده</th>
                    <th>نام استاد</th>
                    <th>روز و ساعت</th>
                    <th>حذف</th>

                </tr>
            </thead>
            <?php if ($selected_course->rowCount() > 0): ?>
                <tbody>
                    <?php foreach ($selected_course as $x): ?>
                        <?php
                        $Id = $x["id_course"];
                        $row = $pdo->query("SELECT * FROM show_course WHERE id=$Id")->fetch();
                    

                        ?>
                        <tr>
                            <td>
                                <span id="name"><?= $row["name"], " (", $row["unit"], " واحد)" ?></span>
                            </td>
                            <td>
                                <span><?= $row["professor_name"] ?></span>
                            </td>
                            <td>
                                <span><?= $row["date"], " : ", $row["time"] ?></span>
                            </td>
                            <td class="button-align">
                                <a href="index.php?action=delete&id=<?= $row["id"] ?>" class="select-button btn"
                                    data-units="<?= $row["unit"]; ?>" data-time="<?= $row["time"]; ?>"
                                    data-day="<?= $row["date"]; ?>">حذف</a>
                            </td>


                        </tr>

                    <?php endforeach ?>


                </tbody>
            <?php endif ?>
        </table>

    </div>
    <script src="script.js"></script>
</body>

</html>