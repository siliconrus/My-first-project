<?php
ob_start();
include'classes/header.php';

// ini_set('display_errors', 1);
// echo "<pre>";
// error_reporting(E_ALL);


$title = 'Панель администратора';

$id = $_SESSION['user_logs']['id'];

$sql = 'SELECT is_admin FROM users WHERE id = :id';
$params = [':id' => $id];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if($admin) {

  $_SESSION['admin'] = $admin;
}

if( ($_SESSION['user_logs']) && ($_SESSION['admin']['is_admin']) == 1) :

?>
<title>Панель администратора</title>


        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>
                            <?php if(isset( $_SESSION['admin_succ'] )) :?>
                            <div class="alert alert-success" role="alert">
                            <?=$_SESSION['admin_succ'];?>
                            <button type="button" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                          </button>
                            </div>
                            <?php
                             unset($_SESSION['admin_succ']);
                             endif;
                             ?>
                            <?php
                             $admin_komment = $pdo->query("SELECT c.id, c.user_id, c.comment, c.time, c.value, u.login, u.avatars from comments c LEFT JOIN users u on c.user_id = u.id order by c.id desc");

                            ?>
                            <a href="#" class="button16">кнопка</a>
                            <a href="#" class="button16">кнопка1</a>
                            <a href="#" class="button16">кнопка2</a>
                            <a href="#" class="button16">кнопка</a>


                            <ul class="hr">
                               <a href="/admin.php?action=users">Пользователи</a>
                               <a href="/admin.php?action=index">Index</a>
                               <a href="#" class="button16">кнопка</a>
                               <li>Пахлава</li>
                               <li>Кчуч</li>
                              <a href="/admin.php?action=bans">Бан-лист</a>
                            </ul>

                              <?
                              switch ($_GET['action']) :
                                case 'users':
                                  $sql = $pdo->query('SELECT * FROM users'); ?>

                                  <div class='card-body'>
                                      <table class='table'>
                                          <thead>
                                              <tr>
                                                  <th>Аватар</th>
                                                  <th>Имя</th>
                                                  <th>Емейл</th>
                                                  <th>IP</th>
                                                  <th>Действия</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?
                                             while($users = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                                              <tr>
                                                  <td>
                                                      <img src='<?=$users['avatars'];?>' alt='' class='img-fluid' width='64' height='64'>
                                                  </td>
                                                  <td><?=$users['login'];?></td>
                                                  <td><?=$users['email'];?></td>
                                                  <td><?=$users['ip'];?></td>
                                                  <td>
                                                    <a href="/backend/admin.php?ChatBan=<?=$users['id'];?>&type=1" class="btn btn-dark">Бан в чате</a>
                                                    <a href="/backend/admin.php?ChatBan=<?=$users['id'];?>&type=2" class="btn btn-dark">Бан на сайте</a>
                                                  </td>

                                                <?
                                                 //if($_GET['action'] == "test") {test();}

                                                }

                                                ?>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>

                                  <?
                                  break;

                                  case 'bans':
                                  $check_ban = $pdo->query("SELECT b.id, b.user_id, b.cause, b.type, b.data_end, u.login, u.avatars, u.email, u.ip
                                    from ban_list b LEFT JOIN users u on b.user_id = u.id order by b.id desc");

                                    $per_page = 5;
                                    $page = 1;

                                    if(isset($_GET['page'])) {

                                      $page = $_GET['page'];
                                    }

                                     ?>

                                    <div class='card-body'>
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <th>Аватар</th>
                                                    <th>Имя</th>
                                                    <th>Причина</th>
                                                    <th>Тип бана</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?
                                               while($banList = $check_ban->fetch(PDO::FETCH_ASSOC)) {

                                                 if($banList['type'] == '1') $where_ban = 'ЧАТ';
                                                 elseif($banList['type'] == '2') $where_ban = 'ПРИЛОЖЕНИЕ';
                                                 else $where_ban = 'NAN';

                                                 ?>
                                                <tr>
                                                    <td>
                                                        <img src='<?=$banList['avatars'];?>' alt='' class='img-fluid' width='64' height='64'>
                                                    </td>
                                                    <td><?=$banList['login'];?></td>
                                                    <td><?=$banList['cause'];?></td>
                                                    <td><?=$where_ban;?></td>
                                                    <td>
                                                      <a href="/backend/admin.php?DelChatBan=<?=$banList['id'];?>" class="btn btn-dark">Разбанить</a>
                                                    </td>

                                                  <?

                                                  }

                                                  ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?
                                    break;

                                  default:
                                  ?>
                                  <div class="card-body">
                                      <table class="table">
                                          <thead>
                                              <tr>
                                                  <th>Аватар</th>
                                                  <th>Имя</th>
                                                  <th>Дата</th>
                                                  <th>Комментарий</th>
                                                  <th>Действия</th>
                                              </tr>
                                          </thead>
                                          <?
                                          while ($admin_komments =$admin_komment->fetch(PDO::FETCH_ASSOC)) {
                                        //foreach ($admin_komment as $admin_komments) {
                                          ?>
                                          <tbody>
                                              <tr>
                                                  <td>
                                                      <img src="<?=$admin_komments['avatars'];?>" alt="" class="img-fluid" width="64" height="64">
                                                  </td>
                                                  <td><?=$admin_komments['login'];?></td>
                                                  <td><?=$admin_komments['time'];?></td>
                                                  <td><?=$admin_komments['comment'];?></td>
                                                  <td>
                                                    <?
                                                    if($admin_komments['value'] == 1 ) :
                                                    ?>
                                                          <a href="/backend/admin.php?valueOne=<?=$admin_komments['id']?>" class="btn btn-success">Разрешить</a>
                                                    <? else: ?>
                                                          <a href="/backend/admin.php?valueTwo=<?=$admin_komments['id']?>" class="btn btn-warning">Запретить</a>
                                                    <? endif; ?>
                                                    <? //$delete = new Admin; ?>
                                                      <a href="/backend/AdminClass.php?delete=<?=$admin_komments['id']?>" onclick="return confirm('Вы действительно хотите удалить этот комментарий?')" class="btn btn-danger">Удалить</a>
                                                      <!--<a href="/backend/admin.php?ChatBan=<?=$admin_komments['id'];?>" class="btn btn-dark">Забанить в чате</a>-->

                                                  </td>
                                              </tr>
                                          </tbody>
                                            <?php } ?>
                                      </table>
                                  </div>
                                  <?
                                  break;
                                endswitch;
                                  ?>

                                  <?php
                                  function test() {

                                    echo "Lol";
                                  }

                                   ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
      <?php else :

        header('Location: /');

      endif;
        ?>
    </div>
</body>
</html>
