<!DOCTYPE html>
<html>
  <head>
    <title>Delete Document Type</title>
  </head>
  <body>
<?php 
      $doctype_id = $_GET['doctype'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } else {
        $sql1 = "select t.document_type, d.num_docs ".
                "from document_type t, ".
                "(select count(*) num_docs from document where document_type_id = ".$doctype_id.") d ".
                "where t.document_type_id = ".$doctype_id;
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error checking for documents of this type [" . $mysqli->error . "]";
        } elseif ($doctype = $result1->fetch_assoc()) {
          $document_type = $doctype['document_type'];
          $num_docs = $doctype['num_docs'];
          if ($num_docs == 0) {
            $sql1 = "delete from document_type where document_type_id = ".$doctype_id;
            if (!$mysqli->query($sql1)) {
              $alert_msg = "There was an error deleting the document type [" . $mysqli->error . "]";
            } else {
            $mysqli->commit();
              $alert_msg = "";
//            $alert_msg = "Document type \\\"" . $document_type . "\\\" deleted!";
            }
          } else {
            $alert_msg = "Document type \\\"" . $document_type . "\\\" cannot be deleted!\\nDocument type still has " .
                         $num_docs . " document(s). Delete all documents of this type before deleting this document type.";
          }
        } else {
          $alert_msg = "Document type \\\"".$document_type."\\\" not found!";
        }
        $result1->free();
        $mysqli->close();
      }
      echo "    <script>\n";
      if ($alert_msg != "") {
        echo "      alert(\"" . $alert_msg . "\");\n";
      }
      echo "      document.location = \"list_doctypes.php\"\n";
      echo "    </script>\n";
?>
  </body>
</html>