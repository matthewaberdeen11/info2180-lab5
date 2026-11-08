<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = trim($_GET['country'] ?? '');
$lookupCities = ($_GET['lookup'] ?? '') === 'cities';

if ($lookupCities) {
    $sql = "SELECT cities.name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
            ORDER BY cities.name";
} else {
    $sql = "SELECT name, continent, independence_year, head_of_state
            FROM countries
            WHERE name LIKE :country
            ORDER BY name";
}

$stmt = $conn->prepare($sql);
$stmt->execute(['country' => '%' . $country . '%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($lookupCities): ?>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>District</th>
        <th>Population</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['district']) ?></td>
          <td><?= number_format((int) $row['population']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Country Name</th>
        <th>Continent</th>
        <th>Independence Year</th>
        <th>Head of State</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['continent']) ?></td>
          <td><?= htmlspecialchars((string) ($row['independence_year'] ?? '—')) ?></td>
          <td><?= htmlspecialchars($row['head_of_state'] ?? '—') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>