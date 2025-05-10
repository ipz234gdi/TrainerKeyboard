<h1>Управління користувачами</h1>
<table>
  <tr>
    <th>ID</th><th>Username</th><th>Роль</th><th>Blocked</th><th>Створено</th><th>Дії</th>
  </tr>
  <?php foreach($users as $u): ?>
  <tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['username']) ?></td>
    <td>
      <form method="post" action="/admin/users/update-role">
        <input type="hidden" name="id" value="<?= $u['id'] ?>">
        <select name="role" onchange="this.form.submit()">
          <?php foreach(['student','teacher','administrator'] as $r): ?>
            <option value="<?= $r ?>"
              <?= $u['role']=== $r ? 'selected' : '' ?>>
              <?= ucfirst($r) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    </td>
    <td>
      <?= $u['blocked'] ? 'Yes' : 'No' ?>
    </td>
    <td><?= $u['created_at'] ?? '-' ?></td>
    <td>
      <form method="post" action="/admin/users/toggle-block" style="display:inline">
        <input type="hidden" name="id"      value="<?= $u['id'] ?>">
        <input type="hidden" name="blocked" value="<?= $u['blocked'] ?>">
        <button type="submit">
          <?= $u['blocked'] ? 'Unblock' : 'Block' ?>
        </button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
