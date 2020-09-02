<?php




require __DIR__.'/function.php';

$mysqli = new mysqli('localhost', 'root', '', 'books');

/* of cource, if need, you can control plies numbers */
const plies = PHP_INT_MAX;

if (@$_GET['name']) {
	$name = @$_GET['name'];
	$pid = @intval($_GET['id']);
	if (count(get_all_parent_list($mysqli, $pid)) >= plies) {
		echo "larger than ".plies." level";
		?>
		<h1>3 seconds later will location... </h1>
		<script> window.setInterval("location='<?php echo $_SERVER['SCRIPT_NAME']; ?>'", 3000); </script>
		<?php
		exit;
	}
	$query  = "INSERT INTO infinite_cate (id, pid, name) VALUES (NULL, '$pid', '$name')";
	$mysqli->query($query);
	header("Location: ".$_SERVER['SCRIPT_NAME']); 
	exit;
}

$all_rows = getlist_comment($mysqli);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>php infinite cate - Bootstrap Template</title>
		<meta name="viewport" content="width=device-width,  initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>
		<div class="container">
			<form action="" method="get">
				<fieldset>
					<legend>php infinite cate</legend>
					<label>new cate name</label>
					<input name="name" type="text" placeholder="Type  something…">
					<span class="help-block">Example block-level help text here.</span>
					<select  name="id">
						<option value="0">select this to add top cate</option>
					<?php foreach ($all_rows as $key => $value) : ?>
						<option value="<?php echo $value['id']; ?>"> <?php echo $value['name'] ?> </option>
					<?php endforeach ?>
					</select>
					<br>
					<button type="submit" class="btn">Submit</button>
				</fieldset>
			</form>
		</div>
	</body>

</html>