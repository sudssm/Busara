<?php
  $project = empty($_GET['project']) ? "0" : $_GET['project'];
  $session = empty($_GET['session']) ? "0" : $_GET['session'];
?>

<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<script src="js/datetimepicker.js"></script>

<script type="text/javascript">
  var session_id = <?php echo $session;?>;
  var project_id = <?php echo $project;?>;
  var sessions;
  var surveys;
  $(document).ready(function(){
    getProjects(function(proj){
      $.each(proj, function(i, p){
        $("#projects").append("<option value='" + p.id + "'>" + p.name + "</option>");
      })
      $('#projects').val(project_id).change();
    })

    $("#projects").change(function() {
      $("#sessions").empty();
      getSessions($(this).val(), function(data){
        $.each(data, function(i, s){
          $("#sessions").append("<option value='" + s.id + "'>" + s.timestamp + "</option>");
        })
        $("#sessions").val(session_id)
      })
    })

    $("#submit").click(function(){
      num = parseInt($("#count").val())
      if (isNaN(num))
        return
      getSurveys(function(surveys){ 
        selections = []
        for (var i = 0; i < num && surveys.length > 0; i++){
          var index = Math.floor(Math.random()*surveys.length)
          selections.push(surveys.splice(index)[0]);
        }
        console.log(selections)
        var query = "INSERT INTO participation (survey_id, session_id, invited) VALUES "
        $.each(selections, function(i,s){
          query = query + "(" + s + "," + session_id + ",1), "
        })
        console.log(query)
        doUpdate(query.substring(0,query.length-2), function (data){
          if(isNaN(data)){
            console.log(data)
          }
          else{
            location.reload();
          }
        })
      })
    })
  })

</script>
</head>
<body>
Invite Participants<br/>
Project: <select id="projects"><option></option></select><br/>
Session: <select id="sessions"></select><br/>
Participant Count: <input id="count"><br/>
<button type="button" id="submit">Submit</button>

<p></p>
<div id="surveys"></div>
</body>