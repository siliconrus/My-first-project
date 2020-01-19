<?php
/* ВЫХОД ИЗ СИСТЕМЫ */

require ("../classes/database.php");

unset($_SESSION['user_logs']);
?>

<script type="text/javascript">
  document.location.replace("/index.php");
</script>
