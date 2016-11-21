<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\TableRegistry;

/**
 * Relations Controller
 *
 * @property \App\Model\Table\RelationsTable $Relations
 */
class RelationsController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id Relation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $relation = $this->Relations->get($id, [
            'contain' => ['Actives', 'Passives']
        ]);

        $this->set('relation', $relation);
        $this->set('_serialize', ['relation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($active_id = null)
    {
        $ready_for_save = false;

        $Subjects = TableRegistry::get('Subjects');

        // Session check
        $this->Session->delete('ExistingSubjectsForRelation');
        $session_relation = unserialize($this->Session->read('SavingRelation'));
	if ($session_relation) {
	  $this->Session->delete('SavingRelation');
	  $active_id = $session_relation['active_id'];
	  $this->request->data = $session_relation;
	}
        $session_passive_id = unserialize($this->Session->read('SavingPassiveId'));
	if ($session_passive_id !== false) {
	  $this->Session->delete('SavingPassiveId');

	  if ($session_passive_id != '0') $ready_for_save = true;
	}

        // Existence check
        if ($this->request->is('post')) {
	  $this->request->data['active_id'] = $active_id;

	  $query = $Subjects->search($this->request->data['passive']);
	  if (iterator_count($query)) {
	    $this->Session->write('ExistingSubjectsForRelation', serialize($query->toArray()));
	    $this->Session->write('SavingRelation', serialize($this->request->data));
	    return $this->redirect(['action' => 'confirm']);
	  }
	}

	// Save New Subject for the passive_id
        if ($this->request->is('post') || 
	    (($session_passive_id !== false) && ($session_passive_id == '0'))
	    ) {

	    $saving_subject = [
			       'image_path' => '',
			       'description' => '',
			       'start' => [
					   'year' => '',
					   'month' => '',
					   'day' => '',
					   'hour' => '',
					   'minute' => ''
					   ],
			       'end' => [
					 'year' => '',
					 'month' => '',
					 'day' => '',
					 'hour' => '',
					 'minute' => ''
					 ],
			       'start_accuracy' => '',
			       'end_accuracy' => '',
			       'is_momentary' => '0'
			       ];
	    $saving_subject['name'] = $this->request->data['passive'];

            $subject = $Subjects->formToSaving($saving_subject);
            if ($savedSubject = $Subjects->save($subject)) {
                $this->_setFlash(__('The quark has been saved.')); 
		$session_passive_id = $savedSubject->id;
            } else {
                $this->_setFlash(__('The quark could not be saved. Please, try again.'), true); 
            }
	    $ready_for_save = true;
	}


        $relation = $this->Relations->newEntity();
        if ($ready_for_save) {

            $this->request->data['passive_id'] = $session_passive_id;
            /* $relation = $this->Relations->patchEntity($relation, $this->request->data); */
            $relation = $this->Relations->formToSaving($this->request->data);
            if ($this->Relations->save($relation)) {
                $this->_setFlash(__('The gluon has been saved.')); 

                return $this->redirect(['controller' => 'subjects', 'action' => 'relations', $active_id]);
            } else {
                $this->_setFlash(__('The gluon could not be saved. Please, try again.'), true); 
            }
        }
	$active = $Subjects->get($active_id, ['contain' => 'Actives']);
        $passives = $this->Relations->Passives->find('list', ['limit' => 200]);


	$title = 'Add new gluon';
        $this->set(compact('relation', 'active', 'passives', 'title'));
        $this->set('_serialize', ['relation']);
    }

    public function confirm()
    {
        $subjects = unserialize($this->Session->read('ExistingSubjectsForRelation'));
        $saving = unserialize($this->Session->read('SavingRelation'));

        if ($this->request->is('post')) {
	  $this->Session->write('SavingPassiveId', serialize($this->request->data['passive_id']));
	  return $this->redirect(['action' => 'add']);
        }

	$Actives = TableRegistry::get('Subjects');
	$active = $Actives->get($saving['active_id']);
	$title = 'Adding new gluon on '. $active->name;

        $this->set(compact('subjects', 'title'));
        $this->set('_serialize', ['subjects']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Relation id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $relation = $this->Relations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $relation = $this->Relations->patchEntity($relation, $this->request->data);
            if ($this->Relations->save($relation)) {
                $this->_setFlash(__('The gluon has been saved.')); 

                return $this->redirect(['action' => 'index']);
            } else {
                $this->_setFlash(__('The gluon could not be saved. Please, try again.'), true); 
            }
        }
        $actives = $this->Relations->Actives->find('list', ['limit' => 200]);
        $passives = $this->Relations->Passives->find('list', ['limit' => 200]);
        $this->set(compact('relation', 'actives', 'passives'));
        $this->set('_serialize', ['relation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Relation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $relation = $this->Relations->get($id);
        if ($this->Relations->delete($relation)) {
            $this->_setFlash(__('The gluon has been deleted.')); 
        } else {
            $this->_setFlash(__('The gluon could not be deleted. Please, try again.'), true); 
        }

        return $this->redirect(['action' => 'index']);
    }
}
