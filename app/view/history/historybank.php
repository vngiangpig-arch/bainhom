<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Lịch sử Nạp tiền</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Lịch Sử Nạp Tiền</h2>
        <p style="color: #6c757d; font-size: 14px; margin-bottom: 20px;">* Dữ liệu nhật ký hệ thống không thể thêm hoặc sửa đổi.</p>
        <table>
            <thead><tr><th>Mã GD</th><th>Người dùng</th><th>Số tiền nạp</th><th>Nội dung CK</th><th>Thời gian</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
            <tbody>
                <?php foreach ($historybanks as $row): ?>
                <tr>
                    <td>#HB<?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username'] ?? 'User #'.$row['user_id']) ?></td>
                    <td style="color: #198754; font-weight: bold;">+ <?= number_format($row['price']) ?> đ</td>
                    <td><?= htmlspecialchars($row['transaction']) ?></td>
                    <td><?= htmlspecialchars($row['time']) ?></td>
                    <td><span class="badge <?= $row['status'] == 'Success' ? '' : ($row['status'] == 'Pending' ? 'badge-warning' : 'badge-danger') ?>"><?= $row['status'] ?></span></td>
                    <td><div class="action-btns"><button class="btn btn-delete" onclick="openDeleteModal(<?= $row['id'] ?>)">Xóa</button></div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận xóa giao dịch</h3><span class="close" onclick="closeModal('modalDelete')">&times;</span></div>
            <form method="POST" action="index.php?page=historybank">
                <input type="hidden" name="action" value="delete"><input type="hidden" name="id" id="delete_id">
                <p style="font-size: 15px; color: #dc3545; margin-bottom: 20px;">Bạn có chắc muốn xóa lịch sử giao dịch nạp tiền này? Dữ liệu không thể khôi phục.</p>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalDelete')">Hủy</button><button type="submit" class="btn btn-delete">Xác nhận Xóa</button></div>
            </form>
        </div>
    </div>
    <script>
        function openDeleteModal(id) { document.getElementById('delete_id').value = id; document.getElementById('modalDelete').style.display = 'block'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    </script>
</body>
</html>