<?php

namespace app\modules\admin\controllers;

use app\common\Controller;
use Yii;
use app\modules\admin\models\Travels;
use app\modules\admin\models\TravelsSearch;
use app\common\AdminPluginController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TravelsController implements the CRUD actions for Travels model.
 */
class TravelsController extends Controller
{
    public $defaultAction = 'index';

    public function init()
    {
        parent::init();

    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Travels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Travels model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Travels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Travels();


        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'preview_image');

            $filename = md5(microtime() . rand(0, 9999));
            if ($model->imageFile->saveAs('../web/uploads/filemanager/source/' . $filename . '.' . $model->imageFile->extension)) {
                $model->preview_image = $filename . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Travels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Travels model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Travels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Travels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Travels::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeletes()
    {
        $result= ['code'=>200];
        $data = [];
        $post = Yii::$app->request->post();
        if($post && isset($post['ids']) && is_array($post['ids'])){
            foreach ($post['ids'] as $id){
                $model = $this->findModel($id);
                $model->delete();
            }
            $result['data'] = $data;
            $result['msg']  = 'Delete is complete!';
            }else{
                $result=['code'=>0,'msg'=>'Please select the data to be deleted!'];
            }

            if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
        }
        return $this->redirect(['index']);
    }
}