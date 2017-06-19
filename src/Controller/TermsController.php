<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Terms Controller
 *
 * @property \App\Model\Table\TermsTable $Terms
 */
class TermsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
      $title = 'Terms of Service';
      $this->set(compact('title', 'pickups'));
    }
}
