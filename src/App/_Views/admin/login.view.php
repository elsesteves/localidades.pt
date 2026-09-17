<!DOCTYPE html>
<html lang="pt" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="author" content="<?= SITE_CONFIGS['info']['author']['name'] ?>">
  <title>Backoffice | <?= SITE_CONFIGS['info']['name'] ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!--
  <link rel="shortcut icon" href="../resources/img/logos/favicon-3d.png">
  -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet"  type="text/css" href="<?= $site['baseURL'] ?>/assets/themes/admin/css/settings.css" />
  <link rel="stylesheet"  type="text/css" href="<?= $site['baseURL'] ?>/admin_old/login/resources/css/index.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>

  <form method="POST" id="login_form" action="<?= $site['baseURL'] ?>/admin/login" >
    <div class="login_form_wrap">
      <div id="login_form_title">ENTRAR</div>
      <div class="login_form_cont">
        <label for="logUsername">Email:</label>
        <input id="loguser" type="text" placeholder="Username" name="email" required>

        <label for="logPassword">Password:</label>
        <input id="logpass" type="Password" placeholder="Password" name="password" required>

        <input type="hidden" name="ref" value="<?= exists($_GET['ref']) ? $_GET['ref'] : '' ?>">

        <button id="login-btn" type="submit" title="Entrar" name="login_submit">Entrar</button>
      </div>

    </div>
  </form>

  <?php if(isset($_SESSION['admin']['errors']['login'])) : ?>
    <div id="bo_alert_wrapper">
      <div id="bo_alert_box">
        <div id="bo_alert_header"><i class="fa fa-exclamation" aria-hidden="true"></i> Acesso Não Autorizado</div>
        <div id="bo_alert_body"><?= implode('<br><br>', $_SESSION['admin']['errors']['login']); ?></div>
        <div id="bo_alert_footer">  
          <button onclick="bo_alert_close()">OK</button>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <script src="../resources/js/main.js"></script>

</body>
</html>
