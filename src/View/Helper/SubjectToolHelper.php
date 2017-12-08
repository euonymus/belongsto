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
  public static function buildViewArray($name)
  {
    $ret = self::$arr_view_path;
    $ret[] = $name;
    return $ret;
  }
  public function imageLink($relation, $options = ['width' => '100px', 'height' => '100px'])
  {
    return $this->Html->link($this->Html->image($this->imagePath($relation->image_path), $options),
			     self::buildViewArray($relation->name),
			     ['escape' => false]);
  }
  public function link($text, $name)
  {
    return $this->Html->link($text, self::buildViewArray($name));
  }

  public function buynow()
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      return 'buy now';
    }
    return '購入する';
  }
  public function buildRelationText($relation_object, $name, $relation_text, $suffix, $type)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      if ($type == 1) {
	$res = $name . ' ' . $relation_text . ' ' . $this->link($relation_object->name, $relation_object->name);
      } elseif($type == 2) {
	$res = $this->link($relation_object->name, $relation_object->name) . ' ' . $relation_text . ' ' . $name;
      }
      $res .= ' ' . $suffix;
    } else {
      if ($type == 1) {
	//$res = $this->link($relation_object->name, $relation_object->name);
	$res = $name . 'は ' . $this->link($relation_object->name, $relation_object->name);
      } elseif ($type == 2) {
	$res = $this->link($relation_object->name, $relation_object->name) . ' は' . $name;
      }
      $res .= $relation_text . $suffix;
    }
    return $res;
  }
  public function buildRelationShortText($relation_object, $name, $relation_text, $suffix)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      // Stop shortening English text
      //$res = '..' . $relation_text . ' ' . $this->link($relation_object->name, $relation_object->name);
      $res = $name . ' ' . $relation_text . ' ' . $this->link($relation_object->name, $relation_object->name);
      $res .= ' ' . $suffix;
    } else {
      $res = $this->link($relation_object->name, $relation_object->name);
      $res .= $relation_text . $suffix;
    }
    return $res;
  }

  public function period($obj)
  {
    if (empty($obj->start) && empty($obj->end)) return '';

    $start = $this->date($obj->start, $obj->start_accuracy);
    $end   = $this->date($obj->end, $obj->end_accuracy);
    if ($obj->is_momentary) {
      //$ret = 'Occurred at: ' . $start;
      $ret = '(' . $start . ')';
    } else {
      //$ret = 'Period: ' . $start;
      $ret = '(' . $start;
      $ret .= ' ~ ';
      $ret .= $end . ')';
    }
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
