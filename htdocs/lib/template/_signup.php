<?php
include_once "lib/load.php";
$result=false;
$signup=false;
$error=false;
if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['phone']) and isset($_POST['pass'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $pass=$_POST['pass'];
    $result=true;
    $signup=user::signup($name,$email,$phone,$pass);
}
if($result){
  if($signup){
    ?><script>window.location.href="/signup_success.php"</script><?php
  }else{
    $error=true;
  }
}
  ?>
  <center> 
<main class="form-signin w-100 m-auto">
  <form action="signup.php" method="post">
    <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign Up</h1>
    <div class="form-floating">
      <input name="name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input name="phone" type="tel" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Phone NO</label>
    </div>
    <div class="form-floating">
      <input name="pass" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <?php
    if($error){
      ?><p style="color: red;">This username is already exist</p><?php
    }
    ?>
    <button class="btn btn-primary w-100 py-2" type="submit">Sign Up</button>
    <p style="margin-top: 15px;">If you have an account please <a href="/login.php">Login</a></p>
</form>
</main>
</center>
 
