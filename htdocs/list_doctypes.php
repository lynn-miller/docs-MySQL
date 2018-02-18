<!DOCTYPE html>
<html>
  <head>
    <title>Document Types</title>
    <script>
      function confirmDelete() {
        if (confirm("Press \"OK\" to delete this document type")) {
          return true;
        }
        return false;
      }
      function addDocType() {
        location.assign("edit_doctype.php?doctype=0&return_url=list_doctypes.php");
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
    <h2>Document Types</h2>
    <button onclick='addDocType()'>New Document Type</button>
    <p/>
    <form action="edit_doctype.php" name="Update DocType">
      <table>
        <tr><th></th><th>Document Type</th><th>Open With</th></tr>
<?php 
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
      $sql1 = "select document_type_id, document_type, open_with ".
              "from document_type ".
              "order by document_type ";
      if (!$result1 = $mysqli->query($sql1)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      while ($doctype = $result1->fetch_assoc()) {
        echo "       <tr>\n";
        echo "         <td><input type=\"radio\" name=\"doctype\" value=\"" . $doctype['document_type_id'] . "\" required></td>\n";
        echo "         <td>" . $doctype['document_type'] . "</td>\n";
        echo "         <td>" . $doctype['open_with'] . "</td>\n";
        echo "       </tr>\n";
      }
      $result1->free();
      $mysqli->close();
?>
      </table>
      <p></p>
      <input type="submit" value="Edit">
      <input type="submit" value="Delete" formaction="del_doctype.php" onclick="return confirmDelete()">
    </form>
  </body>
</html>