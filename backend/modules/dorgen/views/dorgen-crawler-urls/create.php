<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\dorgen\models\DorgenCrawlerUrls */

$this->title = 'Create Dorgen Crawler Urls';
$this->params['breadcrumbs'][] = ['label' => 'Dorgen Crawler Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dorgen-crawler-urls-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
