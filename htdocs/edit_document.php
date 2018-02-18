<!DOCTYPE html>
<html>
  <head>
    <title>My Document</title>
    <script>
      function goBack() {
        window.history.back()
      }
    </script>
  </head>
  <body>
<?php 
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      $document_id = $_GET['document'];
      $project_id = "";
      $document_name = "";
      $document_desc = "";
      $document_location = "";
      $document_type_id = "";
      if ($document_id > 0) {
        $sql1 = "select document_id, project_id, document_name, document_description, document_location, document_type_id ".
                "from document ".
                "where document_id = ".$document_id;
        if (!$result1 = $mysqli->query($sql1)) {
          die('There was an error running the query [' . $mysqli->error . ']');
        }
        if ($document = $result1->fetch_assoc()) {
          $type = "Edit";
          $project_id = $document['project_id'];
          $document_name = $document['document_name'];
          $document_desc = $document['document_description'];
          $document_location = $document['document_location'];
          $document_type_id = $document['document_type_id'];
        } else {
          $type = "Add";
        }
        $result1->free();
      } else {
        $type = "Add";
        $project_id = $_GET['project'];
      }
      $sql1 = "select project_name ".
              "from project ".
              "where project_id = ".$project_id;
      if (!$result1 = $mysqli->query($sql1)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      if ($project = $result1->fetch_assoc()) {
        $project_name = $project['project_name'];
      }
      $result1->free();
      echo "    <h2>" . $type . " Document</h2>\n";
      echo "    <form action=\"upd_document.php\" name=\"" . $type . " Document\">\n";
      echo "      <input type=\"hidden\" name=\"action\" value = \"" . $type . "\">\n";
      echo "      <input type=\"hidden\" name=\"document_id\" value = \"" . $document_id . "\">\n";
      echo "      <table>\n";
      echo "        <tr>\n";
      echo "          <td>Project:</td>\n";
      echo "          <td>\n";
      echo "            <select name= \"project\">\n";
      $sql2 = "select p.project_id, concat(c.client_short_name, ' - ', p.project_name) project_name ".
              "from project p, client c ".
              "where p.client_id = c.client_id ".
              "order by project_name";
      if (!$result2 = $mysqli->query($sql2)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      while ($row2 = $result2->fetch_assoc()) {
        echo "              <option value=\"" . $row2['project_id']. "\"";
        if ($row2['project_id'] == $project_id) {
          echo " selected";
        }
        echo ">" . $row2['project_name'] . "</option>\n";
      }
      $result2->free();
      echo "            </select>\n";
      echo "          </td>\n";
      echo "        </tr>\n";
      echo "        <tr><td>Document:</td><td><input type=\"text\" name=\"document\" maxlength = \"80\" size = \"80\" required value=\"" . $document_name . "\"></td></tr>\n";
      echo "        <tr><td>Description:</td><td><input type=\"text\" name=\"description\" maxlength = \"200\" size = \"100\" value=\"" . $document_desc . "\"></td></tr>\n";
      echo "        <tr><td>Location:</td><td><input type=\"text\" name=\"location\" maxlength = \"200\" size = \"100\" required value=\"" . $document_location . "\"></td></tr>\n";
      echo "        <tr>\n";
      echo "          <td>Document Type:</td>\n";
      echo "          <td>\n";
      echo "            <select name= \"doctype\">\n";
      $sql3 = "select document_type_id, document_type ".
              "from document_type ".
              "order by document_type";
      if (!$result3 = $mysqli->query($sql3)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      while ($row3 = $result3->fetch_assoc()) {
        echo "              <option value=\"" . $row3['document_type_id']. "\"";
        if ($row3['document_type_id'] == $document_type_id) {
          echo " selected";
        }
        echo ">" . $row3['document_type'] . "</option>\n";
      }
      $result3->free();
      echo "            </select>\n";
      echo "          </td>\n";
      echo "        </tr>\n";
      echo "      </table><br/>\n";
      echo "      <input type=\"submit\" value=\"Submit\">\n";
      echo "      <input type=\"button\" value=\"Cancel\" onclick=\"goBack()\">\n";
      echo "    </form>\n";
      $mysqli->close();
?>
  </body>
</html>