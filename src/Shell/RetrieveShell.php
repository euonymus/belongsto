<?
namespace App\Shell;
use Cake\Console\Shell;

use Cake\Core\Configure;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use App\Model\Table\SubjectsTable;

use App\Utils\U;
use App\Utils\Wikipedia;

class RetrieveShell extends Shell
{
  public function startup()
  {
    Configure::write('Belongsto.lang',     'ja');
    Configure::write('Belongsto.lang_eng', 'eng');
    Configure::write('Belongsto.privacyMode', \App\Controller\AppController::PRIVACY_PUBLIC);
    $this->Subjects = TableRegistry::get('Subjects');
  }

  public function retrieveRelatives()
  {
    $this->Subjects->findAndSaveRelatives(100);
  }

  public function retrieveTalents($generation = 10, $page = 1)
  {
    $this->Subjects->retrieveAndSaveTalents($generation, $page);
  }

  /********************************************/
  /* Migration                                */
  /********************************************/
  public function talentCollector()
  {
    $generation = 10;
    $page_range = [1,2];

    /********* All List *********/
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,284];

    //$generation = 20;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,825];

    //$generation = 30;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,700];
    //$page_range = [701,800];
    //$generation = 30;
    //$page_range = [801,940];

    //$generation = 40;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,400];
    //$page_range = [401,500];
    //$page_range = [501,600];
    //$page_range = [601,663];

    //$generation = 50;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,300];
    //$page_range = [301,385];

    //$generation = 60;
    //$page_range = [1,100];
    //$page_range = [101,200];
    //$page_range = [201,210];

    //$generation = 70;
    //$page_range = [1,10];
    //$page_range = [11,20];
    //$page_range = [21,22];
    //$page_range = [23,106];

    //$generation = 80;
    //$page_range = [1,46];

    //$generation = 90;
    //$page_range = [1,6];
    /***************************/

