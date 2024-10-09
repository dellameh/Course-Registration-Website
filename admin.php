<?php
require_once 'includes/dbh.inc.php';

if(isset($_GET["action"]) && ($_GET["id"])){
  $id=$_GET["id"];
  $del=$pdo->prepare("DELETE FROM show_course WHERE id= :id ");
  $del->execute(["id"=>$id]);
  header("Location:admin.php");
    exit;
}
$course=$pdo->query('SELECT * FROM show_course');
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>admin||side</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./assert/styles.css" />
  </head>

  <body>
    <header class="navbar sticky-top bg-secondary flex-md-nowrap p-0 shadow-sm " style="background-color: rgba(3, 8, 83, 0.76)">
      <a
        class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-5 text-white"
        href="admin.php"
        >پنل ادمین</a
      >

      <button
        class="ms-2 nav-link px-3 text-white d-md-none"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#sidebarMenu"
      >
        <i class="bi bi-justify-left fs-2"></i>
      </button>
    </header>
    <div class="container-fluid">
      <div class="row" >
        <!-- Sidebar Section -->
        <div
          class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary" 
        >
          <div
            class="offcanvas-md offcanvas-end bg-body-tertiary"
            tabindex="-1"
            id="sidebarMenu"
          >
            <div class="offcanvas-header">
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
              ></button>
            </div>

            <div
              class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto"
            >
              <ul class="nav flex-column pe-3">
                <li class="nav-item">
                  <a
                    class="nav-link link-body-emphasis text-decoration-none d-flex align-items-center gap-2 text-secondary"
                    href="index.php"
                  >
                    <i class="bi bi-house-fill fs-4 text-secondary"></i>
                    <span class="fw-bold">صفحه کاربر</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a
                    class="nav-link link-body-emphasis text-decoration-none d-flex align-items-center gap-2 text-secondary"
                    href="#"
                  >
                  <i class="bi bi-book fs-4 text-secondary"></i>
                    
                    <span class="fw-bold">دروس</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link link-body-emphasis text-decoration-none d-flex align-items-center gap-2"
                    href="./logout.php"
                  >
                    <i class="bi bi-box-arrow-right fs-4 text-secondary"></i>

                    <span class="fw-bold">خروج</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
        
            <h1 class="fs-3 fw-bold">دروس ارائه شده</h1>
   
            <div class="btn-toolbar mb-2 mb-md-0">
              <a href="./create.php" class="btn btn-sm btn-dark">
                تعریف درس جدید
              </a>
            </div>
          </div>
<!-- table -->
          <div class="mt-4">
            <div class="table-responsive small">
              <?php if($course->rowCount()> 0):?>
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>نام درس</th>
                    <th>واحد</th>
                    <th>نام استاد</th>
                    <th>تاریخ</th>
                    <th>ساعت</th>
                    <th>عملیات</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($course as $row):?>
                  <tr>
                    <th><?= $row["id"]?></th>
                                        <td><?= $row["name"]?></td>
                                        <td><?= $row["unit"]?></td>
                                        <td><?= $row["professor_name"]?></td>
                                        <td><?= $row["date"]?></td>
                                        <td><?= $row["time"]?></td>
                        <!-- <th>1</th>
                                        <td>طراحی کامپایلر</td>
                                        <td>فاطمه ابراهیمی</td>
                                        <td>سه شنبه_یکشنبه</td>
                                        <td>8:00_10:00</td> -->
                    <td>
                      <a href="./edit.php?id=<?= $row["id"]?>" class="btn btn-sm btn-outline-dark">ویرایش</a>
                      <a href="./admin.php?action=delete&id=<?= $row["id"]?>" class="btn btn-sm btn-outline-danger">حذف</a>
                    </td>
                  </tr>

                  <?php endforeach?>
                </tbody>
              </table>
              <?php else:?>
              <div class="col">
                            <div class='alert alert-danger'>
                                "درسی تعریف نشده است...."
                            </div>
                        </div>
              <?php endif?>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
