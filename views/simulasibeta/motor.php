<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?= 'test' ?>
<div id="motor" class="tab-pane fade">

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'motor-form', 'validateOnSubmit' => true]); ?>

            <?php $form->field($model, 'jumlah')->textInput(['value' => 10000000, 'id' => 'funding']) ?>
            <?php $form->field($model, 'tenor')->textInput(['value' => 10000000, 'id' => 'tenor']) ?>
            <?php $form->field($model, 'angsuran')->textInput(['value' => 10000000, 'id' => 'angsuran']) ?>
            <?=
            $form->field($model, 'verifyCode')->widget(yii\captcha\Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]);
            ?>
            <div class="form-group">
                <?= Html::submitButton('submit', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>