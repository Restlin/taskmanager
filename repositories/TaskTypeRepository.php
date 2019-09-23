<?php
namespace app\repositories;
use app\models\TaskType;

/**
 * Репозиторий по работе с типами задач
 *
 * @author I.Shumilov
 */
class TaskTypeRepository {
    /**
     * Получить массив проектов в формате [id => name]
     * @return array
     */
    public static function getList(): array {
        $list = [];
        $models = TaskType::find()->orderBy('id')->cache(60)->all();
        foreach($models as $model) {
            $list[$model->id] = $model->name;
        }
        return $list;
    }
    
}
