<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form ActiveForm */

$this->title="Coba Upload";
$this->params['breadcrumbs'][] = $this->title
?>
<div class="project-upload">

<h1><?php echo Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

        <?= $form->field($model, 'filename')->fileInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-upload -->
