<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Relations Controller
 *
 * @property \App\Model\Table\RelationsTable $Relations
 */
class RelationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Subjects', 'Objects']
        ];
        $relations = $this->paginate($this->Relations);

        $this->set(compact('relations'));
        $this->set('_serialize', ['relations']);
    }

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
            'contain' => ['Subjects', 'Objects']
        ]);

        $this->set('relation', $relation);
        $this->set('_serialize', ['relation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $relation = $this->Relations->newEntity();
        if ($this->request->is('post')) {
            $relation = $this->Relations->patchEntity($relation, $this->request->data);
            if ($this->Relations->save($relation)) {
                $this->Flash->success(__('The relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The relation could not be saved. Please, try again.'));
            }
        }
        $subjects = $this->Relations->Subjects->find('list', ['limit' => 200]);
        $objects = $this->Relations->Objects->find('list', ['limit' => 200]);
        $this->set(compact('relation', 'subjects', 'objects'));
        $this->set('_serialize', ['relation']);
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
                $this->Flash->success(__('The relation has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The relation could not be saved. Please, try again.'));
            }
        }
        $subjects = $this->Relations->Subjects->find('list', ['limit' => 200]);
        $objects = $this->Relations->Objects->find('list', ['limit' => 200]);
        $this->set(compact('relation', 'subjects', 'objects'));
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
            $this->Flash->success(__('The relation has been deleted.'));
        } else {
            $this->Flash->error(__('The relation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
