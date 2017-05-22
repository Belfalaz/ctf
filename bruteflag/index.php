<html>
	<head>
		<title>Flag 1.0</title>
		<meta charset="utf-8" />
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">
		function check(){
			if(document.getElementById('txt_search').value == ""){
				alert('Please Enter Search String');
				return false;
			}
		}
		</script>
	</head>
	<body>
		<div> <!-- Container -->
			<header> <!-- Header -->
				<h1><a href="index.php">Flag 1.0</a></h1>
			</header>
			<div class=".search"> <!-- Content -->
				You must <b>FIND</b> flag by yourself!<br><br>
				<form method="get" action="" onsubmit="javascript:return check();">
					Search <input type="text" name="search" id="txt_search" placeholder="Search.."> 
					<button type="submit">GO</button>
				</form>
				<div class="datagrid">
					<table>
						<thead>
							<tr>
								<th>No.</th>
								<th>Subject</th>
							</tr>
						</thead>
						<?php
							#include("config.php");
							$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
							$dbhost = $url["host"];
							$dbuser = $url["user"];
							$dbpass = $url["pass"];
							$dbname = substr($url["path"], 1);
							if(isset($_GET['search']) != "") {
								$search = $_GET['search'];
								$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
								if($conn->connect_error) {
									die("<tbody><tr><td>Err</td><td>Connection Failed</td></tr></tbody>");
								}
								$param = "%" . $_GET['search'] . "%";
								$stmt = $conn->prepare("SELECT * FROM flag WHERE data LIKE ? or subject LIKE ?");
								$stmt->bind_param("ss", $param, $param);
								$stmt->execute();
								$result = $stmt->get_result();
								$row = $result->fetch_assoc();
								if($row) {
									echo "<tbody>";
									echo "<tr><td>" . $row["id"] . "</td><td>" . $row["subject"] . "</td></tr>";
									echo "</tbody>";
								}
								$conn->close();

							} else {
								echo "<tbody>";
								echo "<tr><td>Err</td><td>Please Enter Search String.</td></tr>";
								echo "</tbody>";
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
