<!DOCTYPE html>
<html>
  <head>
    <title>My Project</title>
    <script>
      function goBack() {
        window.history.back()
      }
    </script>
  </head>
  <body>
<?php 
      $project_id = $_GET['project'];
//      $client_id = 0;
      $client_id = (isset($_GET['client']) ? $_GET['client'] : 0);
      $client_name = "";
      $project_name = "";
      $project_desc = "";
      $start_date = "";
      $end_date = "";
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      if ($project_id > 0) {
        $sql1 = "select p.project_id, p.project_name, c.client_id, c.client_name, p.project_description, p.start_date, p.end_date ".
                "from project p, client c ".
                "where project_id = ".$project_id.
                "  and p.client_id = c.client_id";
        if (!$result1 = $mysqli->query($sql1)) {
          die('There was an error running the query [' . $mysqli->error . ']');
        }
        if ($project = $result1->fetch_assoc()) {
          $type = "Edit";
          $client_id = $project['client_id'];
          $project_name = $project['project_name'];
          $project_desc = $project['project_description'];
          $start_date = $project['start_date'];
          $end_date = $project['end_date'];
        } else {
          $type = "Add";
        }
        $result1->free();
      } else {
        $type = "Add";
//        $client_id = $_GET['client'];
      }
      echo "    <h2>" . $type . " Project</h2>\n";
      echo "    <form action=\"upd_project.php\" name=\"" . $type . " Project\">\n";
      echo "      <input type=\"hidden\" name=\"action\" value = \"" . $type . "\">\n";
      echo "      <input type=\"hidden\" name=\"project_id\" value = \"" . $project_id . "\">\n";
      echo "      <table>\n";
      echo "        <tr>\n";
      echo "          <td>Client:</td>\n";
      echo "          <td>\n";
      echo "            <select name= \"client\">\n";
      $sql2 = "select client_id, client_name, client_short_name ".
              "from client ".
              "order by client_short_name";
      if (!$result2 = $mysqli->query($sql2)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      while ($row2 = $result2->fetch_assoc()) {
        echo "              <option value=\"" . $row2['client_id']. ":" . $row2['client_short_name'] . "\" label=\"" . $row2['client_short_name'] . "\"";
        if ($row2['client_id'] == $client_id) {
          echo " selected";
        }
        echo ">" . $row2['client_name'] . "</option>\n";
      }
      echo "            </select>\n";
      echo "          </td>\n";
      echo "        </tr>\n";
      echo "        <tr><td>Project:</td><td><input type=\"text\" name=\"project\" maxlength = \"30\" size = \"30\" required value=\"" . $project_name . "\"></td></tr>\n";
      echo "        <tr><td>Description:</td><td><input type=\"text\" name=\"description\" maxlength = \"100\" size = \"100\" value=\"" . $project_desc . "\"></td></tr>\n";
      echo "        <tr><td>Start Date:</td><td><input type=\"date\" name=\"start\" value=\"" . $start_date . "\"></td></tr>\n";
      echo "        <tr><td>Finish Date:</td><td><input type=\"date\" name=\"finish\" value=\"" . $end_date . "\"></td></tr>\n";
      echo "      </table><br/>\n";
      echo "      <input type=\"submit\" value=\"Submit\">\n";
      echo "      <input type=\"button\" value=\"Cancel\" onclick=\"goBack()\">\n";
      echo "    </form>\n";
      $result2->free();
      $mysqli->close();
?>
  </body>
</html>