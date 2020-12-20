<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title="Upload";
$this->params['breadcrumbs'][] = $this->title
?>
<h1><?php echo Html::encode($this->title)?></h1>

<p>
<?php echo Html::a('Upload File', ['upload'],['class'=>'btn btn-primary'])?>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
