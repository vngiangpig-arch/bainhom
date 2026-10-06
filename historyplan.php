<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $pdo->prepare("DELETE FROM historyplan WHERE id = :id")->execute(['id' => $_POST['id'] ?? '']);
        header('Location: historyplan.php'); exit();
    }
}

$sql = "SELECT hp.*, u.email, p.name AS plan_name 
        FROM historyplan hp 
        LEFT JOIN user u ON hp.user_id = u.id 
        LEFT JOIN plan p ON hp.plan_id = p.id 
        ORDER BY hp.id DESC";
$historyplans = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử Thuê Gói</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Lịch Sử Đăng Ký Gói</h2>
        <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">* Dữ liệu nhật ký hệ thống không thể thêm hoặc sửa đổi.</p>
        
        <table>
            <thead>
                <tr><th>Mã Đơn</th><th>Tài khoản</th><th>Gói (Plan)</th><th>Ngày bắt đầu</th><th>Ngày kết thúc</th><th>Tình trạng</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                <?php foreach ($historyplans as $row): ?>
                <tr>
                    <td>#HP<?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['email'] ?? 'User #'.$row['user_id']) ?></td>
                    <td><strong><?= htmlspecialchars($row['plan_name'] ?? 'Gói đã bị xóa') ?></strong></td>
                    <td><?= htmlspecialchars($row['start']) ?></td>
                    <td><?= htmlspecialchars($row['end']) ?></td>
                    <td>
                        <span class="badge <?= $row['status'] == 'Active' ? '' : 'badge-danger' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <button class="btn btn-delete" onclick="openDeleteModal(<?= $row['id'] ?>)">Xóa</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Xác nhận xóa</h3>
                <span class="close" onclick="closeModal('modalDelete')">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                <p style="font-size: 15px; color: #dc3545; margin-bottom: 20px;">Bạn có chắc chắn muốn xóa lịch sử thuê gói này?</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('modalDelete')">Hủy</button>
                    <button type="submit" class="btn btn-delete">Xác nhận Xóa</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id) { 
            document.getElementById('delete_id').value = id; 
            document.getElementById('modalDelete').style.display = 'block'; 
        }
        function closeModal(id) { 
            document.getElementById(id).style.display = 'none'; 
        }
    </script>
</body>
</html>