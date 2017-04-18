<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function display()
    {
      $lang_now = AppController::$lang;
      $lang_eng = AppController::LANG_ENG;

      if ($lang_now == $lang_eng) {
	$title = 'Search hidden relations on your favorite things, people, company...';
      } else {
	$title = '気になる人、物、会社の隠れた関係を見つけよう';
      }


      // Pickup contents
      $pickup_ids = [
		     'ed2826db-028b-48eb-9db1-919dafcc33aa' => 'passive', // 籠池 町浪: 話題の人
		     '006f7220-a171-41f6-ab7d-13019f42375c' => 'active',  // 明治維新:  歴史
		     '25e6d34b-38b1-4586-97f5-f130fff1b9a0' => 'active',  // iPhone:   ガジェット
		     '1818e992-3d0d-4958-8fcd-dd703930a3ba' => 'passive', // SMBC:     投資会社
		     '493009cd-9c63-400c-8c15-9ac7b7995879' => 'passive', // Google:   大企業
		     'faea45fc-ee7c-442e-88ef-031f35c92440' => 'active',  // ハーバード: 学校
		     '624ce77c-d825-4ae2-9778-15673374f478' => 'active',  // マンジーニ: ドラマー
		     '0886067b-6b82-4ffe-8d5b-5c216f84ad00' => 'active',  // 大統領
		     ];
      $Subjects = TableRegistry::get('Subjects');
      $pickups = $Subjects->find('all', ['conditions' => ['Subjects.id in' => array_keys($pickup_ids)]])->limit(8);
      $pickups = self::picupsOrder($pickups, $pickup_ids);

      $this->set(compact('title', 'pickups'));
    }

    public static function picupsOrder($pickups, $indicator)
    {
      $res = [];
      foreach($indicator as $key => $type) {
	foreach($pickups as $pickup) {
	  if ($key == $pickup->id) {
	    $pickup->type = $type;
	    $res[] = $pickup;
	  }
	}
      }
      return $res;
    }
}
