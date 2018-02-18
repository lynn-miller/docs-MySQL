<!DOCTYPE html>
<html>
  <head>
    <title>Delete Project</title>
  </head>
  <body>
<?php 
      $project_id = $_GET['project'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        $alert_msg = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      } else {
        $sql1 = "select p.project_name, d.num_docs ".
                "from project p, ".
                "(select count(*) num_docs from document where project_id = ".$project_id.") d ".
                "where p.project_id = ".$project_id;
        if (!$result1 = $mysqli->query($sql1)) {
          $alert_msg = "There was an error checking for project documents [" . $mysqli->error . "]";
        } elseif ($project = $result1->fetch_assoc()) {
          $project_name = $project['project_name'];
          $num_docs = $project['num_docs'];
          if ($num_docs == 0) {
            $sql1 = "delete from project where project_id = ".$project_id;
            if (!$mysqli->query($sql1)) {
              $alert_msg = "There was an error deleting the project [" . $mysqli->error . "]";
            } else {
              $mysqli->commit();
              $alert_msg = "";
//              $alert_msg = "Project \\\"" . $project_name . "\\\" deleted!";
              echo "    <script>\n";
              echo "      var doc = parent.document.getElementById(\"li" . $project_id . "\");\n";
              echo "      doc.parentNode.removeChild(doc);\n";
              echo "    </script>\n";
            }
          } else {
            $alert_msg = "Project  \\\"" . $project_name . "\\\" cannot be deleted!\\nProject still has " .
                         $num_docs . " documents(s). Delete all project documents before deleting this project.";
          }
        } else {
          $alert_msg = "Project \\\"" . $project_id . "\\\" not found!";
        }
        $result1->free();
        $mysqli->close();
      }
      if ($alert_msg != "") {
        echo "    <script>\n";
        echo "      alert(\"".$alert_msg."\");\n";
        echo "      window.history.back();\n";
        echo "    </script>\n";
      }
?>
  </body>
</html>