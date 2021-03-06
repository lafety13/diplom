<?php

namespace app\modules\rbac\controllers;

use yii\rbac\Item;
use yii2mod\rbac\base\ItemController;
use amnah\yii2\user\models\Role;
use Yii;
use yii2mod\rbac\models\AuthItemModel;
use yii\db\IntegrityException;

/**
 * Class RoleController
 *
 * @package yii2mod\rbac\controllers
 */
class RoleController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_ROLE;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Role',
        'Items' => 'Roles',
    ];

    public function actionCreate()
    {
        $model = new AuthItemModel();
        $model->type = $this->type;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Role has been saved.'));
            //role
            $this->insertOrUpdateToRoleTable($model->name);
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldRole = $model->name;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Role has been saved.'));
            //role
            $this->insertOrUpdateToRoleTable($model->name,$oldRole);
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $roleName = $model->name;

        try{
            $this->deleteRole($roleName);
            Yii::$app->getAuthManager()->remove($model->item);
            Yii::$app->session->setFlash('success', Yii::t('yii2mod.rbac', 'Role has been deleted.'));
        }catch (IntegrityException $e){
            Yii::$app->session->setFlash('error', Yii::t('yii2mod.rbac', 'Role cannot be deleted!'));
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        return $this->redirect(['index']);
    }

    /**
     *  role table
     * @param $newRole
     * @param string $oldRole
     */
    public function insertOrUpdateToRoleTable($newRole,$oldRole="")
    {
        $should = 0;//1=insert,2=update,0=nothing to do
        $role   = null;
        if($oldRole){
            $role = Role::find()->where(['name'=>$oldRole])->one();
            if(!$role){
                $role = Role::find()->where(['name'=>$newRole])->one();
                if(!$role){
                    $should = 1;
                }
            }else{
                $should = 2;
            }
        }else{
            $role = Role::find()->where(['name'=>$newRole])->one();
            if(!$role){
                $should = 1;
            }
        }

        switch ($should){
            case 1:
                $role = new Role;
                $role->name = $newRole;
                $role->created_at = date("Y-m-d H:i:s",time());
                $role->can_admin = 0;
                $role->save();
                break;
            case 2:
                $role->name = $newRole;
                $role->updated_at = date("Y-m-d H:i:s",time());
                $role->save();
                break;
        }

    }

    public function deleteRole($roleName)
    {
        $role = Role::find()->where(['name'=>$roleName])->one();
        if($role)$role->delete();
    }
}
