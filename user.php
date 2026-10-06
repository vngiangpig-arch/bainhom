<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $action =$_POST['action'] ?? '';
    
    $id =$_POST['id'] ?? '';

    if ($action === 'add') {
        $username =$_POST['username'];
        $email =$_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role =$_POST['role'];
        $price =$_POST['price'];
        $status =$_POST['status'];
        $plan_id = !empty($_POST['plan_id']) ?$_POST['plan_id'] : null;

        $sql = "INSERT INTO user (username, email, password, role, price, status, plan_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email,$password, $role,$price, $status,$plan_id]);

        header('Location: user.php'); 
        exit();
    }
    
    elseif ($action === 'edit') {
        $username = $_POST['username'];$email = $_POST['email'];$role = $_POST['role'];$price = $_POST['price'];$status = $_POST['status'];$plan_id = !empty($_POST['plan_id']) ?$_POST['plan_id'] : null;

        $sql = "UPDATE user SET username = ?, email = ?, role = ?, price = ?, status = ?, plan_id = ? WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email,$role, $price,$status, $plan_id,$id]);

        header('Location: user.php'); 
        exit();
    } 
    
    elseif ($action === 'delete') {
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header('Location: user.php'); 
        exit();
    }
    
    elseif ($action === 'ban') {
        $current_status =$_POST['current_status'];
        
        $new_status = ($current_status === 'Active') ? 'Banned' : 'Active';
        
        $sql = "UPDATE user SET status = ? WHERE id = ?";
        $stmt =$pdo->prepare($sql);$stmt->execute([$new_status,$id]);

        header('Location: user.php'); 
        exit();
    }
    
    elseif ($action === 'reset_device') {
        $sql = "UPDATE user SET device = NULL WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header('Location: user.php'); 
        exit();
    }
}

$sql_users = "SELECT u.*, p.name as plan_name FROM user u LEFT JOIN plan p ON u.plan_id = p.id ORDER BY u.id DESC";
$users = $pdo->query($sql_users)->fetchAll(PDO::FETCH_ASSOC);

