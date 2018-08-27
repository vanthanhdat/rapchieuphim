<?php 

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Phim;
/**
 * summary
 */
class CronUpdateController extends Controller
{
    /**
     * summary
     */


    public function actionIndex()
    {
    	//echo 'con cặc';
    	$city = City::findOne(1);
        $city->cityname = 'hồ chí minh 1';
        $city->save();
        //return $this->actionInit(date("Y-m-d"), date("Y-m-d"));
    }

}

?>