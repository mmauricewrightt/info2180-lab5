<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$results = []; 

$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'countries';



if ($lookup === 'cities') {
    
    $stmt = $conn->prepare(
        "SELECT cities.name, cities.district, cities.population
         FROM cities
         JOIN countries ON cities.country_code = countries.code
         WHERE countries.name LIKE :country"
    );
} else {
  
    $stmt = $conn->prepare(
        "SELECT * 
         FROM countries 
         WHERE name LIKE :country"
    );
}


$country = "%$country%";
$stmt->bindParam(':country', $country, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


function generateCountryTableRow($row) {
    return '<tr>'
         . '<td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '<td>' . htmlspecialchars($row['continent'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '<td>' . htmlspecialchars($row['independence_year'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '<td>' . htmlspecialchars($row['head_of_state'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '</tr>';
}

function generateCityTableRow($row) {
    return '<tr>'
         . '<td>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '<td>' . htmlspecialchars($row['district'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '<td>' . htmlspecialchars($row['population'], ENT_QUOTES, 'UTF-8') . '</td>'
         . '</tr>';
}

// Generate and output the appropriate table
if ($lookup === 'cities') {
    // Table for cities
    $tableRows = array_map('generateCityTableRow', $results);
    echo '<table>'
       . '<tr><th>Name</th><th>District</th><th>Population</th></tr>'
       . implode("\n", $tableRows)
       . '</table>';
} else {
  
    $tableRows = array_map('generateCountryTableRow', $results);
    echo '<table>'
       . '<tr><th>Country Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>'
       . implode("\n", $tableRows)
       . '</table>';
}
?>
