<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\Cache\Cache;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function isAuthorized($user)
    {
        if (in_array($this->request->action, ['logout', 'privacy'])) {
            return true;
        }

        // The owner of an user can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete'])) {
            $userId = $this->request->params['pass'][0];
            if ($this->Users->isOwnedBy($userId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add', 'logout');
    }

    public function privacy($mode = 1)
    {
      if (!in_array($mode,
		    [\App\Controller\AppController::PRIVACY_PUBLIC,
		     \App\Controller\AppController::PRIVACY_PRIVATE,
		     \App\Controller\AppController::PRIVACY_ALL,
		     \App\Controller\AppController::PRIVACY_ADMIN])) {
	$mode = \App\Controller\AppController::PRIVACY_PUBLIC;
      }

      if (($this->Auth->user('role') != 'admin') && ($mode == \App\Controller\AppController::PRIVACY_ADMIN)) {
	$mode = \App\Controller\AppController::PRIVACY_ALL;
      }
      Cache::clear(false); 

      $this->Session->write('PrivacyMode', $mode);
      $url = $this->referer(null, true);
      return $this->redirect($url);
    }
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                //return $this->redirect($this->Auth->redirectUrl());
		$referer = unserialize($this->Session->read('LoginReferer'));
		$this->Session->delete('LoginReferer');
		$this->Session->delete('PrivacyMode');
		Cache::clear(false); 
                return $this->redirect($referer);
            }
            $this->_setFlash(__('Invalid username or password, try again'), true);
        } else {
	  $this->Session->write('LoginReferer', serialize($this->referer()));
	}
	$title = 'Login to gluons';
        $this->set(compact('title'));
    }

    public function logout()
    {
	Cache::clear(false); 
        $this->Session->write('PrivacyMode', \App\Controller\AppController::PRIVACY_ALL);
        //return $this->redirect($this->Auth->logout());
	$this->Auth->logout();
	return $this->redirect($this->referer());
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->_setFlash(__('The user has been saved.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            } else {
                $this->_setFlash(__('The user could not be saved. Please, try again.'), true);
            }
        }
	$title = 'Create a FREE account';

        $this->set(compact('user', 'title'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
	$title = 'Edit your account';

        $this->set(compact('user', 'title'));
        $this->set('_serialize', ['user']);
    }
}
