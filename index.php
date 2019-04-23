<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Base</title>
	<link rel="stylesheet" href="Styles.css">
</head>          
<body>
	<div>
		<?php				
			function main_proc($comand)
			{
				define('DB_HOST', '127.0.0.1');
				define('DB_USER', 'root');
				define('DB_PASSWORD', '');
				define('DB_NAME', 'MyDB');
				
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				if ($mysqli -> connect_errno)
				{
					exit ('Не удалось подключиться к ' . DB_NAME . ', ошибка:' . $mysqli -> connect_error);
				}
				else
				{
					echo 'Соединение прошло успешно</br></br>';
					
					$mysqli -> set_charset('utf8');
					
					$comand = explode(' - ',$comand);
					
					$mtime = microtime();
					$mtime = explode(" ", $mtime);
					$mtime = $mtime[1] + $mtime[0];
					$tstart = $mtime;
					
					for($i = 0; $i < count($comand); $i++) 
					{
						if ($comand[$i] != '')
						{
							echo "Команда: " . $comand[$i] . "<br><br>";
							
							//request to the database
							$resultMySQL = $mysqli -> query($comand[$i]);
							if (!$resultMySQL)
							{
								echo "Команда некорректная";
							}
							else
							{
								$resultMySQL = $mysqli -> query($comand[$i]);
								
								while ($row = $resultMySQL -> fetch_array(MYSQLI_ASSOC)) 
								if (isset($row))
								{
									print_r($row); 
									echo "</br>";
								}
								else 
								{
									echo "Результат не найден";
								}
									
								echo "</br>Команда выполнена</br>" . "------------------------------</br>";
							}
						}
					}
					
					$mtime = microtime();
					$mtime = explode(" ", $mtime);
					$mtime = $mtime[1] + $mtime[0];
					$tpassed = $mtime - $tstart;
					echo 'Памяти использовано: ', round(memory_get_usage()/1024/1024,4), ' MB<br>';
					echo "Время выполнения " . round($tpassed,6) . "<br>";
				}
				
				$mysqli->close();
			}
			
			if (isset($_GET["input_text"]))
			{
				$comand = ($_GET["input_text"]);
				main_proc($comand);
			}
		?>
	</div>
	<h4>Введите текст</h4>
	<form method="GET">
		<textarea name="input_text" rows="3" cols="50" placeholder="Введите текст сообщения" required><?= (isset($_GET['input_text'])) ? strip_tags($_GET['input_text']) : '' ?></textarea>
		<div>
			<input type="submit" value="Отправить">
		</div>
	</form>
</body>
</html>