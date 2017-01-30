<?php

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
include 'dbCon.php';

function create($table_name, array $table_data) {

    $objCon = connectToDb();

    foreach ($table_data as $row_name => $row_value) {

        $row_nameStr.= $row_name . ",";

        $row_valueStr.= "'" . $row_value . "',";
    }

    $row_nameStr = substr_replace($row_nameStr, "", -1);

    $row_valueStr = substr_replace($row_valueStr, "", -1);

     $sql = "INSERT INTO $table_name($row_nameStr)
	VALUES($row_valueStr)";
     

    $result = $objCon->query($sql);

    return $result;
}

function read($table_name, array $table_rows) {

    $objCon = connectToDb();

    foreach ($table_rows as $row_name) {

        $row_valueStr.= $row_name . ",";
    }

    $row_valueStr = substr_replace($row_valueStr, "", -1);


    $sql = "SELECT $row_valueStr FROM $table_name";

    $result = $objCon->query($sql);

    return $result;
}

function readInnerJoin($table_name1, $table_name2, $join1, $join2, array $table_rows, $optional) {
    $objCon = connectToDb();

    foreach ($table_rows as $row_name) {

        $row_valueStr.= $row_name . ",";
    }

    $row_valueStr = substr_replace($row_valueStr, "", -1);


    $sql = "SELECT $row_valueStr FROM $table_name1 INNER JOIN $table_name2 ON $join1=$join2 $optional";

    
    $result = $objCon->query($sql);

    return $result;
}

function readCustom($table_name, array $table_rows, $optional) {

    $objCon = connectToDb();

    foreach ($table_rows as $row_name) {

        $row_valueStr.= $row_name . ",";
    }

    $row_valueStr = substr_replace($row_valueStr, "", -1);
    
 
    
    $sql = "SELECT $row_valueStr FROM $table_name $optional";
    
    $result = $objCon->query($sql);
    return $result;
}

function readFullCustom($sql) {

    $objCon = connectToDb();
    
    
    $result = $objCon->query($sql);
    return $result;
}

function update($table_name, array $table_data, $col_id_name, $row_id) {

    $objCon = connectToDb();

    foreach ($table_data as $row_name => $row_value) {

        $rows_to_update .= $row_name . "='" . $row_value . "',";

        // -- " .= " binder værdien fra $row_name sammen med værdien fra $row_value -- // 
    }

    $rows_to_update = substr_replace($rows_to_update, "", -1);

    // -- benytter functionen "substr_replace" til at udskifte en del
    // -- af vores string, i dette til fjerner vi det sidste " , " og
    // -- skifter det ud med ingenting 

    echo $sql = "UPDATE $table_name
    SET $rows_to_update
    WHERE $col_id_name = '$row_id'";

    $result = $objCon->query($sql);
}

function doDelete($table_name, $id) {
    $objCon = connectToDb();
   
    $sql = "DELETE FROM $table_name WHERE id = '$id'";
    
    echo $sql;
    
    return $objCon->query($sql);
}

// -- call set up array and call function -- //
// -- use create function -- //

/* $table_name = "menu";

  $table_data;
  $table_data["title"] = "Min title";
  $table_data["cat"] = "Her er min category";
  $table_data["descr"] = "Her er min beskrivelse";

  $result = create($table_name, $table_data); */


// -- use read function -- //

/* $table_name = "menu";

  $table_rows = array("title", "cat", "descr");

  $result = read($table_name, $table_rows);

  while($row = mysqli_fetch_array($result))
  {

  echo "Title: ".$row['title']. "<br/>";
  echo "Category: ".$row['cat']. "<br/>";
  echo "Description: ".$row['descr']. "<br/></br>";
  } */


// -- use update function -- //

/* $col_id_name = "id";
  $row_id = 1;

  $table_name = "menu";

  $table_data; // array
  $table_data["title"] = "Min title";
  $table_data["cat"] = "Her er min category";
  $table_data["descr"] = "Her er min beskrivelse";


  $result = update($table_name, $table_data, $col_id_name, $row_id); */


// -- use delete function -- //

/* $table_name = "menu";

  $row_id = "row_id";

  $id = $_GET['id'];

  Delete($table_name, $row_id, $id); */
?>