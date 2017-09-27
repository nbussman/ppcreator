<?
  require 'inc/mysqlConnect.inc.php';
  require 'inc/htmlHead.inc';
  ?>
  <div id="content-wrapper" class="create mui--text-center">
    <div class="mui--appbar-height"></div>
    <br>
    <br>
  <?
  if(!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['sourcecode'])) {
    if (!empty($_POST['imgurl'])) $imgurl = $_POST['imgurl'];
      else   $imgurl = "";
    if (!empty($_POST['imgurl'])) $wronglines = $_POST['wronglines'];
      else   $wronglines = "";
    $sql = "INSERT INTO `puzzles` (`title`, `description`, `imagepath`, `sourcecode`, `forginglines`)
     VALUES  ('".$conn->real_escape_string($_POST['title'])."','"
      .$conn->real_escape_string($_POST['description'])."','"
      .$conn->real_escape_string($imgurl)."','"
      .$conn->real_escape_string($_POST['sourcecode'])."','"
      .$conn->real_escape_string($wronglines)
    ."');";
    if ($conn->query($sql) === TRUE) {
      $id = mysqli_insert_id($conn);
      $hash = md5($id);
      $url = "http://thisisaurl.com/".$hash;
    ?>
      <div class="mui--text-display3">
        Puzzle created
      </div>
      <div class="mui--text-light">
        <br><br><br>
        This url belongs to your puzzle:<br>
        <div id="link-input" class="mui-textfield">
          <input type="text" value="<?=$url ?>" readonly="readonly" >
        </div>
        <br><br>
        <a class="mui-btn mui-btn--raised" href="<?=$url ?>">Visit your puzzle</a><br>
      </div>
    <?
    } else {
        echo "<h1>Error while saving to database</h1>";
    }

  } else{
  ?>
      <div class="mui--text-display3">Create a puzzle</div>
      <br>
      <form class="mui-form" action="create.php" method="post">
        <div class="mui-textfield">
          <input type="text" name="title" placeholder="Title" required>
        </div>
        <div class="mui-textfield">
          <textarea placeholder="Description" name="description" required></textarea>
        </div>
        <div class="mui-textfield">
          <input type="text" name="imgurl" placeholder="Imageurl http://....">
        </div>
        <div class="mui-textfield mui-textfield-long">
          <textarea name="sourcecode" placeholder="Sourcecode (linewise)" required></textarea>
        </div>
        <div class="mui-textfield">
          <textarea name="wronglines" placeholder="Wrong lines (to force decisions)"></textarea>
        </div>
        <div class="mui--text-light">
          By creating the puzzle I agree that this puzzles is publishished under this <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"> creative common license <img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" /></a>.<br> <em>We do not collect any personal data from you or your students.</em>
        </div>
        <button type="submit" class="mui-btn mui-btn--raised">Create the puzzle</button>
      </form>


  <?
  }
  echo"</div>";
  require 'inc/htmlFoot.inc';
  require 'inc/mysqlClose.inc.php';

?>
