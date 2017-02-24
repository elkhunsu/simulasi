<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\BootstrapPluginAsset;

AppAsset::register($this);
BootstrapPluginAsset::register($this);
?>

<?php
$this->beginPage();
$this->title = 'Simulasi Pinjaman';
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="site-index">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                This is the Simulation page. You may modify the following file to customize its content:
            </p>
        </div>
        <div class="container">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#mobil">Mobil</a></li>
                <li><a href="#motor">Motor</a></li>
            </ul>
            <div class="tab-content">

                <div id="mobil" class="tab-pane fade in active">
                    <!--                    <form>-->
                    </br>
                    <h4>Mobil</h4>

                    <div class="form-group">
                        <label for="harga">Harga Kendaraan OTR **</label><br>
                        <input id="harga" type="number" min="5000000" max="1000000000" class="form-control" placeholder="Harga Kendaraan OTR">
                    </div>
                    <div class="form-group">

                        <label for="tahun">Tahun Kendaraan *</label><br>
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
                        <label for="tenor">Tenor *</label><br>
                        <select id="tenor" class="form-control" placeholder="Tenor">
                            <option value="12">1 Tahun
                            <option value="24">2 Tahun
                            <option value="36">3 Tahun
                            <option value="48">4 Tahun
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="funding">Jumlah Pinjaman *</label><br>
                        <input type="number" class="form-control" id="funding" placeholder="Jumlah Pinjaman">
                    </div>
                    <div class="form-group">
                        <label for="angsuran">Angsuran *</label><br>
                        <input class="form-control" id="angsuran" type="text" placeholder="Angsuran" disabled>
                    </div>
                    <button onclick="mobilFunction()">Hitung Angsuran</button>
                </div>
                <div id="motor" class="tab-pane fade">
                    </br>
                    <div class="form-group">
                        <label for="pinjaman">Jumlah Pinjaman *</label><br>
                        <input type="number" class="form-control" id="fundMotor" placeholder="Jumlah Pinjaman" required>
                    </div>
                    <div class="form-group">
                        <label for="tenor">Tenor *</label><br>
                        <select id="tenorMotor" class="form-control" placeholder="Tenor">
                            <option value="5">5 Bulan
                            <option value="6">6 Bulan
                            <option value="11">11 Bulan
                            <option value="12">12 Bulan
                            <option value="17">17 Bulan
                            <option value="18">18 Bulan
                            <option value="23">23 Bulan
                            <option value="24">24 Bulan
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="angsuranMotor">Angsuran *</label><br>
                        <input class="form-control" id="angsur" type="text" placeholder="Angsuran" disabled>
                    </div>
                    <button onclick="motorFunction()">Hitung Angsuran</button>

                </div>

            </div>
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

    function mobilFunction() {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/simulasi/hitung' ?>',
            type: 'post',
            data: {
                harga: $("#harga").val(),
                tahun: $("#tahun").val(),
                tenor: $("#tenor").val(),
                funding: $("#funding").val(),
            },
            success: function (data) {
                $("#angsuran").val(data.data);
            }
        });
    }

    function motorFunction() {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/simulasi/hitungmotor' ?>',
            type: 'post',
            data: {
                tenor: $("#tenorMotor").val(),
                funding: $("#fundMotor").val(),
            },
            success: function (data) {
                $("#angsur").val(data);
            }
        });
    }
</script>
