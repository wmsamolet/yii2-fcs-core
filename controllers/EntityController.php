<?php

namespace wmsamolet\fcs\core\controllers;

use wmsamolet\fcs\core\components\BackendController;
use wmsamolet\fcs\core\models\Entity;
use wmsamolet\fcs\core\models\search\EntitySearch;
use wmsamolet\fcs\core\Module;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

/**
 * EntityController implements the CRUD actions for Entity model.
 */
class EntityController extends BackendController
{
    /**
     * {@inheritdoc}
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
     * Lists all Entity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entity model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Entity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Creates a new Entity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Entity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Entity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAjaxList($q = null, $limit = 10)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $results = [];
        $q = mb_strtolower($q);

        if (! is_null($q)) {
            /** @var Module $module */
            $module = $this->module;

            foreach ($module->classPaths as $pathPattern) {
                $dirPaths = glob(Yii::getAlias($pathPattern), GLOB_ONLYDIR);

                foreach ($dirPaths as $dirPath) {
                    $filePaths = FileHelper::findFiles($dirPath, [
                        'only' => ['*.php'],
                        'caseSensitive' => false,
                    ]);

                    $filePaths = array_slice($filePaths, 0, 10);

                    foreach ($filePaths as $filePath) {
                        $fileSource = file_get_contents($filePath);
                        $namespace = '\\';
                        $className = '';

                        if (preg_match('/^namespace\s+(.+?)\;$/smi', $fileSource, $m)) {
                            $namespace = $m[ 1 ];
                        }

                        if (preg_match('/class\s+([a-z][\w]*)\s+(extends|implements|\{)/i', $fileSource, $m)) {
                            $className = $m[ 1 ];
                        }

                        $classNamespace = rtrim($namespace, '\\') . '\\' . $className;

                        if (mb_stripos(mb_strtolower($filePath), $q) !== false || mb_stripos(mb_strtolower($classNamespace), $q)) {
                            $results[] = ['id' => $className, 'namespace' => $classNamespace];
                        }
                    }
                }
            }
        }

        return ['results' => $results];
    }
}
