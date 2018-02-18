<!DOCTYPE html>
<html>
  <head>
    <title>Project Documents</title>
    <script>
      function editDocument(DocumentId) {
        location.assign("edit_document.php?document="+DocumentId);
      }
      function viewDocument(documentName, openWith) {
        alert("Copy the following text and paste into a command window to view or edit the document:\n\"" + openWith + "\" \"" + documentName + "\"");
      }
      function delDocument(DocumentId, DocumentName) {
        if (confirm("Press \"OK\" to delete this document")) {
          location.assign("del_document.php?document="+DocumentId+"&doc_name="+DocumentName);
        }
      }
    </script>
  </head>
  <body>
<?php 
      $document_id = $_GET['document'];
      $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
      if ($mysqli->connect_errno) {
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
      }
        $sql1 = "select d.document_id, d.project_id, d.document_name, ".
                "d.document_description, d.document_location, t.document_type, t.open_with ".
                "from document d, document_type t ".
                "where document_id = ".$document_id.
                "  and t.document_type_id = d.document_type_id";
      if (!$result1 = $mysqli->query($sql1)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      if ($document = $result1->fetch_assoc()) {
        echo "    <h2>Document Details</h2>\n";
        echo "    <table>\n";
        echo "      <tr><td>Document: </td><td>" . $document['document_name'] . "</td></tr>\n";
        echo "      <tr><td>Description: </td><td>" . $document['document_description'] . "</td></tr>\n";
        echo "      <tr><td>Location: </td><td>" . $document['document_location'] . "</td></tr>\n";
        echo "      <tr><td>Document type: </td><td>" . $document['document_type'] . "</td></tr>\n";
        echo "      <tr><td>Open using: </td><td>" . $document['open_with'] . "</td></tr>\n";
        echo "    </table>\n";
        echo "    <p></p>\n";
        echo "    <button onclick='editDocument(" . $document_id . ")'>Edit Document Details</button>\n";
        echo "    <button onclick='viewDocument(\"" . addslashes($document['document_location']) . "\", \"" . addslashes($document['open_with']) . "\")'>View or Edit Document</button>\n";
        echo "    <button onclick='delDocument(" . $document_id . ", \"" . $document['document_name'] . "\")'>Delete Document Details</button>\n";
      } else {
        echo "    <script>\n";
        echo "      alert(\"Document ".$document_id." not found!\");\n";
        echo "      window.history.back();\n";
        echo "    </script>\n";
      }
      $result1->free();
      $mysqli->close();
?>
  </body>
</html>
