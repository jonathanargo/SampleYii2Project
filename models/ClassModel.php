<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class".
 * 
 * Note: class name non-standard due to reserved PHP keyword.
 *
 * @property int $id
 * @property string $name
 * @property string $schedule
 * @property int $teacher_id
 *
 * @property Enrollment[] $enrollments
 * @property Student[] $students
 * @property Teacher $teacher
 */
class ClassModel extends \app\models\ProjectActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'schedule', 'teacher_id'], 'required'],
            [['teacher_id'], 'integer'],
            [['name', 'schedule'], 'string', 'max' => 255],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::class, 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'schedule' => 'Schedule',
            'teacher_id' => 'Teacher ID',
        ];
    }

    /**
     * Gets query for [[Enrollments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments()
    {
        return $this->hasMany(Enrollment::class, ['class_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::class, ['id' => 'student_id'])->viaTable('enrollment', ['class_id' => 'id']);
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::class, ['id' => 'teacher_id']);
    }
}
