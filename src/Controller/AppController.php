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
    const LANG_ENG = 'en';
    const LANG_JPY = 'ja';
    static $langs = [
      self::LANG_ENG,
      self::LANG_JPY,
    ];
    static $lang = self::LANG_ENG;

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
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->viewBuilder()->layout('belongsto');
	$this->Session = $this->request->session();

	$subdomain = U::getSubdomain();
	if (in_array($subdomain, self::$langs)) {
	  self::$lang = $subdomain;
	}

	$lang_now = self::$lang;
	$lang_eng = self::LANG_ENG;

	Configure::write('Belongsto.lang', $lang_now);
	Configure::write('Belongsto.lang_eng', $lang_eng);
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
