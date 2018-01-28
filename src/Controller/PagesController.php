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

      // Pickup contents
      $en_pickup_ids = [
		     'b96a6ce9-cb03-4091-a7d9-a6eb2aa94f3b' => 'active',  // Donald Trump's Strategic and Policy Forum
		     '006f7220-a171-41f6-ab7d-13019f42375c' => 'active',  // 明治維新:  歴史
		     '25e6d34b-38b1-4586-97f5-f130fff1b9a0' => 'active',  // iPhone:   ガジェット
		     'd6484654-8c9b-44d3-b400-83e156a83dc2' => 'passive', // Y Combinator
		     'cf873581-5d92-44ed-b205-cb016e2de6d8' => 'active',  // Rothschild & co
		     '80728b23-9b10-4d0c-b010-e53e742eed8a' => 'active',  // Shinzo Abe
		     'eff387d7-8ec9-467a-ab6f-c72310ba6c4d' => 'active',  // Black Sabbath
		     '0886067b-6b82-4ffe-8d5b-5c216f84ad00' => 'active',  // 大統領
		     ];

      $ja_pickup_ids = [
		     'df03fae8-16b0-4ba8-8309-d5ca64c1eb28' => 'active',  // NEM不正送金事件
		     'f517ec88-e6a7-4592-b2dd-22b6d2cc17bd' => 'active',  // 火星（ファソン15）
		     '1cb8d7a5-8297-4001-acfc-337d4e971fd8' => 'passive', // 51量子ビットをもった量子コンピュータ
		     '78a3854f-d2c6-4494-9b1c-820ff1ccd0a9' => 'active',  // 第4次安倍内閣
		     'be01bc00-ad55-426a-8e5c-35b8c7358710' => 'active',  // 第48回衆議院議員総選挙
		     '3bd11ac9-b39e-4400-b25e-e177299719e6' => 'active',  // 豊田真由子
		     'df1cd605-00b9-4db5-9a31-9330cc41aaf8' => 'active',  // 豊田三郎
		     '6257e52a-f888-4d4c-a4c2-18e4cccfa94c' => 'active',  // 共謀罪
		     //'3e1520f8-211a-46df-a3e2-bfc3cf51bba4' => 'active',  // 八島洋子
		     //'d5465d59-18b3-40ba-8522-3eb95d1e8e40' => 'active',  // 野田数
		     //'7faa51c3-623f-4821-937a-b9511139491f' => 'passive', // 「テロ等準備罪で逮捕すべし！」投稿
		     //'c8055e49-a5bf-488e-afeb-6c5249fbb16e' => 'active',  // 第3次安倍内閣 (第3次改造)
		     //'0db33165-dac4-4398-81e0-cb9aeb1e05f3' => 'active',  // 平慶翔
		     //'48e5c92d-d6dd-41fb-88f9-8245b578181f' => 'active',  // 山口敬之
		     //'a54ab8db-4d79-43fe-8e01-3ea37503a2ae' => 'active',  // タカタ株式会社
		     //'9e8ab1fe-dba9-43f7-a302-fb4838978060' => 'active',  // 山﨑夕貴
		     //'90be0840-5a7e-439b-ae3d-30e41f7ee1bb' => 'passive', // 小出恵介
		     //'c1e9c2e2-4f78-4e36-8629-9e99bfc40005' => 'active',  // 福岡金塊強奪事件
		     //'aa0ca65b-bcb5-4014-b04e-d2b6d8346dc2' => 'passive', // 西山茉希
		     //'5abdaf6d-d34a-44b9-874d-5fb6d4544ed5' => 'passive', // 加計学園
		     //'e6bf3f6b-0042-4ec4-b665-c6005817e8e6' => 'passive', // 眞子内親王
		     //'0886067b-6b82-4ffe-8d5b-5c216f84ad00' => 'active',  // 大統領
		     //'493009cd-9c63-400c-8c15-9ac7b7995879' => 'passive', // Google:   大企業
		     //'faea45fc-ee7c-442e-88ef-031f35c92440' => 'active',  // ハーバード: 学校
		     //'eff387d7-8ec9-467a-ab6f-c72310ba6c4d' => 'active',  // ブラックサバス
		     ];

      if ($lang_now == $lang_eng) {
	$title = 'Search hidden relations on your favorite things, people, company...';
	$pickup_ids = $en_pickup_ids;
      } else {
	$title = '気になる人、物、会社の隠れた関係を見つけよう';
	$pickup_ids = $ja_pickup_ids;
      }

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
