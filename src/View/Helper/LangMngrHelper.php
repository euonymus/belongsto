<?
namespace App\View\Helper;

use Cake\View\Helper;

use Cake\Core\Configure;

class LangMngrHelper extends Helper
{
  public $helpers = ['Html'];

  public function txt($en, $ja)
  {
    $lang = Configure::read('Belongsto.lang');
    $lang_eng = Configure::read('Belongsto.lang_eng');
    if ($lang == $lang_eng) {
      return $en;
    }
    return $ja;
  }
}
