<?php
  session_start();
  if (!isset($_SESSION['admin']))
    header( 'Location: admin.php?origin=demographic.php') ;
?>
<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var demographics;
  getDemographics(function(dems){
    demographics = dems;
    $.each(dems, function(i, dem){
      $("#dems").append(dem.name + "<br/>")
    })
  })
  $("#add").click(add)
})
function add (){
  if ($("#dem").val() == "")
    return

  newDemographic($("#dem").val(), $("#desc").val(), function(){
    location.reload();
  })
}


</script>
</head>
<body>
Add Demographic
<p></p>
Demographics:<br/>
<div id='dems'></div>
<p></p>
<form action="javascript:add()">
  Name:<input type="text" id="dem"><br/>
  Description:<textarea id="desc"></textarea>
  <button type="button" id="add">Add Demographic</button>
</form>

</body>