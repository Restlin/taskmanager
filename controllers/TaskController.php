<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskSearch;
use app\repositories\UserRepository;
use app\repositories\TaskRepository;
use app\repositories\TaskTypeRepository;
use app\repositories\ProjectRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\services\TaskService;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [                        
                        'allow' => true,                        
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'projects' => ProjectRepository::getList(),
                    'types' => TaskTypeRepository::getList(),
                    'users' => UserRepository::getList(),
                    'priorities' => TaskRepository::getPriorityList(),
                    'statuses' => TaskRepository::getStatusList()
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $task = $this->findModel($id);      
        $user = Yii::$app->user;

        $isAuthor = TaskService::isAuthor($task, $user);
        $isExecutor = TaskService::isExecutor($task, $user);
        if (!$isAuthor && !$isExecutor) {
            throw new ForbiddenHttpException('Вы не имеете доступа к этой задаче!');
        }

        return $this->render('view', [
                    'model' => $task,
                    'projects' => ProjectRepository::getList(),
                    'types' => TaskTypeRepository::getList(),
                    'users' => UserRepository::getList(),
                    'priorities' => TaskRepository::getPriorityList(),
                    'statuses' => TaskRepository::getStatusList(),
                    'canTakeToWork' => TaskService::canTakeToWork($task, $user),
                    'canReady' => TaskService::canReady($task, $user),
                    'canDone' => TaskService::canDone($task, $user),
                    'canEdit' => TaskService::canEdit($task, $user),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Task();
        $model->authorId = Yii::$app->user->getId();
        $model->dateStart = date('Y-m-d H:i:s');
        $model->status = TaskRepository::STATUS_WAIT;
        $model->priority = TaskRepository::PRIORITY_NORMAL;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('form', [
                    'model' => $model,
                    'projects' => ProjectRepository::getList(),
                    'types' => TaskTypeRepository::getList(),
                    'users' => UserRepository::getList(),
                    'priorities' => TaskRepository::getPriorityList(),
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if (!TaskService::canEdit($model, Yii::$app->user)) {
            throw new ForbiddenHttpException('Вы не можете изменять эту задачу!');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('form', [
                    'model' => $model,
                    'projects' => ProjectRepository::getList(),
                    'types' => TaskTypeRepository::getList(),
                    'users' => UserRepository::getList(),
                    'priorities' => TaskRepository::getPriorityList(),
        ]);
    }

    /**
     * Взять задачу в работу
     * @param int $id ИД задачи
     * @return mixed
     */
    public function actionWork($id) {
        $model = $this->findModel($id);

        if (!TaskService::canTakeToWork($model, Yii::$app->user)) {
            throw new ForbiddenHttpException('Вы не являетесь исполнителем этой задачи!');
        }
        TaskService::takeToWork($model);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Отметить задачу готовой для проверки
     * @param int $id ИД задачи
     * @return mixed
     */
    public function actionReady($id) {
        $model = $this->findModel($id);

        if (!TaskService::canReady($model, Yii::$app->user)) {
            throw new ForbiddenHttpException('Вы не являетесь исполнителем этой задачи!');
        }
        $comment = Yii::$app->request->post('Task[comment]');
        
        if ($comment && TaskService::readyTask($model, $comment)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('ready', [
            'model' => $model
        ]);
        
    }

    /**
     * Выполнение задачи
     * @param int $id ИД задачи
     * @return mixed
     */
    public function actionDone($id) {
        $model = $this->findModel($id);

        if (!TaskService::canDone($model, Yii::$app->user)) {
            throw new ForbiddenHttpException('Вы не являетесь автором этой задачи!');
        }
        TaskService::doneTask($model);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if (!TaskService::canEdit($model, Yii::$app->user)) {
            throw new ForbiddenHttpException('Вы не можете удалять эту задачу!');
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
