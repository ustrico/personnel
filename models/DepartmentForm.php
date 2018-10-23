<?php

namespace app\models;

use yii\base\Model;

class DepartmentForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }
}