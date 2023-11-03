<?php

namespace app\models;

use Yii;

use app\models\ClassModel;
use app\models\Student;

/**
 * This is the model class for table "enrollment".
 *
 * @property int $id
 * @property int $class_id
 * @property int $student_id
 *
 * @property Class $class
 * @property Student $student
 */
class Enrollment extends \app\models\ProjectActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'enrollment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'student_id'], 'required'],
            [['class_id', 'student_id'], 'integer'],
            [['class_id', 'student_id'], 'unique', 'targetAttribute' => ['class_id', 'student_id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassModel::class, 'targetAttribute' => ['class_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'student_id' => 'Student ID',
        ];
    }

    /**
     * Gets query for [[Class]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(ClassModel::class, ['id' => 'class_id']);
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }
}
