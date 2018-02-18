<!DOCTYPE html>
<html>
  <head>
    <title>Delete Document</title>
  </head>
  <body>
<?php 
      $document_id = $_GET['document'];
      $document_name = $_GET['doc_name'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        echo "    <script>\n";
        echo "      alert(\"".$alert_msg."\");\n";
        echo "      window.history.back();\n";
        echo "    </script>\n";
      } else {
        $sql1 = "delete from document where document_id = ".$document_id;
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error deleting the document [" . $mysqli->error . "]";
          echo "    <script>\n";
          echo "      alert(\"".$alert_msg."\");\n";
          echo "      window.history.back();\n";
          echo "    </script>\n";
        } else {
          $mysqli->commit();
          echo "    <script>\n";
          echo "      var doc = parent.document.getElementById(\"d" . $document_id . "\");\n";
          echo "      doc.parentNode.removeChild(doc);\n";
//          echo "      alert(\"Document \\\"".$document_name."\\\" deleted!\");\n";
          echo "    </script>\n";
        }
        $mysqli->close();
      }
?>
  </body>
</html>