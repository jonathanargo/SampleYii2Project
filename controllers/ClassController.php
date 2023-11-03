<?php

namespace app\controllers;

use Yii;
use app\models\ClassModel;
use app\models\Teacher;
use app\models\ClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ClassController implements the CRUD actions for ClassModel model.
 */
class ClassController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ClassModel models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClassSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClassModel model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClassModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate(): string|Response
    {
        $model = new ClassModel();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', ["Class {$model->name} created!"]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = array_merge(["Failed to create class"], $model->getErrorsFlat());
                Yii::$app->session->setFlash('error', $errors);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClassModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): string|Response
    {
        $model = $this->findModel($id);

        // Load the model with attributes from the post
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                // Display success message and redirect to view page for new model
                Yii::$app->session->setFlash('success', ["Class {$model->name} updated!"]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // Display error, user will go back to the update page.
                $errors = array_merge(["Failed to update class"], $model->getErrorsFlat());
                Yii::$app->session->setFlash('error', $errors);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Class delete action.
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): Response
    {
        $model = $this->findModel($id);
        $className = $model->name;
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', ["Student $className deleted!"]);
        } else {
            Yii::$app->session->setFlash('error', ["Failed to delete class $className."]);
        }

        return $this->redirect(['index']);
    }

     /**
     * Helper to load models in type-safe way that ensures the model is found.
     * 
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ClassModel
    {
        $model = ClassModel::findOne(['id' => $id]);
        if (!$model instanceof ClassModel) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }
}
