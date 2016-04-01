<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model shirase\modules\fields\models\Field */

$this->title = Yii::t('fields', 'Create Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('fields', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
