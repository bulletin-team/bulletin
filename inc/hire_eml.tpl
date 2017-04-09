<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Job Application Selected</title>
  </head>
  <body>
    <div id="head" style="text-align: center; width: 100%; height: 110px; border-bottom: 1px solid #dddddd;">
      <a class="logolink" href="[config:base_url]">
        <img style="width: 334px; height: 80px; margin: 15px auto;" src="[config:base_url]img/5.png" alt="Bulletin" />
      </a>
    </div>
    <div style="width: 450px; display: table; margin: 1em auto;">
      <div style="font-family: sans-serif; font-size: 12pt; text-align: center; margin: 15px -15px; width: 100%; display: block;">
        <p style="width: 100%;">[tpl:providername] has selected you for their ad, <a style="color: #fb4d00;" href="[config:base_url]dash/ads.php?id=[tpl:adid]">[tpl:adtitle]</a>. If you have any questions, please review the job description, contact the job provider at <a style="color: #fb4d00;" href="mailto:[tpl:provideremail]">[tpl:provideremail]</a>, or pay a visit to their <a style="color: #fb4d00;" href="[config:base_url]dash/profile.php?id=[tpl:providerid]">profile</a>.</p>
        <p style="width: 100%;">Once the job is complete, please rate your experience with this provider under the <a style="color: #fb4d00;" href="[config:base_url]dash/jobs.php">My Jobs</a> tab.</p>
      </div>
    </div>
    <div style="width: 450px; height: 1px; margin: auto; background: #dddddd;"></div>
[config:eml_footer]
    <p style="color: #dddddd; margin: 4em auto auto auto; text-align: center; font-size: x-small; font-family: sans-serif;">Copyright &copy; 2016 Bulletin Team</p>
  </body>
</html>
