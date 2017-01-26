<?
namespace App\View\Helper;

use Cake\View\Helper;

use Cake\Core\Configure;

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

  public function buildRelationText($relation_object, $name, $relation_text, $suffix, $type)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      if ($type == 2) {
	$res = $this->link($relation_object->name, $relation_object->id) . ' ' . $relation_text . ' ' . $name;
      } elseif($type == 1) {
	$res = $name . ' ' . $relation_text . ' ' . $this->link($relation_object->name, $relation_object->id);
      }
      $res .= ' ' . $suffix;
    } else {
      if ($type == 1) {
	//$res = $name . 'は ' . $this->link($relation_object->name, $relation_object->id);
	$res = $this->link($relation_object->name, $relation_object->id);
      } elseif ($type == 2) {
	$res = $this->link($relation_object->name, $relation_object->id) . ' は' . $name;
      }
      $res .= $relation_text . $suffix;
    }
    return $res;
  }

  public function period($obj)
  {
    $start = $this->date($obj->start, $obj->start_accuracy);
    if ($obj->is_momentary) {
      $ret = 'Occurred at: ' . $start;
    } else {
      $ret = 'Period: ' . $start;
      $ret .= ' ~ ';
      $ret .= $this->date($obj->end, $obj->end_accuracy);
    }
    if (empty($obj->start)) return '';
    return $ret;
  }

  public function date($obj, $accuracy)
  {
    if ($accuracy == 'year') {
      $format = 'Y';
    } elseif ($accuracy == 'month') {
      $format = 'Y-m';
    } elseif ($accuracy == 'day') {
      $format = 'Y-m-d';
    } else {
      $format = 'Y-m-d';
    }
    if (empty($obj)) return '';
    return $obj->format($format);
  }
}
