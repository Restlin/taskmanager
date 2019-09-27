<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Модель для формы авторизации
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

    /**
     * email адрес
     * @var string
     */
    public $email;

    /**
     * пароль
     * @var string
     */
    public $password;

    /**
     * Запомнить пользователя
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Получить наименования атрибутов модели
     * @return array
     */
    public function attributeLabels(): array {
        return [
            'email' => 'email',
            'password' => 'пароль',
            'rememberMe' => 'запомнить пользователя'
        ];
    }

    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if (!($identity = UserIdentity::findOne(['email' => $this->email]))) {
            $this->addError('email', 'Такой пользователь в системе не найден!');
        } elseif (!$identity->validatePassword($this->password)) {
            $this->addError('password', 'Пароль неверный');
        }
        return !$this->hasErrors() && Yii::$app->user->login($identity, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

}
