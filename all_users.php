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
	<form method="post">
		<select name="actif">
			<option>Active account</option>
			<option>Waiting for account validation</option>
		</select>
		
		<input type="text" name="nom" />

		<input type="submit" />
	</form>
		<table> 
			<tr class="entete"> 
				<th> Id </th> 
				<th> Username </th> 
				<th> Email </th> 
				<th> Status </th> 
			</tr>
		<?php
			if (isset($_POST['actif']) && isset($_POST['nom'])) {
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
				
				$stmt = $pdo->prepare('SELECT * FROM users AS u JOIN status AS s ON u.status_id=s.id WHERE s.name = ? AND u.username LIKE ? ORDER BY username');
				$stmt->execute([$_POST['actif'],$_POST['nom'].'%']);	
			
				while ($row = $stmt->fetch())
				{
						echo '<tr>';
						echo '<td>'.$row['id'].'</td>';
						echo '<td>'.$row['username'].'</td>';
						echo '<td>'.$row['email'].'</td>';
						echo '<td>'.$row['name'].'</td>';
						echo '</tr>';
				}
			}
		?>
	</table>
</body>
</html>