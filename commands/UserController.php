<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class UserController extends Controller
{
    /**
     * Create a new user.
     * Usage: php yii user/create <username> <password>
     */
    public function actionCreate(string $username, string $password)
    {
        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save(false)) {
            $this->stdout("User created: {$username}\n");
            return ExitCode::OK;
        }

        $this->stderr("Failed to create user.\n");
        return ExitCode::UNSPECIFIED_ERROR;
    }
}
