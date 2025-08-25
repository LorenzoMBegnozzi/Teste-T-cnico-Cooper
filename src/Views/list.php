<?php include __DIR__ . '/header.php'; ?>
<h2>Clientes</h2>

<?php if (empty($clients)): ?>
  <p>Nenhum cliente cadastrado.</p>
<?php else: ?>
<table border="1">
  <tr>
    <th>ID</th><th>Nome</th><th>Email</th><th>CPF</th><th>Telefone</th><th>Ações</th>
  </tr>
  <?php foreach ($clients as $c): ?>
    <tr>
      <td><?= htmlspecialchars(string: $c['id']) ?></td>
      <td><?= htmlspecialchars(string: $c['name']) ?></td>
      <td><?= htmlspecialchars(string: $c['email']) ?></td>
      <td><?= htmlspecialchars(string: $c['cpf']) ?></td>
      <td><?= htmlspecialchars(string: $c['phone']) ?></td>
      <td>
        <a href="/clients/edit/<?= $c['id'] ?>">Editar</a>
        <a href="/clients/delete/<?= $c['id'] ?>" onclick="return confirm('Excluir cliente?')">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