    for ($page = $page_range[0]; $page <= $page_range[1]; $page++) {
      $this->retrieveTalents($generation, $page);
    }
  }

  public function politicianCollector()
  {
    $politicians = [
/*
'阿部俊子',
'阿部知子',
'逢坂誠二',
'逢沢一郎',
'安住淳',
'安藤裕',
'安倍晋三',
'伊佐進一',
'伊吹文明',
'伊東信久',
'伊東良孝',
'伊藤渉',
'伊藤信太郎',
'伊藤達也',
'伊藤忠彦',
'井坂信彦',
'井出庸生',
'井上英孝',
'井上貴博',
'井上義久',
'井上信治',
'井野俊郎',
'井林辰憲',
'稲津久',
'稲田朋美',
'浦野靖人',
'永岡桂子',
'衛藤征士郎',
'越智隆雄',
'園田博之',
'薗浦健太郎',
'遠山清彦',
'遠藤敬',
'遠藤利明',
'塩崎恭久',
'塩川鉄也',
'塩谷立',
'奥野信亮',
'奥野総一郎',
'横山博幸',
'横路孝弘',
'黄川田仁志',
'黄川田徹',
'岡下昌平',
'岡田克也',
'岡本三成',
'岡本充功',
'下村博文',
'下地幹郎',
'加藤鮎子',
'加藤寛治',
'加藤勝信',
'河井克行',
'河村建夫',
'河野正美',
'河野太郎',
'階猛',
'柿沢未途',
'角田秀穂',
'額賀福志郎',
'笠井亮',
'笠浩史',
'梶山弘志',
'鴨下一郎',
'甘利明',
'関芳弘',
'丸山穂高',
'岸信夫',
'岸田文雄',
'岸本周平',
'岩屋毅',
'岩田和親',
'鬼木誠',
'亀井静香',
'亀岡偉民',
'義家弘介',
'菊田真紀子',
'吉川貴盛',
'吉川元',
'吉村洋文',
'吉田宣弘',
'吉田泉',
'吉田豊史',
'吉野正芳',
'吉良州司',
'橘慶一郎',
'宮下一郎',
'宮腰光寛',
'宮崎岳志',
'宮崎謙介',
'宮崎政久',
'宮川典子',
'宮沢博行',
'宮内秀樹',
'宮本岳志',
'宮本徹',
'宮路拓馬',
'橋本英教',
'橋本岳',
'玉城デニー',
'玉木雄一郎',
'近藤昭一',
'近藤洋介',
'金子一義',
'金子恭之',
'金子万寿夫',
'金田勝年',
'熊田裕通',
'郡和子',
'穴見陽一',
'原口一博',
'原田義昭',
'原田憲治',
'玄葉光一郎',
'古屋圭司',
'古屋範子',
'古賀篤',
'古川元久',
'古川康',
'古川禎久',
'古田圭一',
'古本伸一郎',
'後藤田正純',
'後藤茂之',
'後藤祐一',
'御法川信英',
'工藤彰三',
'江崎鉄磨',
'江田憲司',
'江田康幸',
'江渡聡徳',
'江藤拓',
'荒井聰',
'高井崇志',
'高橋千鶴子',
'高橋比奈子',
'高市早苗',
'高村正彦',
'高鳥修一',
'高木毅',
'高木宏壽',
'高木美智代',
'高木陽介',
'穀田恵二',
'黒岩宇洋',
'今井雅人',
'今枝宗一郎',
'今村雅弘',
'今津寛',
'今野智博',
'根本幸典',
'根本匠',
'佐々木紀',
'佐々木隆博',
'佐田玄一郎',
'佐藤ゆかり',
'佐藤英道',
'佐藤勉',
'佐藤茂樹',
'左藤章',
'斎藤洋明',
'細田健一',
'細田博之',
'細野豪志',
'坂井学',
'坂本哲志',
'坂本祐之輔',
'桜田義孝',
'笹川博義',
'三ツ矢憲生',
'三ッ林裕巳',
'三原朝彦',
'山井和則',
'山下貴司',
'山口俊一',
'山口壮',
'山口泰明',
'山際大志郎',
'山田賢司',
'山田美樹',
'山尾志桜里',
'山本公一',
'山本幸三',
'山本拓',
'山本朋広',
'山本有二',
'志位和夫',
'枝野幸男',
'寺田学',
'寺田稔',
'漆原良夫',
'篠原孝',
'篠原豪',
'柴山昌彦',
'若宮健嗣',
'若狭勝',
'宗清皇一',
'秋元司',
'秋本真利',
'秋葉賢也',
'重徳和彦',
'初鹿明博',
'緒方林太郎',
'助田重義',
'勝沼栄明',
'勝俣孝明',
'升田世喜男',
'小宮山泰子',
'小熊慎司',
'小此木八郎',
'小山展弘',
'小松裕',
'小川淳也',
'小泉進次郎',
'小泉龍司',
'小倉將信',
'小沢一郎',
'小沢鋭仁',
'小池百合子',
'小田原潔',
'小島敏文',
'小野寺五典',
'小里泰弘',
'小林史明',
'小林鷹之',
'小渕優子',
'松原仁',
'松田直久',
'松島みどり',
'松本剛明',
'松本純',
'松本文明',
'松本洋平',
'松木謙公',
'松野博一',
'松野頼久',
'松浪健太',
'照屋寛徳',
'上西小百合',
'上川陽子',
'上田勇',
'上野賢一郎',
'城内実',
'新谷正義',
'新藤義孝',
'森英介',
'森山裕',
'真山祐一',
'真島省三',
'神山佐市',
'神山洋介',
'神谷昇',
'神田憲次',
'水戸将史',
'菅家一郎',
'菅義偉',
'菅原一秀',
'菅直人',
'瀬戸隆一',
'星野剛士',
'清水忠史',
'盛山正仁',
'西川公也',
'西村康稔',
'西村智奈美',
'西村明宏',
'西銘恒三郎',
'青山周平',
'青柳陽一郎',
'斉藤鉄夫',
'斉藤和子',
'石井啓一',
'石関貴史',
'石原宏高',
'石原伸晃',
'石崎徹',
'石川昭政',
'石田祝稔',
'石田真敏',
'石破茂',
'赤羽一嘉',
'赤間二郎',
'赤枝恒雄',
'赤松広隆',
'赤沢亮正',
'赤嶺政賢',
'川崎二郎',
'川端達夫',
'泉健太',
'浅尾慶一郎',
'船田元',
'前原誠司',
'前川恵',
'前田一男',
'足立康史',
'村井英樹',
'村岡敏英',
'村上誠一郎',
'太田昭宏',
'太田和美',
'大岡敏孝',
'大串正樹',
'大串博志',
'大隈和英',
'大見正',
'大口善徳',
'大西英男',
'大西健介',
'大西宏幸',
'大塚高司',
'大塚拓',
'大島敦',
'大島理森',
'大畠章宏',
'大平喜信',
'大野敬太郎',
'棚橋泰文',
'谷垣禎一',
'谷公一',
'谷川とむ',
'谷川弥一',
'谷畑孝',
'丹羽秀樹',
'丹羽雄哉',
'池田佳隆',
'池田道孝',
'池内沙織',
'馳浩',
'竹下亘',
'竹内譲',
'竹本直一',
'中根一幸',
'中根康浩',
'中山泰秀',
'中山展宏',
'中川郁子',
'中川康洋',
'中川俊直',
'中川正春',
'中村喜四郎',
'中村裕之',
'中谷元',
'中谷真一',
'中島克仁',
'中野洋昌',
'仲里利信',
'町村信孝',
'長妻昭',
'長坂康正',
'長崎幸太郎',
'長島昭久',
'長島忠美',
'長尾敬',
'津村啓介',
'津島淳',
'椎木保',
'辻元清美',
'辻清人',
'田所嘉徳',
'田村貴昭',
'田村憲久',
'田中英之',
'田中良生',
'田中和徳',
'田島一成',
'田嶋要',
'田畑毅',
'田畑裕明',
'田野瀬太道',
'渡嘉敷奈緒美',
'渡海紀三朗',
'渡辺孝一',
'渡辺周',
'渡辺博道',
'土井亨',
'土屋正忠',
'土屋品子',
'島津幸広',
'島田佳和',
'藤井比早之',
'藤丸敏',
'藤原崇',
'藤野保史',
'二階俊博',
'馬場伸幸',
'馬淵澄夫',
'梅村早江子',
'萩生田光一',
'白須賀貴樹',
'白石徹',
'畑野君枝',
'畠山和也',
'八木哲也',
'鳩山二郎',
'鳩山邦夫',
'伴野豊',
'比嘉奈津美',
'樋口尚也',
'尾身朝子',
'浜田靖一',
'富田茂之',
'冨岡勉',
*/
'冨樫博之',
'浮島とも子',
'武井俊輔',
'武正公一',
'武村展英',
'武田良太',
'武藤貴也',
'武藤容治',
'武部新',
'福井照',
'福山守',
'福田昭夫',
'福田達夫',
'福田峰之',
'福島伸享',
'平井卓也',
'平口洋',
'平将明',
'平沼赳夫',
'平沢勝栄',
'平野博文',
'保岡興治',
'豊田真由子',
'望月義夫',
'北神圭朗',
'北川知克',
'北側一雄',
'北村誠吾',
'北村茂男',
'牧義夫',
'牧原秀樹',
'牧島かれん',
'堀井学',
'堀内照文',
'堀内詔子',
'本村賢太郎',
'本村伸子',
'麻生太郎',
'桝屋敬悟',
'務台俊介',
'茂木敏充',
'木下智彦',
'木原誠二',
'木原稔',
'木村太郎',
'木村弥生',
'木内均',
'木内孝胤',
'門山宏哲',
'門博文',
'野間健',
'野中厚',
'野田佳彦',
'野田毅',
'野田聖子',
'柚木道義',
'輿水恵一',
'葉梨康弘',
'落合貴之',
'林幹雄',
'鈴木馨祐',
'鈴木貴子',
'鈴木義弘',
'鈴木憲和',
'鈴木克昌',
'鈴木俊一',
'鈴木淳司',
'鈴木隼人',
'和田義明',
'鷲尾英一郎',
'國重徹',
'國場幸之助',
'濱村進',
'濱地雅一',
'齋藤健',
'簗和生',
'髙木義明',
/*
*/
  ];

    $i = 0;
    foreach($politicians as $politician) {
      //debug($politician);
      $res = $this->Subjects->forceGetQuark($politician);
      if ($res) {
	$i++;
	debug($res->name);
      }
    }
    debug($i);
  }

  /********************************************/
  /* Movies                                   */
  /********************************************/
  public function movieCollector()
  {
    // 範囲
    $range = [1989, 1989];

    $url = '年度別日本公開映画';
    $xml = Wikipedia::readPage($url);

    $xpath = '//div[contains(@class,"mw-parser-output")]/ul';
    $element = @$xml->xpath($xpath);
    foreach ($element as $val) {
      foreach ($val->li as $val2) {
	if (!empty((string)$val2->a->attributes()->class)) continue;

	$title = (string)$val2->a->attributes()->title;
	$res = preg_match('/年の日本公開映画\z/', $title, $matches);
	if (!$res) continue;

	$path = (string)$val2->a->attributes()->href;
	$query = urldecode(preg_replace('/\/wiki\//', '', $path));
	$year = preg_replace('/年の日本公開映画\z/', '', $query);
	if ( ($year < $range[0]) || ($year > $range[1]) ) continue;

	$this->movieCollectorByGeneration($query);
      }
    }
  }

  public function movieCollectorByGeneration($query)
  {
    $xml = Wikipedia::readPage($query);

    $xpath = '//div[contains(@class,"mw-parser-output")]/ul';
    $element = @$xml->xpath($xpath);
    foreach ($element as $val) {
      foreach($val->li as $val2) {
	$res = preg_match('/\d{1,2}日/', (string)$val2, $matches);
	if (!$res) continue;

	foreach ($val2->ul->li as $val3) {
	  if (!empty((string)$val3->a->attributes()->class)) continue;
	  $path = (string)$val3->a->attributes()->href;
	  $query = urldecode(preg_replace('/\/wiki\//', '', $path));
	  $this->movieCollectorByTitle($query);
	}
      }
    }
  }

  public function movieCollectorByTitle($query)
  {
// TODO
    debug($query);
    /* $this->Subjects->retrieveAndSaveMovie($query); */
  }

}
