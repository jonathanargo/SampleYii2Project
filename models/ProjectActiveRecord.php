<?php

namespace app\models;

use Yii;

/**
 * Extended version of base AR class to add helper functions
 */
abstract class ProjectActiveRecord extends \yii\db\ActiveRecord
{
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