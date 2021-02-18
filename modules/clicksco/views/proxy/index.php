<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<?php /*if( Yii::$app->session->hasFlash('success') ) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php } */?>

<?php /*if( Yii::$app->session->hasFlash('error') ) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?= Yii::$app->session->getFlash('error'); ?>
    </div>
<?php } */?>

<h1>Proxy list</h1>

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

    <?= $form->field($proxy, 'type')->dropDownList($types) ?>

    <?= $form->field($proxy, 'needlogin')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <?= $form->field($proxy, 'login', [
        'options' => [
            'class' => 'form-group',
            'style' => 'display: none'
            ]
    ])->textInput() ?>

    <?= $form->field($proxy, 'pass', [
        'options' => [
            'class' => 'form-group',
            'style' => 'display: none'
            ]
    ])->textInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
        </div>
    </div>
<?php ActiveForm::end();

$js = <<< JS
        $('#proxy-needlogin').on('change', function (){
            $('.field-proxy-login').toggle();
            $('.field-proxy-pass').toggle();
        });
JS;

$this->registerJs($js);

?>
<table class="table table-bordered">
    <th>IP</th>
    <th>Port</th>
    <th>Type</th>
    <th>Login</th>
    <th>Password</th>
    <th>Errors counter</th>
    <th>&nbsp;</th>
<?php foreach ($proxies as $proxy) { ?>
    <tr>
        <td><?= $proxy['ip'] ?></td>
        <td><?= $proxy['port'] ?></td>
        <td><?= $types[$proxy['type']] ?></td>
        <td><?= $proxy['login'] ?></td>
        <td><?= $proxy['pass'] ?></td>
        <td><?= $proxy['errors'] ?></td>
        <td>
            <a href="<?= Url::toRoute(['/clicksco/proxy/check', 'id' => $proxy['id']]) ?>" class="btn btn-default">Check</a>
            <a href="<?= Url::toRoute(['/clicksco/proxy/delete', 'id' => $proxy['id']]) ?>" class="btn btn-danger">Delete</a>
        </td>
    </tr>
<?php } ?>

</table>
