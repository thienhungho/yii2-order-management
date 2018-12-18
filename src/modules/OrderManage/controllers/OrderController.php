<?php

namespace thienhungho\OrderManagement\modules\OrderManage\controllers;

use thienhungho\OrderManagement\models\Order;
use thienhungho\OrderManagement\modules\OrderManage\search\OrderSearch;
use thienhungho\UserManagement\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(request()->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerOrderItem = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orderItems,
        ]);

        return $this->render('view', [
            'model'             => $this->findModel($id),
            'providerOrderItem' => $providerOrderItem,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Order();
        if (is_login()) {
            $model = new Order([
                'customer_username'   => get_current_user_name(),
                'customer_email'      => get_current_user_email(),
                'customer_name'       => Yii::$app->user->identity->full_name,
                'customer_address'    => Yii::$app->user->identity->address,
                'customer_company'    => Yii::$app->user->identity->company,
                'customer_phone'      => Yii::$app->user->identity->phone,
                'customer_tax_number' => Yii::$app->user->identity->tax_number,
                'status'              => Order::STATUS_PENDING,
                'payment_method'      => Order::PAYMENT_MEDTHOD_COD,
                'include_vat'         => 'no',
                'ref_by'              => get_current_user_id(),
                'delivery_address'    => Yii::$app->user->identity->address,
            ]);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
                print_r($model->errors);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreateForUser($user_id)
    {
        $model = new Order();
        $user = $this->findUser($user_id);
        $model = new Order([
            'customer_username'   => $user->username,
            'customer_email'      => $user->email,
            'customer_name'       => $user->full_name,
            'customer_address'    => $user->address,
            'customer_company'    => $user->company,
            'customer_phone'      => $user->phone,
            'customer_tax_number' => $user->tax_number,
            'status'              => Order::STATUS_PENDING,
            'payment_method'      => Order::PAYMENT_MEDTHOD_COD,
            'include_vat'         => 'no',
            'ref_by'              => get_current_user_id(),
            'delivery_address'    => $user->address,
        ]);
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
                print_r($model->errors);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        if (request()->post('_asnew') == '1') {
            $model = new Order();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->deleteWithRelated()) {
            set_flash_success_delete_content();
        } else {
            set_flash_error_delete_content();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionBulk()
    {
        $action = request()->post('action');
        $ids = request()->post('selection');
        if (!empty($ids)) {
            if ($action == ACTION_DELETE) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    if ($model->deleteWithRelated()) {
                        set_flash_success_delete_content();
                    } else {
                        set_flash_error_delete_content();
                    }
                }
            } elseif (in_array($action, [
                Order::STATUS_PENDING,
                Order::STATUS_TRANSPORT,
                Order::STATUS_SUCCESS,
                Order::STATUS_PROCESSING,
            ])) {
                foreach ($ids as $id) {
                    $model = $this->findModel($id);
                    $model->status = $action;
                    if ($model->save()) {
                        set_flash_has_been_saved();
                    } else {
                        set_flash_has_not_been_saved();
                    }
                }
            }
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $providerOrderItem = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orderItems,
        ]);
        $content = $this->renderAjax('_pdf', [
            'model'             => $model,
            'providerOrderItem' => $providerOrderItem,
        ]);
        $pdf = new \kartik\mpdf\Pdf([
            'mode'        => \kartik\mpdf\Pdf::MODE_UTF8,
            'format'      => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content'     => $content,
            'cssFile'     => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'   => '.kv-heading-1{font-size:18px}',
            'options'     => ['title' => \Yii::$app->name],
            'methods'     => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);

        return $pdf->render();
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveAsNew($id)
    {
        $model = new Order();
        if (request()->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post()) && $model->saveAll()) {
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        } else {
            return $this->render('saveAsNew', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @param $id
     *
     * @return null|Order
     * @throws NotFoundHttpException
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddOrderItem()
    {
        if (request()->isAjax) {
            $row = request()->post('OrderItem');
            if ((request()->post('isNewRecord')
                    && request()->post('_action') == 'load'
                    && empty($row)) || request()->post('_action') == 'add')
                $row[] = [];

            return $this->renderAjax('_formOrderItem', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }
}
