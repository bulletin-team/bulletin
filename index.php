<?php
require('inc/common.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bulletin</title>
    <meta charset="UTF-8" />
    <meta name="description" content="Community, at your fingertips." />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/chat.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/frontpage.js"></script>
    <script type="text/javascript" src="js/auth.php"></script>
    <script type="text/javascript" src="js/chat.js"></script>
  </head>
  <body>
    <div id="cover">
        <a id="headerbar" href="<?=htmlentities($b_config['base_url']); ?>"><div id="headerimg"></div></a>
      <div id="midbody">
        <div class="bigquote">Community, at your fingertips.</div>
        <div id="links">
          <span class="link" id="link1"><a href="/login.php">Log In</a></span>
          <span class="link" id="link2"><a href="/signup.php">Sign Up</a></span>
        </div>
      </div>
    </div>
    <div id="part2">
     <div id="body2">
        <div id="header3">
          <a href="#part2"><div id="dwnbtn"></div></a>
        </div>
        <div id="mission">
          <div id="workers">
            <h2>For Hard Workers</h2>
            <div class="nowrap">
              <div class="bubble lbubble">
                <p class="bubblehead">Earn Some Money</p>
                <p>Bulletin is for high school and college students, providing quick job opportunities. Bulletin lets you keep 100% of your profits so you can start making money in no time!</p>
              </div>
              <div class="bubble mbubble">
                <p class="bubblehead">Low Commitment</p>
                <p>Bulletin features one-time jobs, like mowing lawns or raking leaves, so there's no need to commit to a full or part-time job. Apply to ads when you have some free time!</p>
              </div>
              <div class="bubble rbubble">
                <p class="bubblehead">It&apos;s Free</p>
                <p>Create an account for free and start applying to jobs in minutes!</p>
              </div>
            </div>
            <a href="/signup.php?t=0">
              <div class="workerbtn">Become a Worker</div>
            </a>
          </div>
          <div id="employers">
            <h2>For Household CEOs</h2>
            <div class="nowrap">
              <div class="bubble lbubble">
                <p class="bubblehead">Need Some Help?</p>
                <p>Post an ad and review your student applicants. Find the worker that's right for you to help you get some work done.</p>
              </div>
              <div class="bubble mbubble">
                <p class="bubbleflash">FREE</p>
              </div>
              <div class="bubble rbubble">
                <p class="bubblehead">Save Some Money</p>
                <p>We connect you with student workers as an alternative to expensive professionals for unskilled tasks. Each ad costs a one-time fee and we leave it up to you to pay the worker.</p>
              </div>
            </div>
            <a href="/signup.php?t=1">
              <div class="employerbtn">Become an Employer</div>
            </a>
          </div>
          <div id="footer">
            <p id="copy"><a href="#cover">Top</a>&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;Copyright &copy; 2016 Bulletin Team</p>
          </div>
    </div>
 
        </div>
      </div>
 </body>
</html>
