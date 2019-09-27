<?php
namespace app\helpers;
use app\models\User;

/**
 * Класс хелпер по работе с пользователями
 * @author I.Shumilov
 */
class UserHelper {
    /**
     * Получить ФИО пользователя
     * @param \app\helpers\User $user пользователь
     * @return string
     */
    public static function fio(User $user): string {
        if(!$user->name || !$user->surname) {
            return '';            
        }
        return mb_substr($user->name, 0, 1, 'UTF-8').'. '.$user->surname;                
    }
}
