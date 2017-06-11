<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Travels */

$this->title = 'editTravels: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Travels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="box-title"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="box-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
