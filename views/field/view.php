<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model shirase\modules\fields\models\Field */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('fields', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('fields', 'Back'), ['index', 'returned'=>true], ['class' => 'btn btn-default']) ?>
        <!--<?= Html::a(Yii::t('fields', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>-->
        <!--<?= Html::a(Yii::t('fields', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('fields', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat',
            'alias',
            [
                'attribute'=>'status',
                'format'=>'boolean',
                'type'=>DetailView::INPUT_CHECKBOX,
            ],
            'type',
            'plugin',
            [
                'attribute'=>'multi',
                'format'=>'boolean',
                'type'=>DetailView::INPUT_CHECKBOX,
            ],
            'directory_class',
            'name',
            'unit',
            'counter',
        ],
        'panel'=>[
            'heading'=>$this->title,
        ],
        'deleteOptions'=>[
            'url' => ['delete', $model->primaryKey()[0]=>$model->primaryKey],
            'params' => ['j-delete' => true],
        ],
    ]) ?>

</div>
