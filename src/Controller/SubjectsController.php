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
    public function index()
    {
        $subjects = $this->paginate($this->Subjects, ['contain' => 'Actives']);
	$title = 'quarks that gluons hold';

        $this->set(compact('subjects', 'title'));
        $this->set('_serialize', ['subjects']);
    }

    public function search()
    {
      if (!array_key_exists('keywords', $this->request->query)) $this->redirect('/');

      $subjects = $this->Subjects->search($this->request->query['keywords']);

      $title = $this->request->query['keywords'] . 'の関係図検索結果';
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
    public function relations($id = null)
    {
	$subject = $this->Subjects->getRelations($id, ['Actives', 'Passives'], 2);
	if (!$subject) $this->redirect('/');

	$title = $subject->name . 'と関連組織、人間関係、繋がり';
        $this->set(compact('subject', 'title'));
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
            if ($savedSubject = $this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'relations', $savedSubject->id]);
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


            $subject = $this->Subjects->formToEditing($subject, $this->request->data);
            if ($savedSubject = $this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'relations', $savedSubject->id]);
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

        if ($this->Subjects->delete($subject)) {
            $this->Flash->success(__('The subject has been deleted.'));
        } else {
            $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Subjects', 'action' => 'index']);
    }
}
