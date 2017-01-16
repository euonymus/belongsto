<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add', 'logout');
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->_setFlash(__('Invalid username or password, try again'), true);
        }
	$title = 'Login to gluons';
        $this->set(compact('title'));
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
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
