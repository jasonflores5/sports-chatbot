<?php
/***** Database Connect *****/
function pdo_dbopen() {
	$conf = & $GLOBALS['config']['db'];
	$db_user = $conf['username'];
	$db_pass = $conf['password'];
	$db_name = $conf['database'];
	
	$db = new PDO( 'mysql:host=localhost;dbname='. $db_name, $db_user, $db_pass );
	return $db;
}

/***** Insert *****/
function pdo_insert($sql, array $form_data) {
	$db = pdo_dbopen();
	// prepare statement
	$pdo = $db->prepare( $sql );
	
	// bind values of $form_data
	foreach($form_data as $k => $v) {
		$pdo->bindValue(":$k", $v);
	}
	
	$pdo->execute();

	// return number of rows affected
	$row_count = $pdo->rowCount();
	return $row_count;
}

/***** Select View *****/
function pdo_select_view($sql, array $form_data=null) {
	$db = pdo_dbopen();
	
	// prepare statement
	$pdo = $db->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY) );
	
	// bind values of $form_data
	foreach($form_data as $k => $v) {
		// check $form_data if the key value (named parameter) exists in the sql statement.
		if (preg_match('/'. $k .'/', $sql)) {
			$pdo->bindValue(":$k", $v);
		}
	}
	
	$pdo->execute();
	
	// return row data
	$fetch_row_data = $pdo->fetch(PDO::FETCH_ASSOC);
	return $fetch_row_data;
}

/***** Select List *****/
function pdo_select_list($sql, array $form_data=null) {
	$db = pdo_dbopen();
	
	// prepare statement
	$pdo = $db->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY) );
	//$pdo = $db->prepare( $sql );
	
	// bind values of $form_data
    foreach($form_data as $k => $v) {
        // check $form_data if the key value (named parameter) exists in the sql statement.
        if (preg_match('/'. $k .'/', $sql)) {
            $pdo->bindValue(":$k", $v);
        }
    }

	$pdo->execute();
	
	// return row data
	$fetch_row_data = $pdo->fetchAll(PDO::FETCH_ASSOC);
	return $fetch_row_data;
}

/***** Update *****/
function pdo_update($sql, array $form_data) {
	$db = pdo_dbopen();
	
	// prepare statement
	$pdo = $db->prepare( $sql );
	
	// bind values of $form_data
	foreach($form_data as $k => $v) {
		// check $form_data if the key value (named parameter) exists in the sql statement.
		if (preg_match('/'. $k .'/', $sql)) {
			$pdo->bindValue(":$k", $v);
		}
	}
	
	$pdo->execute();
	
	// return number of rows affected
	$row_count = $pdo->rowCount();
	return $row_count;
}
?>