<?php
include'classes/header.php';
?>
<title>Регистрация</title>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Регистрация</div>

                            <div class="card-body">
                                <form method="POST" action="backend/reg.php">

                                    <?php if(isset($_SESSION['reg_session'])) : ?>
                                  <div class="alert alert-success" role="alert"><?=$_SESSION['reg_session'];?></div>
                                  <?php
                                    endif;
                                    ?>
                                    <div class="form-group row">
                                        <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                                        <div class="col-md-6">
                                            <input id="login" type="text" class="form-control <?php if(isset($_SESSION['reg_session_login'])) echo 'is-invalid';?>" value="<?=$_SESSION['login'];?>" name="login" autofocus>
                                            <?php if(isset($_SESSION['reg_session_login'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['reg_session_login'];?></strong>
                                                </span>
                                        <?
                                        endif;
                                        ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">Ваш Email адрес</label>

                                        <div class="col-md-6">
                                            <input id="email" class="form-control <?php if(isset($_SESSION['reg_session_email'])) echo 'is-invalid';?>" value="<?=$_SESSION['email'];?>" name="email" >
                                             <?php if(isset($_SESSION['reg_session_email'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['reg_session_email'];?></strong>
                                                </span>
                                        <?
                                        endif;
                                        ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control <?php if(isset($_SESSION['reg_session_password'])) echo 'is-invalid';?>" value="<?=$_SESSION['password'];?>" name="password"  autocomplete="new-password">
                                            <?php if(isset($_SESSION['reg_session_password'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['reg_session_password'];?></strong>
                                                </span>
                                        <?
                                        endif;
                                        ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password_confirm" class="col-md-4 col-form-label text-md-right">Подтвердите пароль</label>

                                        <div class="col-md-6">
                                            <input id="password_confirm" type="password" class="form-control <?php if(isset($_SESSION['reg_session_password'])) echo 'is-invalid';?>" name="password_confirmation"  autocomplete="new-password">
                                            <?php if(isset($_SESSION['reg_session_password'])) : ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['reg_session_password'];?></strong>
                                                </span>
                                        <? endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" name="do_signup" class="btn btn-primary">Зарегистрироваться</button>
                                        </div>
                                    </div>
                                    <?php
                                    unset($_SESSION['reg_session']);
                                    unset($_SESSION['reg_session_login']);
                                    unset($_SESSION['reg_session_email']);
                                    unset($_SESSION['reg_session_password']);

                                    unset($_SESSION['login']);
                                    unset($_SESSION['email']);
                                    unset($_SESSION['password']);
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
