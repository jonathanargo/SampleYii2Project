<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ClassModel $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="class-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Teacher',
                'value' => $model->getTeacher()->one()->name,
            ],
            'schedule',
            
        ],
    ]) ?>

    <strong>Students</strong>
    <table class="table table-striped table-boardered">
        <tbody>
            <?php foreach ($model->getStudents()->all() as $student): ?>
                <tr>
                    <td><?php echo Html::encode($student->name); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
