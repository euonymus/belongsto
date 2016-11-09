<?
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class SubjectCompComponent extends Component
{
    /* public $components = ['RequestHandler']; */

    /* public $table_name = 'Reservedfeeds'; // as a default */
    /* public $paginate_limit = 100; */
    /* //public $rss_limit      = 100; */
    /* public $default_order = ['created' => 'desc']; */
    /* public $default_contains = false; */

    // Execute any other additional setup for your component.
    public function initialize(array $config)
    {
      //$this->Controller = $this->_registry->getController();
    }
}