<!DOCTYPE html>
<html>
  <head>
    <title>Project Documents</title>
    <script>
      function editClient(ClientId) {
        location.assign("edit_client.php?client="+ClientId);
      }
      function editProject(ProjectId) {
        location.assign("edit_project.php?project="+ProjectId);
      }
      function delProject(ProjectId) {
        if (confirm("Press \"OK\" to delete this project")) {
          location.assign("del_project.php?project="+ProjectId);
        }
      }
      function newDocument(ProjectId) {
        parent.document.getElementById("iframe_doc").src = "edit_document.php?document=0&project="+ProjectId;  
    }
    </script>
  </head>
  <body>
    <h2>Client and Project Details</h2>
<?php 
      $project_id = $_GET['project'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      $sql1 = "select p.project_id, p.project_name, c.client_id, c.client_name, c.client_short_name, ".
              "p.project_description, p.start_date, p.end_date ".
              "from project p, client c ".
              "where p.project_id = ".$project_id.
              "  and p.client_id = c.client_id ";
      if (!$result1 = $mysqli->query($sql1)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      if ($project = $result1->fetch_assoc()) {
        echo "    <table>\n";
        echo "      <tr><td>Client: </td><td>" . $project['client_name'] . " (" . $project['client_short_name'] . ")</td></tr>\n";
        echo "      <tr><td>Project: </td><td>" . $project['project_name'] . "</td></tr>\n";
        echo "      <tr><td>Description: </td><td>" . $project['project_description'] . "</td></tr>\n";
        echo "      <tr><td>Started: </td><td>" . $project['start_date'] . "</td></tr>\n";
        echo "      <tr><td>Finished: </td><td>" . $project['end_date'] . "</td></tr>\n";
        echo "    </table>\n";
        echo "    <p></p>\n";
        echo "    <button onclick='editClient(" . $project['client_id'] . ")'>Edit Client</button>\n";
        echo "    <button onclick='editProject(" . $project_id . ")'>Edit Project</button>\n";
        echo "    <button onclick='delProject(" . $project_id . ")'>Delete Project</button>\n";
        echo "    <button onclick='newDocument(" . $project_id . ")'>New Document</button>\n";
      } else {
        echo "    <p>Project ".$project_id." not found!</p>\n";
      }
      $result1->free();
      $mysqli->close();
?>
  </body>
</html>