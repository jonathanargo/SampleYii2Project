<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Teacher;

/** @var yii\web\View $this */
/** @var app\models\ClassModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="class-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'teacher_id')->dropDownList(Teacher::getTeacherListData()); ?>

    <?= $form->field($model, 'schedule')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
