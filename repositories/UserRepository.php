<?php

namespace app\repositories;
use app\helpers\UserHelper;
use app\models\User;

/**
 * Репозиторий по работе с пользователями
 *
 * @author I.Shumilov
 */
class UserRepository {
    /**
     * Получить массив проектов в формате [id => name]
     * @return array
     */
    public static function getList(): array {
        $list = [];
        $models = User::find()->orderBy('surname, name')->cache(60)->all();
        foreach($models as $model) {
            $list[$model->id] = UserHelper::fio($model);
        }
        return $list;
    }
}