$sql_plans = "SELECT id, name FROM plan";
$plans = $pdo->query($sql_plans)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-ban { background-color: #fd7e14; color: #fff; }
        .btn-unban { background-color: #20c997; color: #fff; }
        .btn-reset { background-color: #6f42c1; color: #fff; }
        .action-btns { display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-start; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Danh sách Thành viên</h2>
            <button class="btn btn-save" onclick="openAddModal()">+ Thêm User</button>
        </div>
        <table>
            <thead>
                <tr><th>#</th><th>Tên hiển thị</th><th>Email</th><th>Gói VIP</th><th>Thiết bị</th><th>Số dư</th><th>Trạng thái</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($row['username']) ?><br><small><?= $row['role'] ?></small></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['plan_name'] ?: 'Không có') ?></td>
                    <td><?= !empty($row['device']) ? '1 Máy' : 'Chưa có' ?></td>
                    <td style="color: #198754; font-weight: bold;"><?= number_format($row['price']) ?> đ</td>
                    <td><span class="badge <?= $row['status'] == 'Active' ? '' : 'badge-danger' ?>"><?= $row['status'] ?></span></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn btn-edit" onclick="openEditModal(this)" 
                                data-id="<?= $row['id'] ?>" data-user="<?= $row['username'] ?>" 
                                data-email="<?= $row['email'] ?>" data-role="<?= $row['role'] ?>" 
                                data-price="<?= $row['price'] ?>" data-status="<?= $row['status'] ?>"
                                data-plan="<?= $row['plan_id'] ?>">Sửa</button>

                            <button class="btn <?= $row['status'] == 'Active' ? 'btn-ban' : 'btn-unban' ?>" 
                                onclick="openBanModal(<?= $row['id'] ?>, '<?= $row['status'] ?>')">
                                <?= $row['status'] == 'Active' ? 'Khóa' : 'Mở Khóa' ?>
                            </button>

                            <button class="btn btn-reset" onclick="openResetModal(<?= $row['id'] ?>)">Reset Máy</button>

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
            <div class="modal-header"><h3>Thêm User</h3><span class="close" onclick="closeModal('modalAdd')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group"><label>Tên hiển thị</label><input type="text" name="username" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Mật khẩu</label><input type="password" name="password" required></div>
                <div class="form-group"><label>Số dư (đ)</label><input type="number" name="price" value="0" required></div>
                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1"><label>Gói VIP</label>
                        <select name="plan_id"><option value="">Không</option><?php foreach($plans as $p): ?><option value="<?= $p['id'] ?>"><?= $p['name'] ?></option><?php endforeach; ?></select>
                    </div>
                    <div class="form-group" style="flex:1"><label>Vai trò</label><select name="role"><option value="user">User</option><option value="admin">Admin</option></select></div>
                    <div class="form-group" style="flex:1"><label>Trạng thái</label><select name="status"><option value="Active">Hoạt động</option><option value="Banned">Khóa</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalAdd')">Hủy</button><button type="submit" class="btn btn-save">Thêm mới</button></div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Sửa User</h3><span class="close" onclick="closeModal('modalEdit')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group"><label>Tên hiển thị</label><input type="text" name="username" id="edit_user" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" id="edit_email" required></div>
                <div class="form-group"><label>Số dư (đ)</label><input type="number" name="price" id="edit_price" required></div>
                <div style="display:flex; gap:10px;">
                    <div class="form-group" style="flex:1"><label>Gói VIP</label>
                        <select name="plan_id" id="edit_plan"><option value="">Không</option><?php foreach($plans as $p): ?><option value="<?= $p['id'] ?>"><?= $p['name'] ?></option><?php endforeach; ?></select>
                    </div>
                    <div class="form-group" style="flex:1"><label>Vai trò</label><select name="role" id="edit_role"><option value="user">User</option><option value="admin">Admin</option></select></div>
                    <div class="form-group" style="flex:1"><label>Trạng thái</label><select name="status" id="edit_status"><option value="Active">Hoạt động</option><option value="Banned">Khóa</option></select></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalEdit')">Hủy</button><button type="submit" class="btn btn-save">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>

    <div id="modalBan" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận Trạng Thái</h3><span class="close" onclick="closeModal('modalBan')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="ban">
                <input type="hidden" name="id" id="ban_id">
                <input type="hidden" name="current_status" id="ban_status">
                <p id="ban_text" style="font-size: 15px; margin-bottom: 20px;">Bạn có chắc chắn muốn thay đổi trạng thái tài khoản này?</p>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalBan')">Hủy</button><button type="submit" class="btn btn-ban" id="btn_submit_ban">Xác nhận</button></div>
            </form>
        </div>
    </div>

    <div id="modalReset" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận Reset Thiết Bị</h3><span class="close" onclick="closeModal('modalReset')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="reset_device">
                <input type="hidden" name="id" id="reset_id">
                <p style="font-size: 15px; margin-bottom: 20px;">Bạn có chắc chắn muốn <strong>xóa toàn bộ thiết bị đã đăng nhập</strong> của tài khoản này không? (Hành động này giúp User đăng nhập được trên máy mới).</p>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalReset')">Hủy</button><button type="submit" class="btn btn-reset">Tiến hành Reset</button></div>
            </form>
        </div>
    </div>

    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận xóa</h3><span class="close" onclick="closeModal('modalDelete')">&times;</span></div>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                <p style="font-size: 15px; color: #dc3545; margin-bottom: 20px;">Bạn có chắc muốn xóa User này vĩnh viễn? Dữ liệu không thể khôi phục.</p>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalDelete')">Hủy</button><button type="submit" class="btn btn-delete">Xác nhận Xóa</button></div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('modalAdd').style.display = 'block'; }
        
        function openEditModal(btn) {
            document.getElementById('edit_id').value = btn.dataset.id;
            document.getElementById('edit_user').value = btn.dataset.user;
            document.getElementById('edit_email').value = btn.dataset.email;
            document.getElementById('edit_price').value = btn.dataset.price;
            document.getElementById('edit_role').value = btn.dataset.role;
            document.getElementById('edit_status').value = btn.dataset.status;
            document.getElementById('edit_plan').value = btn.dataset.plan;
            document.getElementById('modalEdit').style.display = 'block';
        }
        
        function openBanModal(id, status) { 
            document.getElementById('ban_id').value = id; 
            document.getElementById('ban_status').value = status; 
            let textEl = document.getElementById('ban_text');
            let btnEl = document.getElementById('btn_submit_ban');
            if(status === 'Active') {
                textEl.innerHTML = "Bạn có chắc chắn muốn <strong>KHÓA</strong> tài khoản này không?";
                btnEl.innerText = "Khóa tài khoản";
                btnEl.className = "btn btn-ban";
            } else {
                textEl.innerHTML = "Bạn có muốn <strong>MỞ KHÓA</strong> tài khoản này không?";
                btnEl.innerText = "Mở khóa";
                btnEl.className = "btn btn-unban";
            }
            document.getElementById('modalBan').style.display = 'block'; 
        }

        function openResetModal(id) { 
            document.getElementById('reset_id').value = id; 
            document.getElementById('modalReset').style.display = 'block'; 
        }

        function openDeleteModal(id) { 
            document.getElementById('delete_id').value = id; 
            document.getElementById('modalDelete').style.display = 'block'; 
        }
        
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    </script>
</body>
</html>