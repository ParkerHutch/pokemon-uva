
<html>
   <h1>View/Search/Filter Pokemon</h1>
   <form action="all_pokemon.php" method="post">
      Name: <input type="text" name="animal_name"><br>
      Type: <input type="text" name="animal_type"><br>
      Type1: <select name="pokemon_type_1">
            <option value="" selected disabled hidden>Select</option>
            <option value="Normal">Normal</option>
            <option value="Fire">Fire</option>
            <option value="Water">Water</option>
            <option value="Grass">Grass</option>
            <option value="Electric">Electric</option>
            <option value="Ice">Ice</option>
            <option value="Fighting">Fighting</option>
            <option value="Poison">Poison</option>
            <option value="Ground">Ground</option>
            <option value="Flying">Flying</option>
            <option value="Psychic">Psychic</option>
            <option value="Bug">Bug</option>
            <option value="Rock">Rock</option>
            <option value="Ghost">Ghost</option>
            <option value="Dark">Dark</option>
            <option value="Dragon">Dragon</option>
            <option value="Steel">Steel</option>
            <option value="Fairy">Fairy</option>
            </select>
         Type2: <select name="pokemon_type_2">
            <option value="" selected disabled hidden>Select</option>
            <option value="Normal">Normal</option>
            <option value="Fire">Fire</option>
            <option value="Water">Water</option>
            <option value="Grass">Grass</option>
            <option value="Electric">Electric</option>
            <option value="Ice">Ice</option>
            <option value="Fighting">Fighting</option>
            <option value="Poison">Poison</option>
            <option value="Ground">Ground</option>
            <option value="Flying">Flying</option>
            <option value="Psychic">Psychic</option>
            <option value="Bug">Bug</option>
            <option value="Rock">Rock</option>
            <option value="Ghost">Ghost</option>
            <option value="Dark">Dark</option>
            <option value="Dragon">Dragon</option>
            <option value="Steel">Steel</option>
            <option value="Fairy">Fairy</option>
            </select>
   <input type="submit" />
</html>
<?php

$username = 'root';
$password = 'Tonyle1!';
$host = 'cs-4750-project-381321:us-east4:cs-4750-project';
$dbname = 'Pokemon';
$dsn = "mysql:unix_socket=/cloudsql/cs-4750-project-381321:us-east4:cs-4750-project;dbname=Pokemon";

$animal_type   = $_POST['animal_type'];
$animal_name   = $_POST['animal_name'];
$pokemon_type_1 = $_POST['pokemon_type_1'];
$pokemon_type_2 = $_POST['pokemon_type_2'];

$sql = "SELECT Name, Type1, Type2 FROM pokemon";

$type_clause = '';

if(!empty($pokemon_type_1) and !empty($pokemon_type_2)) {
   echo "<p>Worked</p>";
   $type_clause = " AND (Type1 IN('$pokemon_type_1', '$pokemon_type_2') OR Type2 IN('$pokemon_type_1', '$pokemon_type_2'))";
} else if (!empty($pokemon_type_1)) {
   $type_clause = " AND (Type1 IN('$pokemon_type_1') OR Type2 IN('$pokemon_type_1'))";
} else if (!empty($pokemon_type_2)) {
   $type_clause = " AND (Type1 IN('$pokemon_type_2') OR Type2 IN('$pokemon_type_2'))";
} 
try
{
   $db = new PDO($dsn, $username, $password);
   
   
   
   //$type_clause = trim($pokemon_type_1) === '' ? '' : " AND (Type1 IN('$pokemon_type_1', '$pokemon_type_2') OR Type2 IN('$pokemon_type_1', '$pokemon_type_2'))";
   $sql .= " WHERE Name LIKE '%$animal_name%'";
   $sql .= $type_clause;

   echo "<p>Query: $sql</p>";
   echo "<table>
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Type1</th>
                  <th>Type2</th>
               </tr>
               </thead>
               <tbody>";
      
   foreach ($db->query($sql) as $row) {
      echo "<tr>";
      echo "<td>{$row[Name]}</td>";
      echo "<td>{$row[Type1]}</td>";
      echo "<td>{$row[Type2]}</td>";
      echo "</tr>";
    //echo "<li>{$row[Name]}<li>";
   }
   echo "</tbody>";
   echo "</table>";
   
}
catch (PDOException $e)
{
   $error_message = $e->getMessage();
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>
