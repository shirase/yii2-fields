<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shirase\modules\fields\models\Field */

$this->title = Yii::t('fields', 'Update {modelClass}: ', [
    'modelClass' => 'Field',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('fields', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('fields', 'Update');
?>
<div class="field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
