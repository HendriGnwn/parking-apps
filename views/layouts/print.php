<?php

/* @var $this View */
/* @var $content string */

use app\assets\PrintAsset;
use app\models\Setting;
use yii\helpers\Html;
use yii\web\View;

PrintAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title . ' - ' . Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    
    <div class="container">
		<div class="text-center">
			<strong class="title-1"><?= Setting::getAppName() ?></strong>
			<br/>
			<span><?= Setting::getCompanyAddress() ?></span>
			<br/>
			<span><?= Setting::getCompanyPhone() ?></span>
			<br/>
			---------------------------------------
		</div>
		<?= $content ?>
    </div>
</div>
<?php

$this->registerJs("

	document.onkeydown = function(e){
		if (e.keyCode==13){
			document.forms[0].buttonPrint.click();
		}
	}

	function printWindow(){
		bV = parseInt(navigator.appVersion)
		if (bV >= 4) window.print();
	}

", View::POS_END, 'print');
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
