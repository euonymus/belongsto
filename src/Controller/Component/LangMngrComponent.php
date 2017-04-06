<?
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

use App\Controller\AppController;

class LangMngrComponent extends Component
{
    // Execute any other additional setup for your component.
    public function initialize(array $config)
    {
      $this->Controller = $this->_registry->getController();
    }

    public function txt($en, $ja)
    {
      $lang_now = AppController::$lang;
      $lang_eng = AppController::LANG_ENG;
      if ($lang_now == $lang_eng) {
	return $en;
      }
      return $ja;
    }
}