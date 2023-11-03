<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

use app\models\Student;
use app\models\StudentSearch;


class StudentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * Displays student admin view.
     */
    public function actionIndex(): string|Response
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Student view page
     */
    public function actionView(int $id): string|Response
    {
        // First, we need to find the student that we asked for
        $student = Student::findOne($id);
        
        // If we didn't find a student, show an error and go back
        if (!$student instanceof Student) {
            Yii::$app->session->setFlash('error', ["Student $id was not found"]);
            $this->redirect(['student/index']);
            return '';
        }

        return $this->render('view', ['model'=>$student]);
    }

    /**
     * Student Create page.
     */
    public function actionCreate(): string|Response
    {
        $model = new Student();

        if ($this->request->isPost) {
            // Load the model attributes from the post and save the model
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', ["Student {$model->name} created!"]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // If model validation fails...
                $errors = array_merge(["Failed to create student"], $model->getErrorsFlat());
                Yii::$app->session->setFlash('error', $errors);
            }
        } else {
            // This will pre-load the model if any of the attributes have defaults
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Student update page.
     */
    public function actionUpdate(int $id): string|Response
    {
        $model = $this->findModel($id);

        // Load the model with attributes from the post
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                // Display success message and redirect to view page for new model
                Yii::$app->session->setFlash('success', ["Student {$model->name} updated!"]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // Display error, user will go back to the update page.
                $errors = array_merge(["Failed to update student"], $model->getErrorsFlat());
                Yii::$app->session->setFlash('error', $errors);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Student delete action.
     */
    public function actionDelete(int $id): string|Response
    {
        $model = $this->findModel($id);
        $studentName = $model->name;
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', ["Student $studentName deleted!"]);
        } else {
            Yii::$app->session->setFlash('error', ["Failed to delete student $studentName."]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Helper to load models in type-safe way that ensures the model is found.
     * 
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Student
    {
        $model = Student::findOne(['id' => $id]);
        if (!$model instanceof Student) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }

    
}