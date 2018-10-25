<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['department_id' => 'id']);
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        Employee::deleteAll(['department_id' => $this->id]);
        return true;
    }

    public function extraFields()
    {
        $fields = parent::fields();
        $fields[] = 'employees';
        return $fields;
    }

}
