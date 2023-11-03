<?php

namespace app\models;

use Yii;
use app\models\ProjectActiveRecord;

use app\models\ClassModel;
use app\models\Enrollment;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $address
 */
class Student extends ProjectActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'year'], 'required'],
            [['year'], 'integer', 'min' => 1, 'max' => 4],
            [['name'], 'string', 'max' => 255],
            [['address'], 'string'],
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
            'year' => 'Year',
            'address' => 'Address',
        ];
    }

    /** 
    * Returns a query for class relations 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getClasses() 
   { 
       return $this->hasMany(ClassModel::class, ['id' => 'class_id'])->viaTable('enrollment', ['student_id' => 'id']); 
   } 
 
   /** 
    * Returns a query for enrollment relations 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getEnrollments() 
   { 
       return $this->hasMany(Enrollment::class, ['student_id' => 'id']); 
   } 
}
