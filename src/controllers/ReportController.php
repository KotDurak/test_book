<?php

namespace app\controllers;

use app\models\forms\ReportForm;
use app\services\ReportService;
use yii\web\Controller;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct($id, $module, ReportService $reportService,  $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->reportService = $reportService;
    }

    public function actionIndex()
    {
        $model = new ReportForm(['year' => date('Y')]);
        $model->load(\Yii::$app->request->queryParams);

        $authors = $this->reportService->getTopAuthors($model->year);

        return $this->render('index', [
            'model' => $model,
            'authors'   => $authors,
        ]);
    }
}