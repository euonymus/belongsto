<?
namespace App\View\Helper;

use Cake\View\Helper;

use Cake\Core\Configure;

class BaryonToolHelper extends Helper
{
  public $helpers = ['Html'];
  const PATH_NO_IMAGE = '/img/no_image.jpg';
  static $arr_view_path = ['controller' => 'baryons', 'action' => 'relations'];

  public function imagePath($str)
  {
    if (empty($str)) return self::PATH_NO_IMAGE;
    return $str;
  }
  public static function buildViewArray($id, $subject_id)
  {
    $ret = self::$arr_view_path;
    $ret[] = $id;
    $ret[] = $subject_id;
    return $ret;
  }
  public function imageLink($baryon_id, $subject, $options = ['width' => '100px', 'height' => '100px'])
  {
    return $this->Html->link($this->Html->image($this->imagePath($subject->image_path), $options),
			     self::buildViewArray($baryon_id, $subject->id),
			     ['escape' => false]);
  }
  public function link($text, $id, $subject_id)
  {
    return $this->Html->link($text, self::buildViewArray($id, $subject_id));
  }

  public function buildRelationText($baryon_id, $relation_object, $name, $relation_text, $suffix, $type)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      if ($type == 1) {
	$res = $name . ' ' . $relation_text . ' ' . $this->link($relation_object->name, $baryon_id, $relation_object->id);
      } elseif($type == 2) {
	$res = $this->link($relation_object->name, $baryon_id, $relation_object->id) . ' ' . $relation_text . ' ' . $name;
      }
      $res .= ' ' . $suffix;
    } else {
      if ($type == 1) {
	//$res = $this->link($relation_object->name, $relation_object->id);
	$res = $name . 'は ' . $this->link($relation_object->name, $baryon_id, $relation_object->id);
      } elseif ($type == 2) {
	$res = $this->link($relation_object->name, $baryon_id, $relation_object->id) . ' は' . $name;
      }
      $res .= $relation_text . $suffix;
    }
    return $res;
  }

  public function buildRelationShortText($baryon_id, $relation_object, $name, $relation_text, $suffix)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      // Stop shortening English text
      //$res = '..' . $relation_text . ' ' . $this->link($relation_object->name, $relation_object->id);
      $res = $name . ' ' . $relation_text . ' ' . $this->link($relation_object->name, $baryon_id, $relation_object->id);
      $res .= ' ' . $suffix;
    } else {
      $res = $this->link($relation_object->name, $baryon_id, $relation_object->id);
      $res .= $relation_text . $suffix;
    }
    return $res;
  }
}
