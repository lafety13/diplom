<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Travels */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Travels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="box-title"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="box-body">

    <p>
        <?= Html::a('Add to', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('edit', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('return', ['index'], ['class' => 'btn btn-default btn-sm']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'short_description',
            'text:ntext',
            'date',
            'preview_image',
        ],
    ]) ?>
    </div>
</div>
