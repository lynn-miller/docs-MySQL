<!DOCTYPE html>
<html>
  <head>
    <title>My Client</title>
    <script>
      function goBack() {
        window.history.back();
      }
    </script>
  </head>
  <body>
<?php 
      $return_url = (isset($_GET['return_url']) ? $_GET['return_url'] : $_SERVER['HTTP_REFERER']);
      $client_id = $_GET['client'];
      $client_name = "";
      $short_name = "";
      if ($client_id > 0) {
        $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
        if ($mysqli->connect_errno) {
          die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        $sql1 = "select client_id, client_name, client_short_name ".
                "from client ".
                "where client_id = ".$client_id;
        if (!$result1 = $mysqli->query($sql1)) {
          die('There was an error running the query [' . $mysqli->error . ']');
        }
        if ($client = $result1->fetch_assoc()) {
          $type = "Edit";
          $client_name = $client['client_name'];
          $short_name = $client['client_short_name'];
        } else {
          $type = "Add";
        }
        $result1->free();
        $mysqli->close();
      } else {
        $type = "Add";
      }
      echo "    <h2>" . $type . " Client</h2>\n";
      echo "    <form action=\"upd_client.php\" name=\"" . $type . " Client\">\n";
      echo "      <input type=\"hidden\" name=\"action\" value = \"" . $type . "\">\n";
      echo "      <input type=\"hidden\" name=\"client_id\" value = \"" . $client_id . "\">\n";
      echo "      <input type=\"hidden\" name=\"return_url\" value = \"" . $return_url . "\">\n";
      echo "      <table>\n";
      echo "        <tr><td>Client Name:</td><td><input type=\"text\" name=\"client\" maxlength = \"50\" size = \"50\" required value=\"" . $client_name . "\"></td></tr>\n";
      echo "        <tr><td>Short Name:</td><td><input type=\"text\" name=\"short\" maxlength = \"10\" size = \"10\" required value=\"" . $short_name . "\"></td></tr>\n";
      echo "      </table><br/>\n";
      echo "      <input type=\"submit\" value=\"Submit\">\n";
      echo "      <input type=\"button\" value=\"Cancel\" onclick=\"goBack()\">\n";
      echo "    </form>\n";
?>
  </body>
</html>