<?php include __DIR__ . '/header.php'; ?>
<h2>Editar Cliente</h2>
  <link rel="stylesheet" href="/css/style.css">

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

<form method="POST" action="/clients/update/<?= $old['id'] ?>">
  <label>Nome*</label>
  <input type="text" name="name" value="<?= htmlspecialchars(string: $old['name'] ?? '') ?>" required>

  <label>Email*</label>
  <input type="email" name="email" value="<?= htmlspecialchars(string: $old['email'] ?? '') ?>" required>

  <label>CPF*</label>
  <input type="text" name="cpf" value="<?= htmlspecialchars(string: $old['cpf'] ?? '') ?>" required>

  <label>Telefone</label>
  <input type="text" name="phone" value="<?= htmlspecialchars(string: $old['phone'] ?? '') ?>">

  <button type="submit">Atualizar</button>
  <a href="/clients">Cancelar</a>
</form>
