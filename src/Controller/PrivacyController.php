<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Privacy Controller
 *
 * @property \App\Model\Table\PrivacyTable $Privacy
 */
class PrivacyController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
      $title = 'Privacy Policy';
      $this->set(compact('title', 'pickups'));
    }
}
