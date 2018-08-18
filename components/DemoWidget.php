<?php 
	namespace app\components;
	use yii\base\Widget;
	use yii\helpers\Html;

	/**
	 * summary
	 */
	class DemoWidget extends Widget
	{

		//public $message;
	    
	    public function init()
	    {
	    	parent::init();
        	ob_start();
	    }

	    public function run()
	    {
	    	$content = ob_get_clean();
        	return Html::encode($content);
        	//return $this->render('/site/index');
	    }
	    /*
	    customize path containing the widget view files.
	     */
	   /*
	   public function getViewPath()
	    {
	    	return 'app/views';
	    }
	    */

	}
 ?>