<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\BootstrapPluginAsset;
use yii\widgets\Pjax;
use yii\captcha\Captcha;

AppAsset::register($this);
BootstrapPluginAsset::register($this);
?>

<?php
$this->beginPage();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>  
        <title><?= Html::encode('Simulasi') ?></title>


        <?php $this->head(); ?>

<!--        <style type="text/css">
            .frame-area {
                display: block;
                width: 100%;  /* RESPONSIVE WIDTH */
                max-width: 480px;
                height: 470px;
                overflow: auto;  /* EDIT TO hidden FOR NO SCROLLBAR */
                border: #999999 0px solid;
                margin: 0px;
                padding: 0px;
            }

        </style>-->
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="frame-area">
            <?php Pjax::begin(); ?>
            <ul class="nav nav-tabs">
                <li><?= Html::a("Mobil", ['simulasibeta/']) ?></li>
                <li><?= Html::a("Motor", ['simulasibeta/motor']) ?></li>
            </ul>
            <?= $content ?>
            <?php Pjax::end(); ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

<script>
    $(document).ready(function () {
        $(".nav-tabs a").click(function () {
            $(this).tab('show');
        });
        $('.nav-tabs a').on('shown.bs.tab', function (event) {
            var x = $(event.target).text();         // active tab
            var y = $(event.relatedTarget).text();  // previous tab
            $(".act span").text(x);
            $(".prev span").text(y);
        });
    });
</script>