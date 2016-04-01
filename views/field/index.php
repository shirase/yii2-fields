<?php

use shirase\modules\fields\models\search\FieldSearch;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel shirase\modules\fields\models\search\FieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('fields', 'Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('fields', 'Create Field'), ['create']+$this->context->actionParams, ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'pjax' => true,        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'shirase\grid\sortable\SerialColumn'],

            'cat',
            'alias',
            ['class'=>'kartik\grid\BooleanColumn', 'attribute'=>'status'],
            ['attribute'=>'type', 'value'=>function($model){return FieldSearch::typeOpt()[$model->type];}],
            'plugin',
            ['class'=>'kartik\grid\BooleanColumn', 'attribute'=>'multi'],
            'directory_class',
            'name',
            'unit',
            //'counter',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>
