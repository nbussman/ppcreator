
<?
  require 'inc/mysqlConnect.inc.php';

  $found = false;
  if(!empty($_GET['h'])){
    $hash = $conn->real_escape_string($_GET["h"]);
    $query = "SELECT * FROM puzzles WHERE MD5(id) ='".$hash."'";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_object()){
          $found = true;
          $title = $row->title;
          $description = $row->description;
          $imagepath = $row->imagepath;
          $sourcecode  = $row->sourcecode;
          $forgingline = $row->forginglines;
        }

        /* free result set */
        $result->close();
    }

  }
  else {
    exit();
  }
  if($found == false) exit();
?>

<!doctype html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Parsons Puzzle</title>
        <link href="lib/js-parsons/parsons.css" rel="stylesheet" />
        <link href="lib/js-parsons/lib/prettify.css" rel="stylesheet" />
        <script src="lib/js-parsons/lib/prettify.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <script
          src="https://code.jquery.com/jquery-3.2.1.min.js"
          integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
          crossorigin="anonymous"></script>

    </head>
    <body>
        <h2><?=$title ?></h2>
        <table>
          <tr>
            <td style="width:50%">
              <p>
                <?=$description ?>
              </p>
            </td style="width:50%">
            <td>
              <img style="width:100%" src="<?=$imagepath ?>">
            </td>
          </tr>
        </table>
        <div id="sortableTrash" class="sortable-code"></div>
        <div id="sortable" class="sortable-code">
        </div>
        <div style="clear:both;"></div>
        <center>
            <button href="#" id="newInstanceLink">Löschen</button>
            <button href="#" id="feedbackLink">Überprüfen</button>
            <br><br>
            <div id="yourErrors">
            </div>
        </center>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="lib/js-parsons/lib/jquery.min.js"></script>
        <script src="lib/js-parsons/lib/jquery-ui.min.js"></script>
        <script src="lib/js-parsons/lib/jquery.ui.touch-punch.min.js"></script>
        <script src="lib/js-parsons/lib/underscore-min.js"></script>
        <script src="lib/js-parsons/lib/lis.js"></script>
        <script src="lib/js-parsons/parsons.js"></script>
        <script>

        function displayErrors(fb) {
            if(fb.errors.length > 0) {
                alert(fb.errors[0]);
            }
        }



        $(document).ready(function(){
          var feedbackCounter = 0;
            var parson = new ParsonsWidget({
                'sortableId': 'sortable',
                'trashId': 'sortableTrash',
                'programmingLang': "java"
            });
            parson.init('<?
              $code = explode("\n", $sourcecode);
              foreach( $code as $zeile )
                echo str_replace(array("\r", "\n"), '', $zeile) .'\'+\'\n ';
            ?>');
            parson.shuffleLines();
            $("#newInstanceLink").click(function(event){
                event.preventDefault();
                feedbackCounter = 0;
                parson.shuffleLines();
            });
            $("#feedbackLink").click(function(event){
                event.preventDefault();
                feedbackCounter++;
                var fb = parson.getFeedback();
                var help;
                if(feedbackCounter > 10){
                  help = "<font color='red'><h4>Hilfe gefällig?</h4>"+
                    "Du hast über zehn Feedbacks erhalten. Hier findest du eine Hilfe: <br><a href='help.html' target='_blank'>Hilfe</a><br>"+
                  "</font>";
                }
                else{
                  help = "";
                }
                if (fb.length <= 0) {
                  $("#yourErrors").html("");
                  alert("Sehr gut! Du hast es geschafft.\nVersuche nun das Parsons Puzzle im Editor Geany zu implementieren.");
                }
                else {
                    $("#yourErrors").html(help + "<font color='red'><h4>Feedback:</h4>" + fb + "</font>");
                }


            });
        });
        </script>
    </body>
</html>
