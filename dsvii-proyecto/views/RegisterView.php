<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../controllers/UserController.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = (new Database())->getConnection();
    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    $data = [
        'full_name' => $_POST['full_name'] ?? '',
        'username' => $_POST['username'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'id_type' => $_POST['id_type'] ?? '',
        'province' => $_POST['province'] ?? '',
        'id_part1' => $_POST['id_part1'] ?? '',
        'id_part2' => $_POST['id_part2'] ?? '',
        'id_part3' => $_POST['id_part3'] ?? '',
    ];

    ob_start();
    $userController->register($data);
    $response = ob_get_clean();
    $result = json_decode($response, true);
    $message = $result['message'] ?? 'There was a problem during registration.';
}

require_once __DIR__ . '/Partials/Top.php';
?>

<main class="main-container">
  <div class="card">
    <form method="POST" action="">
      <h3 class="text-center">Registration Form</h3>

      <?php if ($message): ?>
        <div class="alert-info"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <label for="full_name">Full Name</label>
      <input type="text" id="full_name" name="full_name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="id_type">ID Type</label>
<div class="radio-group">
  <?php
    $idTypes = [
      'E'  => 'Foreigner',
      'N'  => 'National',
      'NA' => 'Naturalized',
      'PE' => 'P.E.',
      'PI' => 'P.I.'
    ];
  ?>
  <?php foreach ($idTypes as $code => $label): ?>
    <label>
      <input type="radio" name="id_type" value="<?= $code ?>" <?= $code === 'N' ? 'required' : '' ?>>
      <?= $label ?>
    </label>
  <?php endforeach; ?>
</div>


      <label for="province">Province</label>
      <select id="province" name="province" required>
        <option value="">Select a province</option>
        <?php foreach ([
          "Bocas del Toro", "Coclé", "Colón", "Chiriquí", "Darién",
          "Herrera", "Los Santos", "Panamá", "Panamá Oeste", "Veraguas"
        ] as $province): ?>
          <option value="<?= $province ?>"><?= $province ?></option>
        <?php endforeach; ?>
      </select>

      <label>ID Number</label>
      <div style="display: flex; gap: 10px;">
        <input type="text" name="id_part1" maxlength="2" pattern="\d{2}" required style="max-width: 50px;">
        <span>-</span>
        <input type="text" name="id_part2" maxlength="5" pattern="\d{5}" required style="max-width: 90px;">
        <span>-</span>
        <input type="text" name="id_part3" maxlength="5" pattern="\d{5}" required style="max-width: 90px;">
      </div>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" minlength="6" required>

      <button type="submit">Register</button>
    </form>
  </div>
</main>

<script src="/../dsvii-talleres-edu/dsvii-proyecto/public/js/register.js"></script>

<?php
include __DIR__ . '/Partials/Bottom.php';
?>
