<?php
namespace classes;
use backend\AdminClass;
require_once '../classes/database.php';

echo "<table width=100% height=100%><tr><td width=200 valign=top>
<a href='?action=nowplaying'><div class='menu'>Online</div></a>
<a href='?action=settings'><div class='menu'>Settings</div></a>
";

switch ($_GET['action']) {
  case 'nowplaying':
    nowplaying();
    break;
    case 'settings':
    settings();
    break;
    default :
    echo "Nothing found";
    break;
}

function nowplaying()
{
echo "Hello world";
}
function settings() {

  echo "Settings start!";
}

$view = new AdminClass;
$view->checkSQL();
 ?>
