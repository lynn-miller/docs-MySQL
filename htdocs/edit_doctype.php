<!DOCTYPE html>
<html>
  <head>
    <title>My Document Type</title>
    <script>
      function goBack() {
        window.history.back();
      }
    </script>
  </head>
  <body>
<?php 
      $return_url = (isset($_GET['return_url']) ? $_GET['return_url'] : $_SERVER['HTTP_REFERER']);
      $document_type_id = $_GET['doctype'];
      $document_type = "";
      $open_with = "";
      if ($document_type_id > 0) {
        $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
        if ($mysqli->connect_errno) {
          die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        $sql1 = "select document_type_id, document_type, open_with ".
                "from document_type ".
                "where document_type_id = ".$document_type_id;
        if (!$result1 = $mysqli->query($sql1)) {
          die('There was an error running the query [' . $mysqli->error . ']');
        }
        if ($doctype = $result1->fetch_assoc()) {
          $type = "Edit";
          $document_type = $doctype['document_type'];
          $open_with = $doctype['open_with'];
        } else {
          $type = "Add";
        }
        $result1->free();
        $mysqli->close();
      } else {
        $type = "Add";
      }
      echo "    <h2>" . $type . " Document Type</h2>\n";
      echo "    <form action=\"upd_doctype.php\" name=\"" . $type . " Document Type\">\n";
      echo "      <input type=\"hidden\" name=\"action\" value = \"" . $type . "\">\n";
      echo "      <input type=\"hidden\" name=\"doctype_id\" value = \"" . $document_type_id . "\">\n";
      echo "      <input type=\"hidden\" name=\"return_url\" value = \"" . $return_url . "\">\n";
      echo "      <table>\n";
      echo "        <tr><td>Document Type:</td><td><input type=\"text\" name=\"doctype\" maxlength = \"20\" size = \"20\" required value=\"" . $document_type . "\"></td></tr>\n";
      echo "        <tr><td>Open With:</td><td><input type=\"text\" name=\"openwith\" maxlength = \"80\" size = \"80\" required value=\"" . $open_with . "\"></td></tr>\n";
      echo "      </table><br/>\n";
      echo "      <input type=\"submit\" value=\"Submit\">\n";
      echo "      <input type=\"button\" value=\"Cancel\" onclick=\"goBack()\">\n";
      echo "    </form>\n";
?>
  </body>
</html>