<?php
include'classes/header.php';
?>
<title>Главная страница</title>
     <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>


                                  <div class="card-body">
                              <?php if(isset( $_SESSION['komments_error'] )) :?>
                              <div class="alert alert-success" role="alert">
                              <?=$_SESSION['komments_error'];?>
                              <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                              </div>
                              <?php
                               unset($_SESSION['komments_error']);
                               endif;

                              $sql_comment = $pdo->query("SELECT c.id, c.user_id, c.comment, c.time, u.login, u.avatars from comments c INNER JOIN users u on c.user_id = u.id AND c.value = 0 order by c.id desc limit 5");
                             ?>
                             <?php
                             while ($sql_comments = $sql_comment->fetch(PDO::FETCH_ASSOC)) {
                             	?>
                                <div class="media">
                                  <img src="<?=$sql_comments['avatars'];?>" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"><?=$sql_comments['login'];?></h5>
                                    <span><small><?=$sql_comments['time'];?></small></span>
                                    <p>
                                     <?=$sql_comments['comment'];?>
                                    </p>
                                  </div>
                                  <? if($sql_comments['user_id'] == $_SESSION['user_logs']['id']) : ?>
                                  <button type="button" class="close" aria-label="Close">
                                <a href="/backend/admin.php?MyComDel=<?=$sql_comments['id']?>" style="text-decoration: none;" title="Удалить комментарий" aria-hidden="true">×</a>
                            </button>
                          <? endif; ?>
                                </div>
                                <?
                				        }
                				        ?>
                            </div>
                        </div>
                    </div>
                    <? if(isset($_SESSION['user_logs'])) : ?>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            <div class="card-body">
                                <form action="backend/post.php" method="POST">
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="comment" class="form-control"   id="exampleFormControlTextarea1" rows="3"></textarea>
                                  </div>
                                  <button type="submit" name="do_submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <? else : ?>

                      <div class="col-md-12" style="margin-top: 20px;">
                    <div class="alert alert-success" role="alert"><center><a href="/login.php">Авторизуйтесь</a>, чтобы добавлять комментарии</center></div>
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            <div class="card-body">
                                <form action="backend/post.php" method="POST">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <input name="username" class="form-control" value="Авторизуйтесь, чтобы что-то написать.." disabled id="exampleFormControlTextarea1" />
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="comment" class="form-control" disabled id="exampleFormControlTextarea1" placeholder="Вы не авторизованы.." rows="3"></textarea>
                                  </div>
                                  <button type="submit" name="do_submit" class="btn btn-success" disabled>Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                  <? endif; ?>
<?php
include'classes/footer.php';
?>
