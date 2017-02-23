<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\AppAsset;

$this->title = 'Simulasi Kredit';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->beginPage()
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
<?php $this->beginBody() ?>

        <div class="site-simulasi">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                This is the About page. You may modify the following file to customize its content:
            </p>

            <form>

                <br>
                <div class="form-group">
                    <label for="harga">Harga Kendaraan OTR **</label><br>
                    <input id="harga" type="number" min="5000000" max="1000000000" class="form-control" placeholder="Harga Kendaraan OTR">
                </div>
                <div class="form-group">

                    <label for="harga">Tahun Kendaraan *</label><br>
                    <select id="tahun" class="form-control">
                        <option value="2017">2017
                        <option value="2016">2016
                        <option value="2015">2015
                        <option value="2014">2014
                        <option value="2013">2013
                        <option value="2012">2012
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Tenor *</label><br>
                    <select id="tenor" class="form-control" placeholder="Tenor">
                        <option value="12">1 Tahun
                        <option value="24">2 Tahun
                        <option value="36">3 Tahun
                        <option value="48">4 Tahun
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Funding *</label><br>
                    <input type="number" class="form-control" id="funding" placeholder="Funding">
                </div>
                <div class="form-group">
                    <label for="harga">Angsuran *</label><br>
                    <input class="form-control" id="angsuran" type="text" placeholder="Angsuran" disabled>
                </div>
            </form>

            <button onclick="myFunction()">Hitung</button>

        </div>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

<script>
    document.getElementById('harga').maxLength = "4";
    function myFunction() {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/simulasi/hitung' ?>',
            type: 'post',
            data: {
                harga: $("#harga").val(),
                tahun: $("#tahun").val(),
                tenor: $("#tenor").val(),
                funding: $("#funding").val(),
//                _csrf: '<?= Yii::$app->request->getCsrfToken() ?>'
            },
            success: function (data) {
//                console.log(data.data);
                $("#angsuran").val(data.data);
            }
        });
    }
</script>
