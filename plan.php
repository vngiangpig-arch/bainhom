<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $sql = "INSERT INTO plan (name, price, device, time, description) VALUES (:name, :price, :device, :time, :description)";
        $pdo->prepare($sql)->execute([
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'device' => $_POST['device'] ?? 1,
            'time' => $_POST['time'] ?? 0,
            'description' => $_POST['description'] ?? ''
        ]);
        header('Location: plan.php'); exit();
    }
    elseif ($action === 'edit') {
        $sql = "UPDATE plan SET name = :name, price = :price, device = :device, time = :time, description = :description WHERE id = :id";
        $pdo->prepare($sql)->execute([
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? 0,
            'device' => $_POST['device'] ?? 1,
            'time' => $_POST['time'] ?? 0,
            'description' => $_POST['description'] ?? '',
            'id' => $_POST['id'] ?? ''
        ]);
        header('Location: plan.php'); exit();
    } 
    elseif ($action === 'delete') {
        $pdo->prepare("DELETE FROM plan WHERE id = :id")->execute(['id' => $_POST['id'] ?? '']);
        header('Location: plan.php'); exit();
    }
}

$plans = $pdo->query("SELECT * FROM plan ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Gói VIP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Danh sách Gói</h2>
            <button class="btn btn-save" onclick="openAddModal()">+ Thêm Gói</button>
        </div>
        <table>
            <thead>
                <tr><th>#</th><th>Tên gói</th><th>Giá tiền</th><th>Thiết bị</th><th>Thời hạn</th><th>Mô tả</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                <?php foreach ($plans as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                    <td style="color: #dc3545; font-weight: bold;"><?= number_format($row['price']) ?> đ</td>
                    <td><?= htmlspecialchars($row['device']) ?> máy</td>
                    <td><?= htmlspecialchars($row['time']) ?> ngày</td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn btn-edit" onclick="openEditModal(this)" 
                                data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" 
                                data-price="<?= $row['price'] ?>" data-device="<?= $row['device'] ?>" 
                                data-time="<?= $row['time'] ?>" data-desc="<?= htmlspecialchars($row['description']) ?>">Sửa</button>
                            <button class="btn btn-delete" onclick="openDeleteModal(<?= $row['id'] ?>)">Xóa</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="modalAdd" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm Gói VIP</h3>
                <span class="close" onclick="closeModal('modalAdd')">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group"><label>Tên gói</label><input type="text" name="name" required></div>
                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1"><label>Giá tiền</label><input type="number" name="price" required></div>
                    <div class="form-group" style="flex:1"><label>Thiết bị</label><input type="number" name="device" required></div>
                    <div class="form-group" style="flex:1"><label>Thời gian (Ngày)</label><input type="number" name="time" required></div>
                </div>
                <div class="form-group"><label>Mô tả quyền lợi</label><textarea name="description" rows="3" required></textarea></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('modalAdd')">Hủy</button>
                    <button type="submit" class="btn btn-save">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Sửa Gói VIP</h3>
                <span class="close" onclick="closeModal('modalEdit')">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group"><label>Tên gói</label><input type="text" name="name" id="edit_name" required></div>
                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1"><label>Giá tiền</label><input type="number" name="price" id="edit_price" required></div>
                    <div class="form-group" style="flex:1"><label>Thiết bị</label><input type="number" name="device" id="edit_device" required></div>
                    <div class="form-group" style="flex:1"><label>Thời gian (Ngày)</label><input type="number" name="time" id="edit_time" required></div>
                </div>
                <div class="form-group"><label>Mô tả quyền lợi</label><textarea name="description" id="edit_desc" rows="3" required></textarea></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('modalEdit')">Hủy</button>
                    <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận xóa</h3><span class="close" onclick="closeModal('modalDelete')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                <p>Bạn có chắc muốn xóa gói này?</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" onclick="closeModal('modalDelete')">Hủy</button>
                    <button type="submit" class="btn btn-delete">Xác nhận Xóa</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('modalAdd').style.display = 'block'; }
        function openEditModal(btn) {
            document.getElementById('edit_id').value = btn.dataset.id;
            document.getElementById('edit_name').value = btn.dataset.name;
            document.getElementById('edit_price').value = btn.dataset.price;
            document.getElementById('edit_device').value = btn.dataset.device;
            document.getElementById('edit_time').value = btn.dataset.time;
            document.getElementById('edit_desc').value = btn.dataset.desc;
            document.getElementById('modalEdit').style.display = 'block';
        }
        function openDeleteModal(id) { document.getElementById('delete_id').value = id; document.getElementById('modalDelete').style.display = 'block'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    </script>
</body>
</html>