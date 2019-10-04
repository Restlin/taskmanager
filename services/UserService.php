<?php

namespace app\services;

use app\models\User;

/**
 * Сервис по работе с пользователями 
 * @author restlin
 */
class UserService {
    /**
     * Отправка письма пользователю
     * @param \yii\swiftmailer\Mailer $mailer компонент почты
     * @param User $user пользователь
     * @param string $subject тема
     * @param string $content текст
     * @return bool
     */
    public static function sendEmailToUser(\yii\swiftmailer\Mailer $mailer, User $user, string $subject, string $content) {
        return $mailer->compose()
                ->setTo($user->email)
                ->setFrom(['bot@taskmanager.ru' => 'Робот сервиса задач']) //@todo перенести в параметры конфигурации
                ->setSubject($subject)
                ->setTextBody($content)
                ->send();
    }
    /**
     * Отправить пользователю письмо про забытые уведомления
     * @param \yii\swiftmailer\Mailer $mailer сервис отправки почты
     * @param User $user пользователь
     */
    public static function sendEmailAboutActualNotices(\yii\swiftmailer\Mailer $mailer, User $user) {
        $actuals = $user->getNotices()->where('actual = 1')->count();
        if($actuals) {
            UserService::sendEmailtoUser($mailer, $user, 'Напоминание о забытых уведомлениях', "У вас есть непросмотренные уведомления[$actuals]!");
        }
    }

}
