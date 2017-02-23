<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Active Your Bulletin Account</title>
  </head>
  <body>
    <div id="head" style="text-align: center; width: 100%; height: 110px; border-bottom: 1px solid #dddddd;">
      <a class="logolink" href="[config:base_url]">
        <img style="width: 334px; height: 80px; margin: 15px auto;" src="[config:base_url]img/5.png" alt="Bulletin" />
      </a>
    </div>
    <div style="width: 450px; display: table; margin: 1em auto;">
      <div style="font-family: sans-serif; font-size: 12pt; text-align: center; margin: 15px -15px; width: 100%; display: block;">
        <p style="width: 100%;">Your Ad, <a style="color: #fb4d00;" href="[config:base_url]dash/review.php?id=[tpl:rid]">[tpl:adname]</a>, has just received a response. The applicant is named [tpl:seekername] and [tpl:seekerrating]. To get in touch, you can check out more of their profile, you can email them at <a style="color: #fb4d00;" href="mailto:[tpl:seekereml]">[tpl:seekereml]</a>, or check out more of their profile <a style="color: #fb4d00;" href="[config:base_url]dash/profile.php?id=[tpl:seekerid]">here</a>.</p>
      </div>
    </div>
    <div style="width: 450px; height: 1px; margin: auto; background: #dddddd;"></div>
[config:eml_footer]
    <p style="color: #dddddd; margin: 4em auto auto auto; text-align: center; font-size: x-small; font-family: sans-serif;">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
