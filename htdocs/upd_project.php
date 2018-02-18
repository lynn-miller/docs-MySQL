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
      $project_id = $_GET['project_id'];
      $client_str = explode(":", $_GET['client'], 2);
      $client_id = $client_str[0];
      $client_name = $client_str[1];
      $project_name = $_GET['project'];
      $project_desc = $_GET['description'];
      $start_date = $_GET['start'];
      $end_date = $_GET['finish'];
      $alert_msg = "";       
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } elseif ($action == "Add") {
        $type = "Added";
        $sql1 = "insert into project (client_id, project_name, project_description, start_date, end_date) ".
                "values (" . $client_id . ", '" . $project_name . "', " . QuoteOrNull($project_desc) .
                ", " . QuoteOrNull($start_date) . ", " . QuoteOrNull($end_date) . ")";
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error inserting the project [" . $mysqli->error . "]";
        }
        $sql1 = "select last_insert_id() project_id";
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error retrieving the project ID [" . $mysqli->error . "]";
        } elseif ($project = $result1->fetch_assoc()) {
          $project_id = $project['project_id'];
        } else {
          $alert_msg = "There was an error retrieving the project ID [Not Found!]";
        }
        $result1->free();
      } else {
        $type = "Updated";
        $sql1 = "update project set ".
                "client_id = " . $client_id . ", " .
                "project_name = '" . $project_name . "', " . 
                "project_description = " . QuoteOrNull($project_desc) . ", " . 
                "start_date = " . QuoteOrNull($start_date) . ", " . 
                "end_date = " . QuoteOrNull($end_date) . " " .
                "where project_id = " . $project_id; 
        if (!$mysqli->query($sql1)) {
          $alert_msg = "There was an error updating the project [" . $mysqli->error . "]";
        }
      }
      if ($alert_msg == "") {
        $mysqli->commit();
        echo "    <script>\n";
//        echo "      alert(\"Project '" . $project_name . "' " . $type . "\");\n";
        if ($action == "Add") {
          echo "      window.parent.postMessage(\"displayProject:" . $project_id . ":" . $client_id . ":" . $client_name . " - " . $project_name . "\", 'http://localhost');\n";
        } else {
          echo "      var doc = parent.document.getElementById(\"li" . $project_id . "\");\n";
          echo "      doc.textContent = \"" . $client_name . " - " . $project_name . "\";\n";
          echo "      document.location = \"project.php?project=" . $project_id . "\"\n";
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