<?php
  $id = $_GET['id']
?>

<html>
<head>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<script src="js/datetimepicker.js"></script>

<script type="text/javascript">
  var project_id = <?php echo $id;?>;
  var sessions;
  $(document).ready(function(){
    getSessions(project_id, function(sess){
      console.log(sess)
      sessions = sess;
      $.each(sess, function(i, s){
        if (s.notes == null)
          s.notes = ""
        $("#sessions").
        append("<li><a href='session.php?id=" + s.id + "'>" + s.timestamp + " " + s.notes + "</a><br/></li>");
      })
    })

    $("#submit").click(function(){
      if ($("#time").val().trim() == "")
        return;
      time = timeToDB($("#time").val())
      query = "INSERT INTO session (project_id, timestamp, notes)  VALUES (" + project_id + ", '" + 
        time + "', '" + 
        $("#notes").val() + "')";
      console.log(query);
      doUpdate(query, function(data){
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
Sessions for Project <?php echo $id;?>
<p></p>
<div><ol id="sessions"></ol></div>
<p></p>
Add new session
<form>
  Date/Time: <input id="time" type="text" size="25">
  <a href="javascript:NewCal('time','ddmmyyyy',true,24)">
  <img src="img/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
  <br />
  Notes: <textarea rows='4' cols='50' id="notes"></textarea><br />
  <button type="button" id="submit">Submit</button>
</form>

</body>