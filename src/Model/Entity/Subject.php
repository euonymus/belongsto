<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subject Entity
 *
 * @property string $id
 * @property string $name
 * @property string $image_path
 * @property string $description
 * @property \Cake\I18n\Time $start
 * @property \Cake\I18n\Time $end
 * @property string $start_accuracy
 * @property string $end_accuracy
 * @property bool $is_momentary
 * @property string $url
 * @property string $affiliate
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Relation[] $relations
 */
class Subject extends Entity
{
    /* human */
    const TYPE_BUNKER               = 1; /* 銀行家 */
    const TYPE_ARISTOCRACY          = 2; /* 貴族 */
    const TYPE_POLITICIAN           = 3; /* 政治家 */
    const TYPE_MILITARY_PERSON      = 4; /* 軍事 */
    const TYPE_BUSINESS_PERSON      = 5; /* 実業家 */

    const TYPE_SCIENTIST            = 11; /* 科学者 */
    const TYPE_WRITER               = 12; /* 作家 */
    const TYPE_MUSICIAN             = 13; /* 音楽家 */
    const TYPE_COMEDIAN             = 14; /* コメディアン */
    const TYPE_PAINTER              = 15; /* 画家 */
    const TYPE_ATHLETE              = 16; /* アスリート */
    const TYPE_ACTOR                = 17; /* 俳優 */
    const TYPE_VOICE_ACTOR          = 18; /* 声優 */
    const TYPE_PHOTOGRAPHER         = 19; /* 写真家 */

    const TYPE_PERSON               = 99; /* 一般人 */

    /* group of people */
    const TYPE_BUNK                 = 100; /* 銀行 */
    const TYPE_COUNTRY              = 101; /* 国 */
    const TYPE_GOVERNMENT           = 102; /* 政府 */
    const TYPE_MILITARY_SERVICE     = 103; /* 軍隊 */
    const TYPE_COMPANY              = 104; /* 会社 */
    const TYPE_SCHOOL               = 105; /* 学校 */

    /* creative */
    const TYPE_PRODUCT             = 1000;  /* 製品 */

    const TYPE_BOOK_ORIGINAL        = 1001;  /* 本（原作） */
    const TYPE_BOOK_DERIVATIVE      = 1002;  /* 原作を元にする本 */

    const TYPE_MOVIE_ORIGINAL       = 1011;  /* 映画（原作） */
    const TYPE_MOVIE_DERIVATIVE     = 1012;  /* 原作を元にする映画 */

    const TYPE_MANGA_ORIGINAL       = 1021;  /* 原作漫画 */
    const TYPE_MANGA_DERIVATIVE     = 1022;  /* 原作を元にする漫画 */

    const TYPE_ANIME_TV_ORIGINAL    = 1031;  /* テレビシリーズ（原作） */
    const TYPE_ANIME_TV_DERIVATIVE  = 1032;  /* 原作を元にするテレビアニメ */

    const TYPE_ANIME_OVA_ORIGINAL   = 1041;  /* OVA（原作） */
    const TYPE_ANIME_OVA_DERIVATIVE = 1042;  /* 原作を元にするOVA */

    const TYPE_ANIME_MV_ORIGINAL    = 1051;  /* アニメ映画（原作） */
    const TYPE_ANIME_MV_DERIVATIVE  = 1052;  /* 原作を元にするアニメ映画 */

    /* character */
    const TYPE_CHARACTER            = 2000;  /* 登場人物 */

    // type lists
    public static $typeListHuman = [
				    self::TYPE_BUNKER,
				    self::TYPE_ARISTOCRACY,
				    self::TYPE_POLITICIAN,
				    self::TYPE_MILITARY_PERSON,
				    self::TYPE_BUSINESS_PERSON,
				    self::TYPE_SCIENTIST,
				    self::TYPE_WRITER,
				    self::TYPE_MUSICIAN,
				    self::TYPE_COMEDIAN,
				    self::TYPE_PAINTER,
				    self::TYPE_ATHLETE,
				    self::TYPE_ACTOR,
				    self::TYPE_VOICE_ACTOR,
				    self::TYPE_PHOTOGRAPHER,
				    self::TYPE_PERSON,
				    ];

    public static $typeListGroup = [
				    self::TYPE_BUNK,
				    self::TYPE_COUNTRY,
				    self::TYPE_GOVERNMENT,
				    self::TYPE_MILITARY_SERVICE,
				    self::TYPE_COMPANY,
				    self::TYPE_SCHOOL,
				    ];

    public static $typeListCreative = [
				    self::TYPE_PRODUCT,
				    self::TYPE_BOOK_ORIGINAL,
				    self::TYPE_BOOK_DERIVATIVE,
				    self::TYPE_MOVIE_ORIGINAL,
				    self::TYPE_MOVIE_DERIVATIVE,
				    self::TYPE_MANGA_ORIGINAL,
				    self::TYPE_MANGA_DERIVATIVE,
				    self::TYPE_ANIME_TV_ORIGINAL,
				    self::TYPE_ANIME_TV_DERIVATIVE,
				    self::TYPE_ANIME_OVA_ORIGINAL,
				    self::TYPE_ANIME_OVA_DERIVATIVE,
				    self::TYPE_ANIME_MV_ORIGINAL,
				    self::TYPE_ANIME_MV_DERIVATIVE,
				    self::TYPE_CHARACTER,
				    ];

    public static $typeListMomentaries = [
				    self::TYPE_BOOK_ORIGINAL,
				    self::TYPE_BOOK_DERIVATIVE,
				    self::TYPE_MOVIE_ORIGINAL,
				    self::TYPE_MOVIE_DERIVATIVE,
				    self::TYPE_ANIME_MV_ORIGINAL,
				    self::TYPE_ANIME_MV_DERIVATIVE,
				    self::TYPE_CHARACTER,
				    ];
    public static $typeListBooks = [
				    self::TYPE_BOOK_ORIGINAL,
				    self::TYPE_BOOK_DERIVATIVE,
				    ];
    public static $typeListMangas = [
				    self::TYPE_MANGA_ORIGINAL,
				    self::TYPE_MANGA_DERIVATIVE,
				    ];


    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function momentaryByType($type)
    {
      return in_array($type, self::$typeListMomentaries);
    }

    public static function isPersonByType($type)
    {
      return in_array($type, self::$typeListHuman);
    }

    /***********************************/
    /* schema_org                      */
    /***********************************/
    const SIDES_FORWARD  = 1;
    const SIDES_BACKWARD = 2;
    public function filterForGluonType($gluonTypeArr, $targetSides)
    {
      if (!in_array($targetSides, [self::SIDES_FORWARD, self::SIDES_BACKWARD])) return false;
      foreach ($gluonTypeArr as $gluon_type_id => $sides) {
	if (($this->_joinData->gluon_type_id == $gluon_type_id) && in_array($sides, [0,$targetSides])) {
	  return $this;
	}
      }
      return false;
    }
}
