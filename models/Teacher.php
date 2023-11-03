<?php

namespace app\models;

use Yii;
use app\models\ProjectActiveRecord;

use app\models\ClassModel;

/**
 * This is the model class for table "teacher".
 *
 * @property int $id
 * @property string $name
 * @property int $phone
 * @property string|null $address
 * @property string $subject
 *
 * @property Class[] $classes
 */
class Teacher extends ProjectActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'subject'], 'required'],
            [['phone'], 'integer'],
            [['address'], 'string'],
            [['name', 'subject'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'address' => 'Address',
            'subject' => 'Subject',
        ];
    }

    /**
     * Gets query for [[Classes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasses()
    {
        return $this->hasMany(ClassModel::class, ['teacher_id' => 'id']);
    }

    /**
     * Returns array of list data of eligible teachers for use in forms.
     */
    public static function getTeacherListData(): array
    {
        $teachers = Teacher::find()->indexBy('id')->all();
        $result = [];
        foreach ($teachers as $teacher) {
            $result[$teacher->id] = $teacher->name;
        }
        return $result;
    }
}
