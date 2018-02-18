<!DOCTYPE html>
<html>
  <head>
    <title>My Document</title>
  </head>
  <body>
    <h2>Document Details</h2>
<?php 
      function QuoteOrNull($this_value) {
        if ($this_value == "") {
          return "NULL";
        } else {
          return "'".$this_value."'";
        }
      }
      $action = $_GET['action'];
      $document_id = $_GET['document_id'];
      $project_id = $_GET['project'];
      $document_type = $_GET['doctype'];
      $document_name = $_GET['document'];
      $document_desc = $_GET['description'];
      $document_loc = $_GET['location'];
      $alert_msg = "";       
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } elseif ($action == "Add") {
        $type = "Added";
        $sql1 = "insert into document (project_id, document_type_id, document_name, ".
                "document_description, document_location) ".
                "values (" . $project_id . ", " . $document_type . ", '" . $document_name . "', " .
                QuoteOrNull($document_desc) . ", '" . addslashes($document_loc) . "')";
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error inserting the document [" . $mysqli->error . "]";
        }
        $sql1 = "select last_insert_id() document_id";
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error retrieving the document ID [" . $mysqli->error . "]";
        } elseif ($document = $result1->fetch_assoc()) {
          $document_id = $document['document_id'];
        } else {
          $alert_msg = "There was an error retrieving the document ID [Not Found!]";
        }
        $result1->free();
      } else {
        $type = "Updated";
        $sql1 = "update document set project_id = " . $project_id .
                ", document_type_id = " . $document_type .
                ", document_name = '" . $document_name . "'" . 
                ", document_description = " . QuoteOrNull($document_desc) .
                ", document_location = '" . addslashes($document_loc) . "'" .
                " where document_id = " . $document_id; 
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error updating the document [" . $mysqli->error . "]";
        }
      }
      if ($alert_msg == "") {
        $mysqli->commit();
        echo "    <script>\n";
//        echo "      alert(\"Document '" . $document_name . "' " . $type . "\");\n";
        if ($action == "Add") {
          echo "      window.parent.postMessage(\"displayDocument:" . $project_id . ":" . $document_id . ":" . $document_name . "\", 'http://localhost');\n";
        } else {
          echo "      var doc = parent.document.getElementById(\"d" . $document_id . "\");\n";
          echo "      doc.textContent = \"" . $document_name . "\";\n";
          echo "      document.location = \"document.php?document=" . $document_id . "\"\n";
        }
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