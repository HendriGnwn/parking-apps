<?php

namespace app\helpers;

use app\models\User;

/**
 * Description of DetailViewHelper
 * 
 * @author Hendri <hendri.gnw@gmail.com>
 */
class DetailViewHelper
{
    /**
     * @param $model
     * @param $attribute
     * @see User
     */
    public static function author($model, $attribute)
    {
        $user = User::findOne($model->$attribute);
        if($user) {
            $user = $user->username;
        } else {
            $user = $model->$attribute;
        }

        return [
            'attribute' => $attribute,
            'value' => $user,
        ];
    }
}