<?php 
namespace app\models\objects;

use Yii;
use yii\base\Model;
use app\models\Lichchieu;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\data\Pagination;
/**
 * summary
 */
class ObjLichChieu extends Model
{
    /**
     * summary
     */
    public $id;
    public $ngayChieu;
    public $gioChieu;
    public $gia;
    public $phim;
    public $phong;
    public $created_at;
    public $updated_at;
    public $selectedSeat;

}

?>