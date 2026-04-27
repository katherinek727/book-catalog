<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\Author;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Book::find()->orderBy(['created_at' => SORT_DESC]);
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 12,
        ]);
        $books = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'books'      => $books,
            'pagination' => $pagination,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['book' => $this->findModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Book();
        $authors = Author::find()->orderBy('full_name')->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->coverFile = UploadedFile::getInstance($model, 'coverFile');
            $authorIds = Yii::$app->request->post('author_ids', []);

            if ($model->save()) {
                // Save pivot relations
                foreach ($authorIds as $authorId) {
                    Yii::$app->db->createCommand()->insert('book_author', [
                        'book_id'   => $model->id,
                        'author_id' => (int)$authorId,
                    ])->execute();
                }

                // Notify subscribers
                $this->notifySubscribers($model, $authorIds);

                Yii::$app->session->setFlash('success', 'Book created successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model, 'authors' => $authors]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $authors = Author::find()->orderBy('full_name')->all();
        $selectedAuthorIds = array_column($model->authors, 'id');

        if ($model->load(Yii::$app->request->post())) {
            $model->coverFile = UploadedFile::getInstance($model, 'coverFile');
            $authorIds = Yii::$app->request->post('author_ids', []);

            if ($model->save()) {
                // Sync pivot
                Yii::$app->db->createCommand()->delete('book_author', ['book_id' => $model->id])->execute();
                foreach ($authorIds as $authorId) {
                    Yii::$app->db->createCommand()->insert('book_author', [
                        'book_id'   => $model->id,
                        'author_id' => (int)$authorId,
                    ])->execute();
                }

                Yii::$app->session->setFlash('success', 'Book updated successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model'             => $model,
            'authors'           => $authors,
            'selectedAuthorIds' => $selectedAuthorIds,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Remove cover file
        if ($model->cover_image) {
            $path = Yii::getAlias('@webroot/uploads/covers/') . $model->cover_image;
            if (is_file($path)) {
                unlink($path);
            }
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Book deleted.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Book not found.');
    }

    protected function notifySubscribers(Book $book, array $authorIds)
    {
        if (empty($authorIds)) {
            return;
        }

        $sms = new \app\components\SmsPilotService();
        $subscriptions = \app\models\Subscription::find()
            ->where(['author_id' => $authorIds])
            ->all();

        foreach ($subscriptions as $sub) {
            $message = "New book published: \"{$book->title}\" ({$book->year})";
            $sms->send($sub->phone, $message);
        }
    }
}
