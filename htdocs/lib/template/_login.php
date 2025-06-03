<?php
include_once "lib/load.php";
$login=false;
$result=false;
$error=false;
if(isset($_POST['name']) and isset($_POST['pass'])){
  $name=$_POST['name'];
  $pass=$_POST['pass'];
  $result=true;
  $login=auth::authenticate($name,$pass);
}
if($result){
  if($login){
    ?><script>
      window.location.href="/"
      </script><?php
  }else{
    $error=true;
  }
}
?>
<center> 
<main class="form-signin w-100 m-auto">
  <form action="login.php" method="post">
    <img class="mb-4" src="/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign In</h1>

    <div class="form-floating">
      <input name="name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input name="pass" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <?php
    if($error){
      ?><p style="color: red;">Invalid Username or Password</p><?php
    }
    ?>
    <button class="btn btn-primary w-100 py-2" type="submit">Sign In</button>
    <p style="margin-top: 15px;">Not register? please <a href="/signup.php">Signup</a></p>
  </form>
</main>
</center>