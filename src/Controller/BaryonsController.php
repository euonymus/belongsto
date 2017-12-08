<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

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
      if (in_array($this->request->action, ['quark', 'add'])) {
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
	$title = $this->LangMngr->txt('Your Baryons', 'Your Baryons');

        $this->set(compact('baryons', 'title'));
        $this->set('_serialize', ['baryons']);
    }

    public function quark($name = null)
    {
        $this->paginate = [
			   'contain' => ['Users'],
			   'conditions' => ['user_id' => $this->Auth->user('id')],
        ];
        $baryons = $this->paginate($this->Baryons);


        $Subjects = TableRegistry::get('Subjects');
        //$subject = $Subjects->getRelations($subject_id);
	//if (!$subject) $this->redirect('/');
	try {
	  $subject = $Subjects->getRelationsByName($name);
	} catch(\Exception $e) {
	  try {
	    $forRedirect = $Subjects->get($name);
	  } catch(\Exception $e) {
	    throw new NotFoundException('Record not found in table "subjects"');
	  }
	  return $this->redirect('/baryons/quark/' . urlencode($forRedirect->name), 301);
	}

	// just in case;
	if (!$subject) return $this->redirect('/');


	$title = $this->LangMngr->txt('Choose a baryon', 'Choose a baryon');
        $this->set(compact('baryons', 'subject', 'title'));
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

    public function relations($id = null, $name = null, $second_type = null)
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

	$contain = ['Actives', 'Passives'];
	if (!$baryon->is_oneway) {
	  $contain = [];
	  $contain['Actives'] = function ($q) {
	    return $q->where(['Relations.baryon_id' => $GLOBALS['g_id']]);
	  };
	  $contain['Passives'] = function ($q) {
	    return $q->where(['Relations.baryon_id' => $GLOBALS['g_id']]);
	  };
	}

	$baryon_id = false;
	if (!$baryon->is_oneway) {
	  $baryon_id = $id;
	}
        $Subjects = TableRegistry::get('Subjects');
        //$subject = $Subjects->getRelations($subject_id, $contain, 2, $second_type, $baryon_id);
	//if (!$subject) $this->redirect('/');
	try {
	  $subject = $Subjects->getRelationsByName($name, $contain, 2, $second_type, $baryon_id);
	} catch(\Exception $e) {
	  try {
	    $forRedirect = $Subjects->get($name);
	  } catch(\Exception $e) {
	    throw new NotFoundException('Record not found in table "subjects"');
	  }
	  $suffix = ($second_type == 'active') ? '' : '/' . $second_type;
	  return $this->redirect('/baryons/relations/' . $id . '/' . urlencode($forRedirect->name) . $suffix, 301);
	}

	// just in case;
	if (!$subject) return $this->redirect('/');

	$title = $subject->name . '[Baryon: ' . $baryon->name . ']';

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
            $baryon->user_id = $this->Auth->user('id');
            if ($this->Baryons->save($baryon)) {
                $this->_setFlash(__('The baryon has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->_setFlash(__('The baryon could not be saved. Please, try again.'), true);
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
            $baryon->user_id = $this->Auth->user('id');
            if ($this->Baryons->save($baryon)) {
                $this->_setFlash(__('The baryon has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->_setFlash(__('The baryon could not be saved. Please, try again.'), true);
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
	    $this->_setFlash(__('The baryon has been deleted.'));
        } else {
	    $this->_setFlash(__('The baryon could not be deleted. Please, try again.'), true);
        }
        return $this->redirect(['action' => 'index']);
    }
}
