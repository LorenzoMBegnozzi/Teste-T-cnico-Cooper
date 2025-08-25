<?php include __DIR__ . '/header.php'; ?>
<h2>Novo Cliente</h2>

<?php if (!empty($errors)): ?>
  <div>
    <strong>Corrija os campos:</strong>
    <ul>
      <?php foreach ($errors as $field => $msgs): foreach ($msgs as $msg): ?>
        <li><?= htmlspecialchars(string: $msg) ?></li>
      <?php endforeach; endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="POST" action="/clients/store">
  <label>Nome*</label>
  <input type="text" name="name" value="<?= htmlspecialchars(string: $old['name'] ?? '') ?>" required>

  <label>Email*</label>
  <input type="email" name="email" value="<?= htmlspecialchars(string: $old['email'] ?? '') ?>" required>

  <label>CPF* (somente números)</label>
  <input type="text" name="cpf" value="<?= htmlspecialchars(string: $old['cpf'] ?? '') ?>" maxlength="14" required>

  <label>Telefone</label>
  <input type="text" name="phone" value="<?= htmlspecialchars(string: $old['phone'] ?? '') ?>">

  <button type="submit">Salvar</button>
  <a href="/clients">Cancela</a>
</form>
