<!DOCTYPE html>
<html>
  <head>
    <title>My Documents</title>
    <script>
      function receiveMessage(evt) {
        if (evt.origin == 'http://localhost')
        {
          var action = evt.data.split(":")[0];
          var par1 = evt.data.split(":")[1];
          var par2 = evt.data.split(":")[2];
          var par3 = evt.data.split(":")[3];
          if (action == "displayDocument") {
            var proj = document.getElementById("p" + par1 );
            var doc = document.createElement("li");
            doc.id = "d" + par2;
            doc.addEventListener("click", function() {displayDocument(par1, par2);});
            doc.appendChild(document.createTextNode(par3));
            var i = 0;
//            var nodeList = "";
//            while ( i < proj.children.length ) {
//              nodeList = nodeList + ":" + proj.children[i].nodeName + "-" + proj.children[i].textContent;
//              i++;
//            }
//            alert ("Inserting " + evt.data + " document into " + nodeList);
//            i = 0;
            while ( i < proj.children.length ) {
              if ( proj.children[i].textContent > par3 ) break;
              i++;
            }
//            alert ("Inserting document for " + proj.parentElement.childNodes[0].nodeValue + "(pos=" + i + " of " + proj.children.length + ")");
            if ( i >= proj.children.length ) proj.appendChild(doc);
            else proj.insertBefore(doc, proj.children[i]);
            displayDocument(par1, par2);
          }
          if (action == "displayProject") {
            var projList = document.getElementById("pl" );
            var proj = document.createElement("li");
            proj.className = "proj";
            proj.id = "li" + par1;
            proj.addEventListener("click", function() {displayProject(par1, par2);});
            proj.addEventListener("dblclick", function() {toggleProject(par1, par2);});
            proj.appendChild(document.createTextNode(par3));
            var docList = document.createElement("ul");
            docList.className = "exp";
            docList.id = "p" + par1;
            proj.appendChild(docList);
            var i = 0;
            while ( i < projList.childNodes.length ) {
              if ( projList.childNodes[i].textContent > par3 ) break;
              i++;
            }
            if ( i >= projList.childNodes.length ) projList.appendChild(proj);
            else projList.insertBefore(proj, projList.childNodes[i]);
            displayProject(par1, par2);
          }
        }
      }
      function doAction() {
        document.getElementById("iframe_proj").style.height = "250px";
        document.getElementById("iframe_doc").style.display = "";
        var val = document.getElementById("action").value;
        document.getElementById("action").selectedIndex = 0;
        if(val == "AC")      addClient();
        else if(val == "AD") addDocument();
        else if(val == "AP") addProject();
        else if(val == "AT") addDocType();
        else if(val == "LC") listClients();
        else if(val == "LT") listDocTypes();
      }
      function displayProject(ProjectId, ClientId) {
        document.getElementById("iframe_proj").style.height = "250px";
        document.getElementById("iframe_doc").style.display = "";
        target = document.getElementById("li"+ProjectId);
        target.style.listStyleType = "circle";
        target = document.getElementById("p"+ProjectId);
        target.style.display = "";
        clearAllBold("li");
        setBold("li"+ProjectId);
        document.getElementById("iframe_proj").src = "project.php?project="+ProjectId;
        document.getElementById("iframe_doc").src = "";
      }
      function displayDocument(ProjectId, DocumentId) {
        document.getElementById("iframe_proj").style.height = "250px";
        document.getElementById("iframe_doc").style.display = "";
        clearAllBold("li");
        setBold("li"+ProjectId);
        setBold("d"+DocumentId);
        document.getElementById("iframe_proj").src = "project.php?project="+ProjectId;
        document.getElementById("iframe_doc").src = "document.php?document="+DocumentId;
      }
      function expandAll() {
        var myNodelist = document.getElementsByClassName("exp");
        var i;
        for (i = 0; i < myNodelist.length; i++) {
          myNodelist[i].style.display = "";
        }
        myNodelist = document.getElementsByClassName("proj");
        for (i = 0; i < myNodelist.length; i++) {
          myNodelist[i].style.listStyleType = "circle";
        }
      }
      function collapseAll() {
        var myNodelist = document.getElementsByClassName("exp");
        var i;
        for (i = 0; i < myNodelist.length; i++) {
          myNodelist[i].style.display = "none";
        }
        myNodelist = document.getElementsByClassName("proj");
        for (i = 0; i < myNodelist.length; i++) {
          myNodelist[i].style.listStyleType = "disc";
        }
      }
      function toggleProject(ProjectId, ClientId) {
        target = document.getElementById("li"+ProjectId);
        if (target.style.listStyleType == "circle"){
          target.style.listStyleType = "disc";
          target = document.getElementById("p"+ProjectId);
          target.style.display = "none";
        } else {
          displayProject(ProjectId, ClientId);
        }
      }
      function addClient() {
        document.getElementById("iframe_proj").style.height = "500px";
        document.getElementById("iframe_doc").style.display = "none";
        document.getElementById("iframe_proj").src = "edit_client.php?client=0&return_url=list_clients.php";
        document.getElementById("iframe_doc").src = "";
      }
      function addProject() {
        document.getElementById("iframe_proj").src = "edit_project.php?project=0";
        document.getElementById("iframe_doc").src = "";
      }
      function addDocument() {
        document.getElementById("iframe_doc").src = "edit_document.php?document=0&project=0";
      }
      function addDocType() {
        document.getElementById("iframe_proj").style.height = "500px";
        document.getElementById("iframe_doc").style.display = "none";
        document.getElementById("iframe_proj").src = "edit_doctype.php?doctype=0&return_url=list_doctypes.php";
        document.getElementById("iframe_doc").src = "";
      }
      function listClients() {
        document.getElementById("iframe_proj").style.height = "500px";
        document.getElementById("iframe_doc").style.display = "none";
        document.getElementById("iframe_proj").src = "list_clients.php";
        document.getElementById("iframe_doc").src = "";
      }
      function listDocTypes() {
        document.getElementById("iframe_proj").style.height = "500px";
        document.getElementById("iframe_doc").style.display = "none";
        document.getElementById("iframe_proj").src = "list_doctypes.php";
        document.getElementById("iframe_doc").src = "";
      }
      function clearAllBold(tagType) {
        var myNodelist = document.getElementsByTagName(tagType);
        var i;
        for (i = 0; i < myNodelist.length; i++) {
          myNodelist[i].style.fontWeight = "normal";
        }
      }
      function setBold(targetId) {
        target = document.getElementById(targetId);
        target.style.fontWeight = "bold";
      }
      function toggleStyle(targetId){
        target = document.getElementById(targetId);
        if (target.style.listStyleType == "circle"){
            target.style.listStyleType = "disc";
        } else{
            target.style.listStyleType = "circle";
        }
      }
      function toggleDisplay(targetId){
        target = document.getElementById(targetId);
        if (target.style.display == "none"){
            target.style.display = "";
        } else{
            target.style.display = "none";
        }
      }
    </script>
    <style>
      html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }
      iframe {
        width:100%;
        float:left;
        padding:10px;	
        border-style:none; 	 
      }
      #nav {
        width: 25%;
        height: 99%;
        float:left;
        margin: 0;
        padding: 0;
        background-color: lightgrey;
      }
      #project {
        width: 100%;
        height: 90%;
        float:left;
        margin: 0;
        padding: 0;
        background-color: lightgrey;
      }
      #section {
        width:70%;
        height: 90%;
        float:left;
        padding:10px;	 	 
      }
    </style> 
  </head>
  <body>
    <div id="nav" style="overflow:visible">
      <h1>Documents by Project</h1>
      <button onclick='expandAll()'>Expand All</button>
      <button onclick='collapseAll()'>Collapse All</button>
      <select name="Action" id="action" onChange="doAction()">
        <option selected="selected">Action Menu</option>
        <option value="AC">Add Client</option>
        <option value="LC">List Clients</option>
        <option value="AT">Add Document Type</option>
        <option value="LT">List Document Types</option>
        <option value="AP">Add Project</option>
        <option value="AD">Add Document</option>
      </select>
      <div id="project" style="overflow:auto">
        <ul style="list-style-type:disc" id=pl> 
