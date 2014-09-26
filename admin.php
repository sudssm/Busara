<html>
<head></head>
<body>
<?php
  $pw = "admin";

  session_start();
  if(isset($_GET["origin"]))
    $_SESSION["origin"] = $_GET["origin"];
  if (!isset($_POST["pw"])){
    echo "Please provide admin credentials to access this page.";
  }
  else if ($_POST['pw'] == $pw){
    $_SESSION['admin']=true;
    echo $_SESSION['origin'];
    header( 'Location: ' . $_SESSION["origin"] ) ;
  }
  else{
    echo "<span style='color:red'>Invalid Password!</span>";
  }
?>

<form action='admin.php' method='post'>
  Password: <input name='pw' type='password'>
</form>
</body>
</html>