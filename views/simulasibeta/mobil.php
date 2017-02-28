<?php
$skrip = $this->render('_mobil.js');
$this->registerJs($skrip, yii\web\View::POS_END);

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
?>
<div id="mobil" class="tab-pane fade in active">

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'mobil-form', 'validateOnSubmit' => true]); ?>

            <?= $form->field($model, 'otr')->textInput(['autofocus' => true, 'id' => 'harga', 'value' => 150000000]) ?>
            <?= $form->field($model, 'tahun')->dropDownList($tahun, ['id' => 'tahun']) ?>
            <?= $form->field($model, 'tenor')->dropDownList($tenor, ['id' => 'tenor']) ?>
            <?= $form->field($model, 'jumlah')->textInput(['value' => 50000000, 'id' => 'funding']) ?>
            <?= $form->field($model, 'angsuran')->textInput(['disabled' => 'true', 'id' => 'angsuran']) ?>
            <?=
            $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ])
            ?>

            <div class="form-group">
                <?= Html::submitButton('submit', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
