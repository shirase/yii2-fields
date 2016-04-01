<?php

use yii\helpers\Html;
use shirase\form\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model shirase\modules\fields\models\search\FieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form field-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cat') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?php //echo $form->field($model, 'type') ?>

    <?php //echo $form->field($model, 'plugin') ?>

    <?php //echo $form->field($model, 'multi')->checkbox() ?>

    <?php //echo $form->field($model, 'directory_class') ?>

    <?php //echo $form->field($model, 'name') ?>

    <?php //echo $form->field($model, 'unit') ?>

    <?php //echo $form->field($model, 'counter') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('fields', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('fields', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
