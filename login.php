<?php
include'classes/header.php';

?>
<title>Авторизоваться</title>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Авторизация</div>

                            <div class="card-body">
                                <form method="POST" action="backend/auth.php">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">Ваш Email</label>
                                        <div class="col-md-6">
                                            <input id="email" type="" class="form-control <? if(isset( $_SESSION['auth_session'] ))  echo 'is-invalid'; ?>" name="email"  autocomplete="email" autofocus >
                                            <? if(isset( $_SESSION['auth_session'] )) :  ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?=$_SESSION['auth_session'];?></strong>
                                                </span>
                                                <?
                                                unset($_SESSION['auth_session']);
                                                endif;
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password"  autocomplete="current-password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" >

                                                <label class="form-check-label" for="remember">
                                                    Запомнить меня
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit"  name="go_auth" class="btn btn-primary">Войти</button>
                                        </div>
                                    </div>
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
