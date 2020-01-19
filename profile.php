<?php
include'classes/header.php';
?>
<title>Профиль пользователя</title>
          <? if(isset($_SESSION['user_logs'])) : ?>
        <main class="py-4">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                          <?if(isset($_SESSION['profile_success'])) : ?>
                          <div class="alert alert-success" role="alert">
                            <?=$_SESSION['profile_success'];?>
                          </div>
                        <? endif;
                        ?>

                            <form action="backend/profile.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control <?php if(isset($_SESSION['profile_login'])) echo 'is-invalid';?>" name="login" id="exampleFormControlInput1" value="<?=$_SESSION['user_logs']['login'];?>">
                                            <span class="text text-danger"><?=$_SESSION['profile_login']; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="" class="form-control <?php if(isset($_SESSION['profile_email'])) echo 'is-invalid';?>" name="email" id="exampleFormControlInput1" value="<?=$_SESSION['user_logs']['email'];?>">
                                            <span class="text text-danger"><?=$_SESSION['profile_email']; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="img" id="exampleFormControlInput1">
                                            <span class="text text-danger"><?=$_SESSION['profile_img']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="<?=$_SESSION['user_logs']['avatars']?>" alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" name="profile_red" class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                            <?
                            unset($_SESSION['profile_success']);
                            unset($_SESSION['profile_login']);
                            unset($_SESSION['profile_email']);
                            unset($_SESSION['profile_img']);
                             ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                          <?if(isset($_SESSION['profile_success_sec'])) : ?>
                          <div class="alert alert-success" role="alert">
                            <?=$_SESSION['profile_success_sec'];?>
                          </div>
                        <? endif;
                        ?>

                            <form action="backend/profile.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Текущий пароль</label>
                                            <input type="password" name="current" class="form-control <?php if(isset($_SESSION['profile_login'])) echo 'is-invalid';?>" id="exampleFormControlInput1">
                                            <span class="text text-danger"><?=$_SESSION['profile_pwd_t']; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Новый пароль</label>
                                            <input type="password" name="password" class="form-control <?php if(isset($_SESSION['profile_login'])) echo 'is-invalid';?>" id="exampleFormControlInput1">
                                            <span class="text text-danger"><?=$_SESSION['profile_pwd']; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Подтвердите новый пароль</label>
                                            <input type="password" name="password_confirmation" class="form-control <?php if(isset($_SESSION['profile_login'])) echo 'is-invalid';?>" id="exampleFormControlInput1">
                                            <span class="text text-danger"><?=$_SESSION['profile_pwd_conf']; ?></span>
                                        </div>

                                        <button class="btn btn-success" name="password_r">Submit</button>
                                    </div>
                                </div>
                              <?
                              unset($_SESSION['profile_success_sec']);
                              unset($_SESSION['profile_pwd_t']);
                              unset($_SESSION['profile_pwd']);
                              unset($_SESSION['profile_pwd_conf']);
                               ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
        <?
        else :
         ?>
         <script type="text/javascript">
           document.location.replace("/index.php");
         </script>
         <?
          endif;
          ?>

    </div>
</body>
</html>
