<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Baryons Controller
 *
 * @property \App\Model\Table\BaryonsTable $Baryons
 */
class BaryonsController extends AppController
{

    public function beforeFilter(Event $event)
    {
      parent::beforeFilter($event);
      $this->Auth->allow(['relations', 'search']);
    }

    public function isAuthorized($user)
    {
        if (in_array($this->request->action, ['add'])) {
            return true;
        }

	if (in_array($this->request->action, ['edit', 'delete'])) {
            $baryonId = $this->request->params['pass'][0];
            if ($this->Baryons->isOwnedBy($baryonId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
			   'contain' => ['Users'],
			   'conditions' => ['user_id' => $this->Auth->user('id')],
        ];
        $baryons = $this->paginate($this->Baryons);

        $this->set(compact('baryons'));
        $this->set('_serialize', ['baryons']);
    }

    /**
     * View method
     *
     * @param string|null $id Baryon id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $baryon = $this->Baryons->get($id, [
            'contain' => ['Users']
        ]);

	if ($baryon->is_private && !$this->Baryons->isOwnedBy($id, $this->Auth->user('id'))) {
	  $this->redirect('/');
	}

	$contain = ['Actives', 'Passives'];

        $RelationsModel = TableRegistry::get('Relations');
        $relations = $RelationsModel->getByBaryon($id, $contain);
	if (!$relations) $this->redirect('/');

	$title = 'Baryon: ' . $baryon->name;

        $this->set(compact('baryon', 'relations', 'title'));
        $this->set('_serialize', ['baryon']);
    }

    public function relations($id = null, $subject_id = null, $second_type = null)
    {
        if ( ($second_type != 'none') && ($second_type != 'passive') ) {
	  $second_type = 'active';
        }

        $baryon = $this->Baryons->get($id, [
            'contain' => ['Users']
        ]);

	if ($baryon->is_private && !$this->Baryons->isOwnedBy($id, $this->Auth->user('id'))) {
	  $this->redirect('/');
	}

	// * I didn't want to use the global value, but could not find alternative way...
	global $g_id;
	$g_id = $id;
	$contain['Actives'] = function ($q) {
	  return $q->where(['Relations.baryon_id' => $GLOBALS['g_id']]);
	};
	$contain['Passives'] = function ($q) {
	  return $q->where(['Relations.baryon_id' => $GLOBALS['g_id']]);
	};

	$baryon_id = false;
	if (!$baryon->is_oneway) {
	  $baryon_id = $id;
	}
        $Subjects = TableRegistry::get('Subjects');
        $subject = $Subjects->getRelations($subject_id, $contain, 2, $second_type, $baryon_id);
	if (!$subject) $this->redirect('/');

	$title = 'Baryon: ' . $subject->name;

        $this->set(compact('baryon', 'second_type', 'subject', 'title'));
        $this->set('_serialize', ['baryon']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $baryon = $this->Baryons->newEntity();
        if ($this->request->is('post')) {
            $baryon = $this->Baryons->patchEntity($baryon, $this->request->data);
            if ($this->Baryons->save($baryon)) {
                $this->Flash->success(__('The baryon has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The baryon could not be saved. Please, try again.'));
            }
        }
        $users = $this->Baryons->Users->find('list', ['limit' => 200]);
        $this->set(compact('baryon', 'users'));
        $this->set('_serialize', ['baryon']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Baryon id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $baryon = $this->Baryons->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $baryon = $this->Baryons->patchEntity($baryon, $this->request->data);
            if ($this->Baryons->save($baryon)) {
                $this->Flash->success(__('The baryon has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The baryon could not be saved. Please, try again.'));
            }
        }
        $users = $this->Baryons->Users->find('list', ['limit' => 200]);
        $this->set(compact('baryon', 'users'));
        $this->set('_serialize', ['baryon']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Baryon id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $baryon = $this->Baryons->get($id);
        if ($this->Baryons->delete($baryon)) {
            $this->Flash->success(__('The baryon has been deleted.'));
        } else {
            $this->Flash->error(__('The baryon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
