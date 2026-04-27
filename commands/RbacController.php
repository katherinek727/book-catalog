<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        // Permissions
        $manageBooks = $auth->createPermission('manageBooks');
        $manageBooks->description = 'Manage books (create, update, delete)';
        $auth->add($manageBooks);

        $manageAuthors = $auth->createPermission('manageAuthors');
        $manageAuthors->description = 'Manage authors (create, update, delete)';
        $auth->add($manageAuthors);

        // Roles
        $guest = $auth->createRole('guest');
        $guest->description = 'Guest user (can view, subscribe)';
        $auth->add($guest);

        $user = $auth->createRole('user');
        $user->description = 'Authenticated user (can manage books and authors)';
        $auth->add($user);

        // Assign permissions to roles
        $auth->addChild($user, $manageBooks);
        $auth->addChild($user, $manageAuthors);

        $this->stdout("RBAC initialized successfully.\n");
        return ExitCode::OK;
    }
}
