<?php
use yii\helpers\Html;
use app\models\Feed;
?>

<div class="panel">
    <div id="gameplay" class="container">

        <div class="gametitle" style="display:inline">
            <h1 style="display:inline;"><?= $game->game_name ?></h1>
        </div>
        <div class="fblink" style="float:right;">
            <iframe src="//www.facebook.com/plugins/like.php?href=http://www.arcadesoda.com/Play_Bubble_Academy_69&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=21" 
                    scrolling="no" style="border:none; overflow:hidden; height:21px; width:165px; float: right;" 
                    allowtransparency="true" frameborder="0"></iframe>
        </div>
        <div class="con-md-12 gameplay blue-bg" style="text-align: center">
            <iframe id="gameIFrame" scrolling="no" allowtransparency="true" marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" src="http://fagc.arcadesoda.com//index.php?r=serve&id=<?= $game->game_id ?>&pid=62"
                    style="border: 0px; margin:0px; position: relative; z-index: 6000;" width="<?= $game->game_dimension_width ?>" height="<?= $game->game_dimension_height ?>" frameborder="0"></iframe>
                    <br/>
                    <div class="con-md-12 game-text" style="width: <?= $game->game_dimension_width ?>; text-align: left">
                        <div class="col-md-8">
                            <span>Description:</span>
                            <br/>
                            <?= $game->game_description ?>
                        </div>
                        <div class="col-md-4"  >
                            <span>How to play:</span>
                            <br/>
                            <?= $game->game_instruction ?>
                        </div>


                    </div>
                    <br/>
        </div>
    </div>
</div>