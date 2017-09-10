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
  public function retrieveRelatives()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);

    $Subjects = TableRegistry::get('Subjects');
    $Subjects->findAndSaveRelatives();
  }

  public function experimentSearch()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);

    $Subjects = TableRegistry::get('Subjects');
    $word = '渡辺 謙';


    debug($Subjects->privacyMode);
    $res = $Subjects->search($word);
    debug($res->toArray());
  }
}
