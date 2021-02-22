<?php
use yii\helpers\Html;
//use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<div class="clicksco-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'proxycheckform',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>{error}",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]); ?>

    <?= $form->field($proxy, 'ip')->textInput(['autofocus' => true]) ?>

    <?= $form->field($proxy, 'port')->textInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
        </div>
    </div>
<?php ActiveForm::end();?>

<pre>
    <?php print_r ($page); ?>
</pre>