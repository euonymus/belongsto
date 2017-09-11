<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

use App\Utils\U;

class RetrieveShell extends Shell
{
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
  }

  public function retrieveRelatives()
  {
    $this->Subjects->findAndSaveRelatives(100);
  }

  public function retrieveTalents($generation = 10, $page = 1)
  {
    $this->Subjects->retrieveAndSaveTalents($generation, $page);
  }
}
