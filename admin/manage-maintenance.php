<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');

if (empty($_SESSION['zmsaid'])) {
    header('Location: logout.php');
    exit;
}

// Hàm helper để mã hóa output HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Xử lý thêm mới kế hoạch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_plan'])) {
    $planID = filter_input(INPUT_POST, 'planID', FILTER_SANITIZE_STRING);
    $item = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $scheduledDate = filter_input(INPUT_POST, 'scheduledDate', FILTER_SANITIZE_STRING);
    $personInCharge = filter_input(INPUT_POST, 'personInCharge', FILTER_SANITIZE_STRING);

    // Kiểm tra tồn tại planID
    $stmt = $con->prepare("SELECT 1 FROM tbl_maintenance_plan WHERE PlanID = ?");
    $stmt->bind_param('s', $planID);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<script>alert('PlanID đã tồn tại. Vui lòng chọn một PlanID khác.');</script>";
    } else {
        $stmtInsert = $con->prepare("INSERT INTO tbl_maintenance_plan (PlanID, Item, Description, ScheduledDate, PersonInCharge) VALUES (?, ?, ?, ?, ?)");
        $stmtInsert->bind_param('sssss', $planID, $item, $description, $scheduledDate, $personInCharge);
        if ($stmtInsert->execute()) {
            echo "<script>alert('Kế hoạch bảo trì được tạo thành công');</script>";
        } else {
            echo "<script>alert('Lỗi khi tạo kế hoạch');</script>";
        }
        $stmtInsert->close();
    }
    $stmt->close();
}

// Xử lý cập nhật kế hoạch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_plan'])) {
    $planId = filter_input(INPUT_POST, 'planId', FILTER_SANITIZE_STRING);
    $progress = filter_input(INPUT_POST, 'progress', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $result = filter_input(INPUT_POST, 'result', FILTER_SANITIZE_STRING);

    $stmtUpdate = $con->prepare("UPDATE tbl_maintenance_plan SET Progress = ?, Status = ?, Result = ? WHERE PlanID = ?");
    $stmtUpdate->bind_param('ssss', $progress, $status, $result, $planId);
    if ($stmtUpdate->execute()) {
        echo "<script>alert('Cập nhật kế hoạch thành công');</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật kế hoạch');</script>";
    }
    $stmtUpdate->close();
}

// Xử lý xóa kế hoạch
if (isset($_GET['del']) && $_GET['del'] === 'delete') {
    $planId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $stmtDel = $con->prepare("DELETE FROM tbl_maintenance_plan WHERE PlanID = ?");
    $stmtDel->bind_param('s', $planId);
    $stmtDel->execute();
    $stmtDel->close();

    echo "<script>alert('Kế hoạch đã được xóa');</script>";
    echo "<script>window.location.href='manage-maintenance.php';</script>";
    exit;
}

?>

<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Quản lý kế hoạch bảo trì</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div class="page-container">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-content">
            <?php include_once('includes/header.php'); ?>
            <?php include_once('includes/pagetitle.php'); ?>

            <div class="main-content-inner">
                <div class="row">

                    <!-- Form thêm mới kế hoạch -->
                    <div class="col-12 mt-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Tạo kế hoạch bảo trì mới</h4>
                                <form method="post" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="planID">PlanID</label>
                                            <input type="text" id="planID" name="planID" class="form-control" maxlength="5" required pattern="[A-Za-z0-9]{1,5}" title="PlanID phải là chuỗi tối đa 5 ký tự (chữ hoặc số)">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="item">Hạng mục</label>
                                            <input type="text" id="item" name="item" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="description">Mô tả công việc</label>
                                            <input type="text" id="description" name="description" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="scheduledDate">Thời gian thực hiện</label>
                                            <input type="date" id="scheduledDate" name="scheduledDate" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="personInCharge">Người phụ trách</label>
                                            <input type="text" id="personInCharge" name="personInCharge" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_plan" class="btn btn-primary">Tạo kế hoạch</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng danh sách kế hoạch -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Danh sách kế hoạch bảo trì</h4>
                                <div class="data-tables">
                                    <table id="maintenanceTable" class="table table-striped table-bordered text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>PlanID</th>
                                                <th>Hạng mục</th>
                                                <th>Mô tả công việc</th>
                                                <th>Thời gian thực hiện</th>
                                                <th>Người phụ trách</th>
                                                <th>Tiến độ</th>
                                                <th>Trạng thái</th>
                                                <th>Kết quả</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $con->query("SELECT * FROM tbl_maintenance_plan ORDER BY PlanID DESC");
                                            if ($result) {
                                                $progressOptions = ['Chưa bắt đầu', 'Đang tiến hành', 'Hoàn thành'];
                                                $statusOptions = ['Đang lên kế hoạch', 'Đang thực hiện', 'Hoàn thành', 'Trễ hạn'];
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= e($row['PlanID']) ?></td>
                                                        <td><?= e($row['Item']) ?></td>
                                                        <td><?= e($row['Description']) ?></td>
                                                        <td><?= e($row['ScheduledDate']) ?></td>
                                                        <td><?= e($row['PersonInCharge']) ?></td>
                                                        <td>
                                                            <form method="post" style="display:inline-block;">
                                                                <input type="hidden" name="planId" value="<?= e($row['PlanID']) ?>">
                                                                <select name="progress" class="form-control form-control-sm" required>
                                                                    <?php
                                                                    foreach ($progressOptions as $p) {
                                                                        $selected = ($p === $row['Progress']) ? 'selected' : '';
                                                                        echo "<option value=\"" . e($p) . "\" $selected>" . e($p) . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                        </td>
                                                        <td>
                                                                <select name="status" class="form-control form-control-sm" required>
                                                                    <?php
                                                                    foreach ($statusOptions as $s) {
                                                                        $selected = ($s === $row['Status']) ? 'selected' : '';
                                                                        echo "<option value=\"" . e($s) . "\" $selected>" . e($s) . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                        </td>
                                                        <td>
                                                                <input type="text" name="result" class="form-control form-control-sm" value="<?= e($row['Result']) ?>">
                                                        </td>
                                                        <td>
                                                                <button type="submit" name="update_plan" class="btn btn-success btn-sm mb-1">Cập nhật</button>
                                                            </form>
                                                            <a href="manage-maintenance.php?id=<?= urlencode($row['PlanID']) ?>&del=delete" onclick="return confirm('Bạn chắc chắn muốn xóa kế hoạch này?')" class="btn btn-danger btn-sm">Xóa</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>

    </div>

    <!-- JS -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#maintenanceTable').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>
