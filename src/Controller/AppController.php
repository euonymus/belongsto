<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

use Cake\Core\Configure;
use Cake\Routing\Router;

use App\Utils\U;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $helpers = ['LangMngr'];

    const DOMAIN_PROD = 'gluons.link';
    const LANG_ENG = 'en';
    const LANG_JPY = 'ja';
    static $langs = [
      self::LANG_ENG,
      self::LANG_JPY,
    ];
    static $lang = self::LANG_ENG;

    const PRIVACY_PUBLIC  = 1;
    const PRIVACY_PRIVATE = 2;
    const PRIVACY_ALL     = 3;
    const PRIVACY_ADMIN   = 4;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
	// Setting Language
	$subdomain = U::getSubdomain();
	if (in_array($subdomain, self::$langs)) {
	  self::$lang = $subdomain;
	}

	$lang_now = self::$lang;
	$lang_eng = self::LANG_ENG;

	Configure::write('Belongsto.lang', $lang_now);
	Configure::write('Belongsto.lang_eng', $lang_eng);

        // Sanitize none gluons.link domain
        $host = Configure::read('Belongsto.host');
	if (($host == 'production') && ($this->request->domain() != self::DOMAIN_PROD)) {
	  $subDomain = '';
	  if ($lang_now != $lang_eng) {
	    $subDomain = $lang_now . '.';
	  }
	  $sanitizeRedirect = 'https://' . $subDomain . self::DOMAIN_PROD . Router::url();
	  $this->redirect($sanitizeRedirect);
	}

	// Start ====================================================
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => null,
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => null,
                'action' => 'index'
            ]
        ]);

        $this->loadComponent('LangMngr');

        $this->viewBuilder()->layout('belongsto');
	$this->Session = $this->request->session();

	// Setting User info
	Configure::write('Belongsto.auth', $this->Auth);

	// Setting privacy mode
	$privacy_mode = $this->Session->read('PrivacyMode');
	if (empty($privacy_mode)) {
	  if ($this->Auth->user()) {
	    $privacy_mode = $this->Auth->user('default_showing_privacy');
	  } else {
	    $privacy_mode = self::PRIVACY_ALL;
	  }
	}
	Configure::write('Belongsto.privacyMode', $privacy_mode);

	// Setting title description
	if ($lang_now == $lang_eng) {
	  //$gluonsDescription = 'gluons - Find hidden relations behind person and things';
	  $gluonsDescription = 'gluons';
	} else {
	  //$gluonsDescription = 'gluons - 人と物のつながりを発見するサービス';
	  $gluonsDescription = 'グルーオンズ';
	}
        $this->set(compact('lang_now', 'lang_eng', 'gluonsDescription'));
    }
    public function isAuthorized($user)
    {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // Default deny
        return false;
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'view', 'display', 'relations', 'search']);
	// pass the auth information to view 
        $this->set('auth', $this->Auth);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function _setFlash($string, $error = false)
    {
	$this->Flash->set($string, ['params' => ['class' => 'alert alert-'. ($error ? 'danger' : 'success')]]); 
    }
}