<?php
    $action = "0";
    if (isset($_GET['action'])) $action = $_GET['action'];
    $project = 0;
    if (isset($_GET['project'])) $project = $_GET['project'];
    $document = 0;
    if (isset($_GET['document'])) $document = $_GET['document'];
    $mysqli = new mysqli("localhost", "Lynn", "lynn", "cms");
    if ($mysqli->connect_errno) {
      die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }
    $sql1 = "select p.project_id, p.project_name, c.client_short_name, c.client_id ".
            "from project p, client c ".
            "where p.client_id = c.client_id ".
            "order by binary client_short_name, binary project_name";
    if (!$result1 = $mysqli->query($sql1)) {
      die('There was an error running the query [' . $mysqli->error . ']');
    }
    while ($row1 = $result1->fetch_assoc()) {
      $proj_id = $row1['project_id'];
      $proj_name = $row1['project_name']; 
      $client_name = $row1['client_short_name'];
      $client_id = $row1['client_id'];
      echo "          <li class=\"proj\" id=li" . $proj_id;
      if ($proj_id == $project) {
        echo " style=\"listStyleType:circle;font-weight:bold\"";
        $client = $client_id;
      } 
      echo " ondblclick=\"toggleProject(" . $proj_id . "," . $client_id . ")\"";
      echo " onclick='displayProject(\"" . $proj_id . "\",\"" . $client_id . "\")'>";
      echo $client_name . " - " . $proj_name . "</li>\n";
      $sql2 = "select document_id, document_name, document_location ".
              "from document ".
              "where project_id = " . $proj_id . " ".
              "order by binary document_name";
      if (!$result2 = $mysqli->query($sql2)) {
        die('There was an error running the query [' . $mysqli->error . ']');
      }
      if ($proj_id == $project) {
        echo "            <ul class=\"exp\" id=p" . $proj_id . ">\n";
      } else {
        echo "            <ul class=\"exp\" style=\"display:none\" id=p" . $proj_id . ">\n";
      }
      while ($row2 = $result2->fetch_assoc()) {
        $doc_id = $row2['document_id'];
        $doc_name = $row2['document_name'];
        echo "              <li id=d" . $doc_id ;
        if ($doc_id == $document) {
          echo " style=\"font-weight:bold\"";
          $project = $proj_id;
        } 
        echo " onclick='displayDocument(\"" . $proj_id . "\",\"" . $doc_id . "\")'>";
        echo $doc_name . "</li>\n";
      }
      echo "            </ul>\n";
      $result2->free();
    }
    $result1->free();
    $mysqli->close();
?> 
        </ul>
      </div>
    </div>
    <div id="section">
      <iframe id="iframe_proj" height="200"></iframe>
      <iframe id="iframe_doc" height="260"></iframe>
    </div>
<?php
    echo "      <script>\n";
    echo "        window.addEventListener('message', receiveMessage, false);\n";
    if ($action != "0") {
      echo "        document.getElementById(\"action\").value = \"" . $action . "\";\n";
      echo "        doAction();\n";
    } else if ($document != 0) {
      echo "        displayDocument(".$project . ", " . $document.");\n";
    } else if ($project != 0) {
      echo "        displayProject(".$project . ", " . $client.");\n";
    }
    echo "      </script>";
?> 
  </body>
</html>