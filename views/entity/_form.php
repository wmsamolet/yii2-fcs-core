<?php
/* @var $this yii\web\View */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $model wmsamolet\fcs\core\models\Entity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'group_id')->textInput() ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'class')->widget(Select2::class, [
        'initValueText' => '', // set the initial display text
        'options' => ['placeholder' => 'Search for a class namespace ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['entity/ajax-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(item) { return item.namespace; }'),
            'templateSelection' => new JsExpression('function (item) { return item.namespace; }'),
        ],
    ]); ?>

    <?php echo $form->field($model, 'table')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'categories_table')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug_attribute')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'sort_order')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
