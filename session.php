<?php
  $id = $_GET['id']
?>

<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<script src="js/datetimepicker.js"></script>

<script type="text/javascript">
  var session_id = <?php echo $id;?>;
  var project_id;
  var sessions;
  var surveys;
  var invited = []
  var participated = []

  function showInvited(){
    showList(invited)
  }
  function showParticipated(){
    showList(participated)
  }
  function showList(list){
    $("#surveys").empty();
    var str="<table><tr><th>Payout</th><th>First Name</th><th>Last Name</th></tr>";
    $.each(list, function(i, x){
      if (x.pay == null)
        x.pay = ""
      str=str+"<tr><td>"+x.pay+"</td><td>"+x.first_name+"</td><td>"+x.last_name+"</td></tr>";
    })
    $("#surveys").append(str+"</table>");
  }

  $(document).ready(function(){

    doQuery("select project.name, project.id, timestamp from session, project where project.id = session.project_id and session.id = " + session_id,
      function(data){
        project_id = data[0].id;
        $("#project_name").html(data[0].name);
        $("#session_time").val(data[0].timestamp);
      })

    getSurveysBySession (session_id, function(s){
      surveys = s;
      $.each(surveys, function(i, s){
        if (s.invited==1)
          invited.push(s)
        if (s.particpated==1)
          participated.push(s)
      })
      if (invited.length == 0){
        $("#surveys").html("No participants invited. <a href='invite_list.php?project="
          + project_id + "&session=" + session_id + "'>Invite some!</a>")
      }
      else {
        showInvited()
      }
    })

    $("#submit").click(function(){
      if ($("#session_time").val().trim() == "")
        return;
      time = timeToDB($("#session_time").val())
      query = "UPDATE session SET timestamp='" + time + "' where session.id = " + session_id
      lUpdate(query, function(data){
        if (isNaN(parseInt(data))){
          console.log(data)
        }
        else {
          location.reload();
        }
      })
    })
  })

</script>
</head>
<body>
Sessions Information<br/>
Project: <span id='project_name'></span><br/>
Date/Time: <input id="session_time" type="text" size="25">
  <a href="javascript:NewCal('session_time','ddmmyyyy',true,24)">
  <img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
  <button type="button" id="submit">Submit</button>
  <br />

<p></p>
Show <a href='javascript:showInvited()'>Invited</a> <a href='javascript:showParticipated()'>Participated</a>
<div id="surveys"></div>
</body>