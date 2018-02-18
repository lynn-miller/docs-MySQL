<!DOCTYPE html>
<html>
  <head>
    <title>Delete Client</title>
  </head>
  <body>
<?php 
      $client_id = $_GET['client'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } else {
        $sql1 = "select c.client_name, d.num_projs ".
                "from client c, ".
                "(select count(*) num_projs from project where client_id = ".$client_id.") d ".
                "where c.client_id = ".$client_id;
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error checking for client projects [" . $mysqli->error . "]";
        } elseif ($client = $result1->fetch_assoc()) {
          $client_name = $client['client_name'];
          $num_projs = $client['num_projs'];
          if ($num_projs == 0) {
            $sql1 = "delete from client where client_id = ".$client_id;
            if (!$mysqli->query($sql1)) {
              $alert_msg = "There was an error deleting the client [" . $mysqli->error . "]";
            } else {
              $mysqli->commit();
              $alert_msg = "";
//              $alert_msg = "Client \\\"" . $client_name . "\\\" deleted!";
            }
          } else {
            $alert_msg = "Client  \\\"" . $client_name . "\\\" cannot be deleted!\\nClient still has " .
                         $num_projs . " project(s). Delete all projects before deleting this client.";
          }
        } else {
          $alert_msg = "Client \\\"" . $client_name . "\\\" not found!";
        }
        $result1->free();
        $mysqli->close();
      }
      echo "    <script>\n";
      if ($alert_msg != "") {
        echo "      alert(\"" . $alert_msg . "\");\n";
      }
      echo "      document.location = \"list_clients.php\"\n";
      echo "    </script>\n";
?>
  </body>
</html>