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

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $subjects = $this->paginate($this->Subjects);

        $this->set(compact('subjects'));
        $this->set('_serialize', ['subjects']);
    }

    /**
     * View method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subject = $this->Subjects->get($id, [
            'contain' => ['Relations']
        ]);

        $this->set('subject', $subject);
        $this->set('_serialize', ['subject']);
    }

    public function relations($id = null)
    {
        /* $this->Subjects->buildActiveRelation(); */
        $subject = $this->Subjects->get($id, [
          'contain' => ['Actives', 'Passives']
        ]);

	// 2nd level relations
	for($i = 0; count($subject->actives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->actives[$i]->relation
	    = $Relations->find('all', ['contain' => 'Actives'])->where(['passive_id' => $subject->actives[$i]->id]);
	}
	for($i = 0; count($subject->passives) > $i; $i++) {
	  $Relations = TableRegistry::get('Relations');
	  $subject->passives[$i]->relation
	    = $Relations->find('all', ['contain' => 'Actives'])->where(['passive_id' => $subject->passives[$i]->id]);
	}

        $this->set(compact('subject'));
        $this->set('_serialize', ['subject']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subject could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('subject'));
        $this->set('_serialize', ['subject']);
    }

    public function confirm()
    {
      $subjects = unserialize($this->Session->read('ExistingSubjects'));
      $this->set(compact('subjects'));
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
            $subject = $this->Subjects->patchEntity($subject, $this->request->data);
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subject could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('subject'));
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
	$this->Subjects->bindSubjectSearch(); // cascade deleting
        if ($this->Subjects->delete($subject)) {
            $this->Flash->success(__('The subject has been deleted.'));
        } else {
            $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
