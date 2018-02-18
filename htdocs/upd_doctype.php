<!DOCTYPE html>
<html>
  <head>
    <title>Update Document Type</title>
  </head>
  <body>
<?php 
      function QuoteOrNull($this_value) {
        if ($this_value == "") {
          return "NULL";
        } else {
          return "'".$this_value."'";
        }
      }
      $action = $_GET['action'];
      $doctype_id = $_GET['doctype_id'];
      $document_type = $_GET['doctype'];
      $open_with = $_GET['openwith'];
      $return_url = $_GET['return_url'];
      $alert_msg = "";
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } elseif ($action == "Add") {
        $type = "Added";
        $sql1 = "insert into document_type (document_type, open_with) ".
                "values ('" . $document_type . "', '" . addslashes($open_with) . "')";
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error inserting the document type [" . $mysqli->error . "]";
        }
        $sql1 = "select last_insert_id() doctype_id";
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error retrieving the document type ID [" . $mysqli->error . "]";
        }
        if ($row = $result1->fetch_assoc()) {
          $doctype_id = $row['doctype_id'];
        } else {
          $alert_msg = "There was an error retrieving the document type ID [Not Found!]";
        }
        $result1->free();
      } else {
        $type = "Updated";
        $sql1 = "update document_type set ".
                "document_type = '" . $document_type . "', " . 
                "open_with = '" . addslashes($open_with) . "' " . 
                "where document_type_id = " . $doctype_id; 
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error updating the document type [" . $mysqli->error . "]";
        }
      }
      if ($alert_msg == "") {
        $mysqli->commit();
        echo "    <script>\n";
//        echo "      alert(\"Document type '" . $document_type . "' " . $type . "\");\n";
        echo "      document.location = \"" . $return_url . "\"\n";
        echo "    </script>\n";
      } else {
        $mysqli->rollback();
        echo "    <script>\n";
        echo "      alert(\"" . $alert_msg . "\");\n";
        echo "      window.history.back();\n";
        echo "    </script>\n";
      }
      $mysqli->close();
?>
  </body>
</html>