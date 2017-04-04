<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Network\Email\Email;

class ContactForm extends Form
{

    // Defining schema for the contact form
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    // Defining validation settings
    protected function _buildValidator(Validator $validator)
    {
        return $validator
	  //->add('name', 'length', [
          //      'rule' => ['minLength', 1],
          //      'message' => 'name is required'
          //  ])
	  ->requirePresence('name', 'create')
	  ->notEmpty('name', 'name is required')
	  ->requirePresence('organization', 'create')
	  ->notEmpty('organization', 'organization is required')
	  ->requirePresence('department', 'create')
	  ->notEmpty('department', 'department is required')
	  ->requirePresence('email', 'create')
	  ->add('email', 'format', [
                'rule' => 'email',
                'message' => 'input email address here',
            ])
          ->requirePresence('topic', 'create')
          ->notEmpty('topic', 'topic is required')
	  ->requirePresence('body', 'create')
	  ->notEmpty('body', 'body is required');
    }

    // execution after validation
    protected function _execute(array $data)
    {
        $body = 
	  'Name: ' . $data['name'] . "\n" .
	  'Organization: ' . $data['organization'] . "\n" .
	  'Department: ' . $data['department'] . "\n" .
	  'Email: ' . $data['email'] . "\n" .
	  'Topic: ' . $data['topic'] . "\n\n" .
	  '[Body]' . "\n" .
	  $data['body'];

        // メールを送信する
        $email = new Email('default');
        $email->from([$data['email'] => $data['name']])
            ->to('info@gluons.link')
            ->subject('gluons: message from contact form')
            ->send($body);
        return true;
    }
}
