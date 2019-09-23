<?php
namespace app\repositories;
use app\models\Project;

/**
 * Репозиторий по работе с проектами
 *
 * @author I.Shumilov
 */
class ProjectRepository {
    /**
     * Получить массив проектов в формате [id => name]
     * @return array
     */
    public static function getList(): array {
        $list = [];
        $models = Project::find()->orderBy('id')->cache(60)->all();
        foreach($models as $model) {
            $list[$model->id] = $model->id.' - '.$model->name;
        }
        return $list;
    }
}
