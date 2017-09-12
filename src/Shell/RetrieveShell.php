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

  /********************************************/
  /* Migration                                */
  /********************************************/
  public function talentCollector()
  {
    $generation = 10;
    $page_range = [1,2];

    /********* Waiting *********/
    //$generation = 10;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,284];

    //$generation = 20;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,800];
    //$page_range = [801,826];

    //$generation = 30;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,800];
    //$page_range = [801,900];
    //$page_range = [901,940];

    //$generation = 40;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,663];

    //$generation = 50;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,385];

    //$generation = 60;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,210];

    //$generation = 70;
    //$page_range = [1,100];
    //$page_range = [1,106];

    /***************************/


    /*********** Done **********/
    //$generation = 80;
    //$page_range = [1,46];

    //$generation = 90;
    //$page_range = [1,6];
    /***************************/

    for ($page = $page_range[0]; $page <= $page_range[1]; $page++) {
      $this->retrieveTalents($generation, $page);
    }
  }
}
