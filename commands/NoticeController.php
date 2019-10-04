<?php

namespace app\commands;

use yii\console\Controller;
use app\services\UserService;
use app\repositories\UserRepository;
use Yii;

/**
 * Консольный контроллер по управлению уведомлениями
 */
class NoticeController extends Controller
{
    /**
     * рассылка писем о непросмотренных уведомлениях
     */
    public function actionIndex() {
        $users = UserRepository::findAll();
        $mailer = Yii::$app->mailer;
        foreach($users as $user) {
            UserService::sendEmailAboutActualNotices($mailer, $user);            
        }
    }
}
