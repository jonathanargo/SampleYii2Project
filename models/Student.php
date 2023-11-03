<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 */
class Student extends \yii\db\ActiveRecord
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
        ];
    }

    public function getErrorsFlat(): array
    {
        $result = [];
        foreach ($this->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $result[] = $error;
            }
        }
        return $result;
    }
}
