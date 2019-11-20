<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title>Bonjour</title>
	<style type="text/css">
		table{
			border-collapse: collapse;
			width: 100%
		}
		th, td{
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
		}
	</style>
</head>
<body>
	<?php
	
		/* initialisation des différentes variables du PDO */
		$host = 'localhost';
		$db   = 'my_activities';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8';
		
		/* définition du PDO */
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		
		try {
			/* création de l'accès à la BD */
			$pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
		
		$stmt = $pdo->query("SELECT users.id as users_id, email, username, name 
							 FROM users 
							 JOIN status ON users.status_id = status.id 
							 WHERE username LIKE 'e%'	AND users.status_id = '2'						 
							 ORDER BY username");
	?>
		<table> 
			<tr class="entete"> 
				<th> Id </th> 
				<th> Username </th> 
				<th> Email </th> 
				<th> Status </th> 
			</tr>
	<?php
				while ($row = $stmt->fetch())
		{
			echo "<tr>
			        <td> $row[users_id] </td> 
					<td> $row[username] </td>
					<td> $row[email] </td>
					<td> $row[name] </td>
				 </tr>" ;
		}
	?>
		</table>
</body>
</html>