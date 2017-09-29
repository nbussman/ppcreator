
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
    header('Location: index.php');
    exit();
  }
  if($found == false){
    header('Location: index.php');
    exit();
  }
  require "inc/htmlHeadShow.inc";
?>
      <div id="content-wrapper" class="">
        <div class="mui--appbar-height"></div>
        <br>
        <table>
          <tr>
            <td <? if($imagepath=="") echo 'style="width:50%"'; ?>>
              <p>
                <?=str_replace(array("\n"), '<br>', $description) ?>
              </p>
            </td>
            <? if($imagepath!="") { ?>
            <td style="width:50%">
              <img style="width:100%" src="<?=$imagepath ?>">
            </td>
            <? } ?>
          </tr>
        </table>
        <div id="yourErrors" style="display:none" class="mui-panel">

        </div>
        <div id="sortableTrash" class="sortable-code"></div>
        <div id="sortable" class="sortable-code">
        </div>
        <div style="clear:both;"></div>


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
                'programmingLang': "java",
                'lang':'de'
            });
            <?
              $formatedSourceCode = "";
              $code = explode("\n", $sourcecode);
              foreach( $code as $zeile )
                $formatedSourceCode .= str_replace(array("\r", "\n"), '', $zeile) .'\n';

              $forgingCode = explode("\n", $forgingline);
              foreach( $forgingCode as $zeile )
                $formatedSourceCode .= str_replace(array("\r", "\n"), '', $zeile) .'#distractor \n';
              $formatedSourceCode = trim(htmlspecialchars($formatedSourceCode));
            ?>
            var initial = '<?= $formatedSourceCode ?>';


            parson.init(initial);
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

                if (fb.length <= 0) {
                  $("#yourErrors").html("").slideUp();
                  alert("Super! Du hast die Fragmente richtig angeordnet.");
                }
                else {
                    $("#yourErrors").slideDown().html('<div class="mui--text-title">Feedback</div><div class="mui--text-accent">' + fb + '</div>');
                }


            });
        });
        </script>
    </body>
</html>
