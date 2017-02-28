<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Verify Your Bulletin Email</title>
  </head>
  <body>
    <div id="head" style="text-align: center; width: 100%; height: 110px; border-bottom: 1px solid #dddddd;">
      <a class="logolink" href="[config:base_url]">
        <img style="width: 334px; height: 80px; margin: 15px auto;" src="[config:base_url]img/5.png" alt="Bulletin" />
      </a>
    </div>
    <div style="width: 450px; display: table; margin: 1em auto;">
      <div style="font-family: sans-serif; font-size: 12pt; text-align: center; margin: 15px -15px; width: 100%; display: block;">
        <p style="width: 100%;">The email address included in your profile has been successfully updated. Your account has been deactivated in the meanwhile, but now you may reactivate it.</p>
        <p style="width: 100%;">To reactivate your account, <a style="color: #fb4d00;" href="[config:base_url]activate.php?[tpl:activation_vars]">click here</a>.</p>
      </div>
    </div>
    <div style="width: 450px; height: 1px; margin: auto; background: #dddddd;"></div>
[config:eml_footer]
    <p style="color: #dddddd; margin: 4em auto auto auto; text-align: center; font-size: x-small; font-family: sans-serif;">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
