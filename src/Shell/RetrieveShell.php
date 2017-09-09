<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

use U\U;

class RetrieveShell extends Shell
{
  //public static $withCacheLog = true;
  public function retrieveRelatives()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');

    $Subjects = TableRegistry::get('Subjects');
    $Subjects->findAndSaveRelatives();
  }
}
