<?php

function getlist_comment(&$mysqli, $pid = 0, $space = 0)
{
	$query = "SELECT * FROM infinite_cate WHERE pid={$pid}";
	$mysqli_result = $mysqli->query($query);
	/* */
	static $all = [];
	static $which_layout;
	for ($i = 1; $i <= ($mysqli_result->num_rows); $i++) {
		$row = $mysqli_result->fetch_array();
		// tree directory list 
		if ($space == 0) {
			if ($i == ($mysqli_result->num_rows)) {
				$which_layout = 0;
				$select_row['name'] = str_repeat('&nbsp', $space) . "└──" . $row['name'];
			}  else {
				$which_layout = 1;
				$select_row['name'] = str_repeat('&nbsp', $space) . "│──" . $row['name'];
			}
		} else {
			if ($i == ($mysqli_result->num_rows)) {
				if ($which_layout === 1) {
					$select_row['name'] = '│' .str_repeat('&nbsp', $space) . "└──" . $row['name'];
				} else {
					$select_row['name'] = str_repeat('&nbsp', $space) . "└──" . $row['name'];
				}
			} else {
				if ($which_layout === 0) {
					$select_row['name'] = str_repeat('&nbsp', $space) . "├──" . $row['name'];
				} else {
					$select_row['name'] = '│' .str_repeat('&nbsp', $space) . "├──" . $row['name'];
				}
			}
		}
		$select_row['id'] = $row['id'];
		$all[] = $select_row;
		getlist_comment($mysqli, $row['id'], $space + 4);
	}
	return $all;
}

function get_all_parent_list(&$mysqli, $id = 0, $space = 0)
{
	$query = "SELECT * FROM infinite_cate WHERE id = {$id}";
	$mysqli_result = $mysqli->query($query);
	static $all = [];
	while ($row = $mysqli_result->fetch_array()) {
		$select_row['name']  = str_repeat('&nbsp', $space) .  "├──" . $row['name'];
		$select_row['id']   = $row['id'];
		$select_row['pid']  = $row['pid'];
		$all[] = $select_row;
		get_all_parent_list($mysqli, $row['pid'], $space + 4);
	}
	return $all;
}

