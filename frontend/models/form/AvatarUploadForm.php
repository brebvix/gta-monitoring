<?php
namespace frontend\models\form;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class AvatarUploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $avatar;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['avatar'], 'image', 'extensions' => 'png', 'skipOnEmpty' => false, 'maxSize' => 1000000],
        ];
    }
}