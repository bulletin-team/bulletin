<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Your New Bulletin Password</title>
  </head>
  <body>
    <div id="head" style="text-align: center; width: 100%; height: 110px; border-bottom: 1px solid #dddddd;">
      <a class="logolink" href="[config:base_url]">
        <img style="width: 334px; height: 80px; margin: 15px auto;" src="[config:base_url]img/5.png" alt="Bulletin" />
      </a>
    </div>
    <div style="width: 450px; display: table; margin: 1em auto;">
      <div style="font-family: sans-serif; font-size: 12pt; text-align: center; margin: 15px -15px; width: 100%; display: block;">
        <p style="width: 100%;">We're sorry you've lost access to your account!</p>
        <p style="width: 100%;">To make the recovery process easier, we've generated a new password for you. You can now log in with the password: [tpl:newpass]</p>
      </div>
    </div>
    <div style="width: 450px; height: 1px; margin: auto; background: #dddddd;"></div>
    <p style="margin-top: 2em; text-align: center; font-family: sans-serif; font-size: 12pt; color: #aaaaaa;">Welcome back to Bulletin!</p>
[config:eml_footer]
    <p style="color: #dddddd; margin: 4em auto auto auto; text-align: center; font-size: x-small; font-family: sans-serif;">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
