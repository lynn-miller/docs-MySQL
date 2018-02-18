<!DOCTYPE html>
<html>
  <head>
    <title>My Project</title>
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
      $client_id = $_GET['client_id'];
      $client_name = $_GET['client'];
      $short_name = $_GET['short'];
      $return_url = $_GET['return_url'];
      $alert_msg = "";       
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } elseif ($action == "Add") {
        $type = "Added";
        $sql1 = "insert into client (client_name, client_short_name) ".
                "values ('" . $client_name . "', '" . $short_name . "')";
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error inserting the client [" . $mysqli->error . "]";
        }
        $sql1 = "select last_insert_id() client_id";
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error retrieving the client ID [" . $mysqli->error . "]";
        } elseif ($client = $result1->fetch_assoc()) {
          $client_id = $client['client_id'];
        } else {
          $alert_msg = "There was an error retrieving the client ID [Not Found!]";
        }
        $result1->free();
      } else {
        $type = "Updated";
        $sql1 = "update client set ".
                "client_name = '" . $client_name . "', " . 
                "client_short_name = '" . $short_name . "' " . 
                "where client_id = " . $client_id; 
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error updating the client [" . $mysqli->error . "]";
        }
      }
      if ($alert_msg == "") {
        $mysqli->commit();
        echo "    <script>\n";
//        echo "      alert(\"Client '" . $client_name . "' " . $type . "\");\n";
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