<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system".
 *
 * @property int $id
 * @property string $key
 * @property string $value
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'string', 'max' => 32],
            [['value'], 'string', 'max' => 256],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'key' => Yii::t('main', 'Ключ'),
            'value' => Yii::t('main', 'Значение'),
        ];
    }

    public static function updateGlobalStatistic($key, $value, $plus = true)
    {
        $model = System::findOne(['key' => $key]);

        if (empty($model)) {
            return false;
        }

        if ($plus) {
            $model->value = (string) ($value + (int) $model->value);
        } else {
            $model->value = (string) $value;
        }

        return $model->save();
    }

    public static function updateGlobalStatisticFinal()
    {
        $model = System::findOne(['key' => 'global_servers_online']);
        $data = System::findOne(['key' => 'servers_online']);
        $model->value = $data->value;
        $model->save();

        $model = System::findOne(['key' => 'global_players_online']);
        $data = System::findOne(['key' => 'players_online']);
        $model->value = $data->value;
        $model->save();
    }
}
