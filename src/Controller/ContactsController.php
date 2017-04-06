<?php
namespace App\Controller;

use App\Form\ContactForm;

class ContactsController extends AppController
{
    public function index()
    {
        $contact = new ContactForm();

        if ($this->request->is('post')) {
            if ($contact->execute($this->request->data)) {
                $this->_setFlash(__('The email has been sent.')); 
            } else {
                $this->_setFlash(__('Validation error.'), true); 
            }
        }
	$title = $this->LangMngr->txt('Contact us', 'お問い合わせ');

        $this->set(compact('contact', 'title'));
        $this->set('_serialize', ['subject']);
   }
}