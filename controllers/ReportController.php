<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $year = (int)Yii::$app->request->get('year', date('Y'));

        $results = Yii::$app->db->createCommand('
            SELECT a.id, a.full_name, COUNT(ba.book_id) AS book_count
            FROM author a
            INNER JOIN book_author ba ON ba.author_id = a.id
            INNER JOIN book b ON b.id = ba.book_id
            WHERE b.year = :year
            GROUP BY a.id, a.full_name
            ORDER BY book_count DESC
            LIMIT 10
        ')->bindValue(':year', $year)->queryAll();

        return $this->render('index', [
            'results' => $results,
            'year'    => $year,
        ]);
    }
}
