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
        'nombre' => $_POST['full_name'] ?? '',
        'username' => $_POST['username'] ?? '',
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'],
        'category_code' => $_POST['id_type'] ?? null,
        'province_code' => getProvinceCode($_POST['province'] ?? null),
        'letter_prefix' => $_POST['id_part1'] ?? null,
        'tomo' => $_POST['id_part2'] ?? null,
        'asiento' => $_POST['id_part3'] ?? null,
    ];

    ob_start();
    $userController->register($data);
    $response = ob_get_clean();
    $result = json_decode($response, true);
    $message = $result['message'] ?? 'There was a problem during registration.';
}

function getProvinceCode(?string $provinceName): ?int {
    $provinces = [
        "Bocas del Toro" => 1,
        "Coclé" => 2,
        "Colón" => 3,
        "Chiriquí" => 4,
        "Darién" => 5,
        "Herrera" => 6,
        "Los Santos" => 7,
        "Panamá" => 8,
        "Veraguas" => 9,
        "Guna Yala, Madugandí, Wargandí" => 10,
        "Emberá Wounaan" => 11,
        "Ngäbe-Buglé" => 12,
        "Panamá Oeste" => 13
    ];

    return $provinces[$provinceName] ?? null;
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
        <input type="text" id="id_part1" name="id_part1" maxlength="2" required style="max-width: 50px;" readonly>
        <span>-</span>  
        <input type="text" name="id_part2" maxlength="5" required style="max-width: 90px;">
        <span>-</span>
        <input type="text" name="id_part3" maxlength="5" required style="max-width: 90px;">
      </div>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" minlength="6" required>

      <button type="submit">Register</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const provinceSelect = document.getElementById("province");
        const idPart1Input = document.getElementById("id_part1");

        const provinceMap = {
            "Bocas del Toro": "01",
            "Coclé": "02",
            "Colón": "03",
            "Chiriquí": "04",
            "Darién": "05",
            "Herrera": "06",
            "Los Santos": "07",
            "Panamá": "08",
            "Veraguas": "09",
            "Guna Yala, Madugandí, Wargandí": "10",
            "Emberá Wounaan": "11",
            "Ngäbe-Buglé": "12",
            "Panamá Oeste": "13"
        };

        provinceSelect.addEventListener("change", () => {
            const selectedProvince = provinceSelect.value;
            if (provinceMap.hasOwnProperty(selectedProvince)) {
                idPart1Input.value = provinceMap[selectedProvince];
            } else {
                idPart1Input.value = "";
            }
        });

        });
    </script>
  </div>
</main>

<script src="/../dsvii-talleres-edu/dsvii-proyecto/public/js/register.js"></script>

<?php
include __DIR__ . '/Partials/Bottom.php';
?>
