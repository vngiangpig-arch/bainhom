<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Quản lý Ngân hàng</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Danh sách Ngân hàng</h2>
            <button class="btn btn-save" onclick="openAddModal()">+ Thêm Ngân Hàng</button>
        </div>
        <table>
            <thead><tr><th>#</th><th>Tên Ngân Hàng</th><th>Chủ Tài Khoản</th><th>Số Tài Khoản</th><th>Thao tác</th></tr></thead>
            <tbody>
                <?php foreach ($banks as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><strong><?= htmlspecialchars($row['tenbank']) ?></strong></td>
                    <td><?= htmlspecialchars($row['chutaikhoan']) ?></td>
                    <td><?= htmlspecialchars($row['sotaikhoan']) ?></td>
                    <td>
                        <div class="action-btns">
                            <button class="btn btn-edit" onclick="openEditModal(this)" data-id="<?= $row['id'] ?>" data-ten="<?= $row['tenbank'] ?>" data-chu="<?= $row['chutaikhoan'] ?>" data-so="<?= $row['sotaikhoan'] ?>">Sửa</button>
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
            <div class="modal-header"><h3>Thêm Ngân Hàng</h3><span class="close" onclick="closeModal('modalAdd')">&times;</span></div>
            <form method="POST" action="index.php?page=bank">
                <input type="hidden" name="action" value="add">
                <div class="form-group"><label>Tên Ngân Hàng</label><input type="text" name="tenbank" required></div>
                <div class="form-group"><label>Chủ Tài Khoản</label><input type="text" name="chutaikhoan" required></div>
                <div class="form-group"><label>Số Tài Khoản</label><input type="text" name="sotaikhoan" required></div>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalAdd')">Hủy</button><button type="submit" class="btn btn-save">Thêm mới</button></div>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Sửa Ngân Hàng</h3><span class="close" onclick="closeModal('modalEdit')">&times;</span></div>
            <form method="POST" action="index.php?page=bank">
                <input type="hidden" name="action" value="edit"><input type="hidden" name="id" id="edit_id">
                <div class="form-group"><label>Tên Ngân Hàng</label><input type="text" name="tenbank" id="edit_tenbank" required></div>
                <div class="form-group"><label>Chủ Tài Khoản</label><input type="text" name="chutaikhoan" id="edit_chutaikhoan" required></div>
                <div class="form-group"><label>Số Tài Khoản</label><input type="text" name="sotaikhoan" id="edit_sotaikhoan" required></div>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalEdit')">Hủy</button><button type="submit" class="btn btn-save">Lưu thay đổi</button></div>
            </form>
        </div>
    </div>

    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <div class="modal-header"><h3>Xác nhận xóa</h3><span class="close" onclick="closeModal('modalDelete')">&times;</span></div>
            <form method="POST" action="index.php?page=bank">
                <input type="hidden" name="action" value="delete"><input type="hidden" name="id" id="delete_id">
                <p>Bạn có chắc muốn xóa ngân hàng này?</p>
                <div class="modal-footer"><button type="button" class="btn btn-cancel" onclick="closeModal('modalDelete')">Hủy</button><button type="submit" class="btn btn-delete">Xác nhận Xóa</button></div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() { document.getElementById('modalAdd').style.display = 'block'; }
        function openEditModal(btn) {
            document.getElementById('edit_id').value = btn.dataset.id;
            document.getElementById('edit_tenbank').value = btn.dataset.ten;
            document.getElementById('edit_chutaikhoan').value = btn.dataset.chu;
            document.getElementById('edit_sotaikhoan').value = btn.dataset.so;
            document.getElementById('modalEdit').style.display = 'block';
        }
        function openDeleteModal(id) { document.getElementById('delete_id').value = id; document.getElementById('modalDelete').style.display = 'block'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    </script>
</body>
</html>