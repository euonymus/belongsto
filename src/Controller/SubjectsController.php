<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;
use App\Utils\U;

/**
 * Subjects Controller
 *
 * @property \App\Model\Table\SubjectsTable $Subjects
 */
class SubjectsController extends AppController
{

    public function isAuthorized($user)
    {
        if (in_array($this->request->action, ['add', 'edit', 'confirm'])) {
            return true;
        }

        // The owner of a subject can delete it
        if (in_array($this->request->action, ['delete'])) {
            $subjectId = $this->request->params['pass'][0];
            if ($this->Subjects->isOwnedBy($subjectId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->paginate = [
            'conditions' => [$this->Subjects->wherePrivacy()]
        ];
        $subjects = $this->paginate($this->Subjects, ['contain' => 'Actives']);
	$title = 'quarks that gluons hold';

        $this->set(compact('subjects', 'title'));
        $this->set('_serialize', ['subjects']);
    }

    public function search()
    {
      if (!array_key_exists('keywords', $this->request->query)) $this->redirect('/');

      $subjects = $this->Subjects->search($this->request->query['keywords']);

      $title = 'Search results of ' . $this->request->query['keywords'];
      $this->set(compact('subjects', 'title'));
      $this->set('_serialize', ['subjects']);
      $this->render('index');
    }

    /**
     * Relations method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function relations($id = null, $second_type = null)
    {
        if ( ($second_type != 'none') && ($second_type != 'passive') ) {
	  $second_type = 'active';
        }

        $subject = $this->Subjects->getRelations($id, ['Actives', 'Passives'], 2, $second_type);
	if (!$subject) $this->redirect('/');

	if ($second_type == 'none') {
	  $title_second_level = '(no second level)';
	} else {
	  $title_second_level = '(second level: ' . $second_type . ')';
	}

	$title = 'Relations among ' . $subject->name . $title_second_level;
        $this->set(compact('subject', 'second_type', 'title'));
        $this->set('_serialize', ['subject']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($confirm = null)
    {
        if (is_null($confirm) || ($confirm != 'confirm')) {
	  $this->Session->delete('SavingSubjects');
	}

        // Session check
        $this->Session->delete('ExistingSubjects');
        $session = unserialize($this->Session->read('SavingSubjects'));
	if ($session) {
	  $this->Session->delete('SavingSubjects');
	  $this->request->data = $session;
	}

        // Existence check
        if ($this->request->is('post')) {
	  $query = $this->Subjects->search($this->request->data['name']);
	  if (iterator_count($query)) {
	    $this->Session->write('ExistingSubjects', serialize($query->toArray()));
	    $this->Session->write('SavingSubjects', serialize($this->request->data));
	    return $this->redirect(['action' => 'confirm']);
	  }
	}

        // Saving
        $subject = $this->Subjects->newEntity();
        if ($this->request->is('post') || $session) {
            $subject = $this->Subjects->formToSaving($this->request->data);

            $subject->user_id = $this->Auth->user('id');
            $subject->last_modified_user = $this->Auth->user('id');

            if ($savedSubject = $this->Subjects->save($subject)) {
                $this->_setFlash(__('The quark has been saved.')); 
                return $this->redirect(['action' => 'relations', $savedSubject->id]);
            } else {
                $this->_setFlash(__('The quark could not be saved. Please, try again.'), true); 
            }
        }

	$title = 'Adding new quark';
        $this->set(compact('subject', 'title'));
        $this->set('_serialize', ['subject']);
    }

    public function confirm()
    {
      $saving = unserialize($this->Session->read('SavingSubjects'));
      $subjects = unserialize($this->Session->read('ExistingSubjects'));
      $title = 'Check if the quark already exists, before adding';
      $this->set(compact('saving', 'subjects', 'title'));
      $this->set('_serialize', ['subjects']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subject = $this->Subjects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subject = $this->Subjects->formToEditing($subject, $this->request->data);

            $subject->last_modified_user = $this->Auth->user('id');

            if ($savedSubject = $this->Subjects->save($subject)) {
                $this->_setFlash(__('The quark has been saved.')); 
                return $this->redirect(['action' => 'relations', $savedSubject->id]);
            } else {
                $this->_setFlash(__('The quark could not be saved. Please, try again.'), true); 
            }
        }
	$title = 'Editing quark';
        $this->set(compact('subject', 'title'));
        $this->set('_serialize', ['subject']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subject = $this->Subjects->get($id);

        if ($this->Subjects->delete($subject)) {
	    $this->_setFlash(__('The quark has been deleted.'));
        } else {
	    $this->_setFlash(__('The quark could not be deleted. Please, try again.'), true);
        }

        return $this->redirect(['controller' => 'Subjects', 'action' => 'index']);
    }
}
