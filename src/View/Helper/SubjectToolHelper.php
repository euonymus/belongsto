<?
namespace App\View\Helper;

use Cake\View\Helper;

class SubjectToolHelper extends Helper
{
  public $helpers = ['Html'];
  const PATH_NO_IMAGE = '/img/no_image.jpg';
  static $arr_view_path = ['controller' => 'subjects', 'action' => 'relations'];

  public function imagePath($str)
  {
    if (empty($str)) return self::PATH_NO_IMAGE;
    return $str;
  }
  public static function buildViewArray($id)
  {
    $ret = self::$arr_view_path;
    $ret[] = $id;
    return $ret;
  }
  public function imageLink($relation, $options = ['width' => '100px', 'height' => '100px'])
  {
    return $this->Html->link($this->Html->image($this->imagePath($relation->image_path), $options),
			     self::buildViewArray($relation->id),
			     ['escape' => false]);
  }
  public function link($text, $id)
  {
    return $this->Html->link($text, self::buildViewArray($id));
  }
}
