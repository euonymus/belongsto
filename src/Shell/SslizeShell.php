<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

use Cake\Filesystem\File;

use App\Utils\U;
use App\Utils\GoogleSearch;
use App\Utils\Wikipedia;

class SslizeShell extends Shell
{
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
    $this->Relations = TableRegistry::get('Relations');
  }

  // This class is not going to be needed anymore
  /* public function retrieve() */
  /* { */
  /*   $template = '%s: %s: <img src="%s" style="width:150px;height:150px;"> <img src="%s" style="width:150px;height:150px;"><br>'; */

  /*   require_once("ssl_candidates.php"); */

  /*   $file = new File('/Users/euonymus/Sites/belongsto/work/src/cakephp/src/Shell/https.csv'); */
  /*   $file_html = new File('/Users/euonymus/Sites/belongsto/work/src/cakephp/src/Shell/html.html'); */

  /*   $i = 0; */
  /*   foreach($ids as $key => $id) { */
  /*     debug($id); */
  /*     $data = $this->Subjects->get($id); */
  /*     if (!$data) continue; */

  /*     $res = GoogleSearch::getFirstImageFromImageSearch($data->name); */
  /*     if (!$res) continue; */

  /*     $arr = [$id, $data->name, $data->image_path, $res]; */
  /*     $file->append(implode(',', $arr) . "\n"); */
  /*     $file_html->append(sprintf($template, $id, $data->name, $data->image_path, $res) . "\n"); */
  /*     $i++; */
  /*     debug($i . '/' . ($key + 1)); */
  /*   } */
  /* } */

  /* public function replace() */
  /* { */
  /*   require_once("ssl_data.php"); */
  /*   foreach($arr as $val) { */
  /*     $data = $this->Subjects->get($val[0]); */
  /*     if (preg_match("/\Ahttps\:\/\//", $data->image_path, $matches)) continue; */

  /*     /\* $data->image_path = $val[3]; *\/ */
  /*     /\* $this->Subjects->save($data); *\/ */
  /*     debug($data); */
  /*   } */
  /* } */

}
