<!DOCTYPE html>
<html>
  <head>
    <title>List of Clients</title>
    <script>
      function confirmDelete() {
        if (confirm("Press \"OK\" to delete this client")) {
          return true;
        }
        return false;
      }
      function addClient() {
        location.assign("edit_client.php?client=0&return_url=list_clients.php");
      }
    </script>
    <style>
      table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: left;
      }
      th, td {
        padding: 3px;
      }
    </style>
  </head>
  <body>
    <h2>Client Details</h2>
    <button onclick='addClient()'>New Client</button>
    <p/>
    <form action="edit_client.php" name="Update Client">
      <input type="hidden" name="project_id" value="0">
      <table>
        <tr><th></th><th>Client Name</th><th>Short Name</th></tr>
<?php 
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      $sql1 = "select client_id, client_name, client_short_name ".
              "from client ".
              "order by client_name ";
      if (!$result1 = $mysqli->query($sql1)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      while ($client = $result1->fetch_assoc()) {
        echo "        <tr><td><input type=\"radio\" name=\"client\" value=\"" . $client['client_id'] . "\" required></td><td>" . $client['client_name'] . "</td><td>" . $client['client_short_name'] . "</td></tr>\n";
      }
      $result1->free();
      $mysqli->close();
?>
      </table>
      <p></p>
      <input type="submit" value="Edit">
      <input type="submit" value="Delete" formaction="del_client.php" onclick="return confirmDelete()">
      <input type="submit" value="New Project" formaction="edit_project.php">
    </form>
  </body>
</html>