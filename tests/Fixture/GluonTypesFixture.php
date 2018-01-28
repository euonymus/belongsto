<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GluonTypesFixture
 *
 */
class GluonTypesFixture extends TestFixture
{

    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'gluon_types'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'name' => 'nationality',
            'caption' => 'from',
            'caption_ja' => '国籍',
            'sort' => 79,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 2,
            'name' => 'childOf',
            'caption' => 'is a child of',
            'caption_ja' => 'の子供',
            'sort' => 4,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 3,
            'name' => 'sonOf',
            'caption' => 'is a son of',
            'caption_ja' => 'の息子',
            'sort' => 2,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 4,
            'name' => 'daughterOf',
            'caption' => 'is a daughter of',
            'caption_ja' => 'の娘',
            'sort' => 3,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 5,
            'name' => 'siblingOf',
            'caption' => 'is a sibling of',
            'caption_ja' => 'の兄弟（姉妹）',
            'sort' => 31,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 6,
            'name' => 'twinsOf',
            'caption' => 'is a twin of',
            'caption_ja' => 'と双子',
            'sort' => 32,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 7,
            'name' => 'brotherOf',
            'caption' => 'is a brother of',
            'caption_ja' => 'の兄弟',
            'sort' => 5,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 8,
            'name' => 'sisterOf',
            'caption' => 'is a sister of',
            'caption_ja' => 'の姉妹',
            'sort' => 6,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 9,
            'name' => 'grandchildOf',
            'caption' => 'is a grandchild of',
            'caption_ja' => 'の孫',
            'sort' => 7,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 10,
            'name' => 'greatGrandchildOf',
            'caption' => 'is a great grandchild of',
            'caption_ja' => 'のひ孫',
            'sort' => 33,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 11,
            'name' => 'cousinOf',
            'caption' => 'is a cousin of',
            'caption_ja' => 'のいとこ',
            'sort' => 34,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 12,
            'name' => 'descendantOf',
            'caption' => 'is a descendant of',
            'caption_ja' => 'の子孫',
            'sort' => 35,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 13,
            'name' => 'adoptedChildOf',
            'caption' => 'is an adopted child of',
            'caption_ja' => 'の養子',
            'sort' => 36,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 14,
            'name' => 'relatedTo',
            'caption' => 'is related to',
            'caption_ja' => 'と血縁関係にある',
            'sort' => 8,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 15,
            'name' => 'wifeOf',
            'caption' => 'is a wife of',
            'caption_ja' => 'の妻',
            'sort' => 1,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 16,
            'name' => 'concubineOf',
            'caption' => 'is a concubine of',
            'caption_ja' => 'の妾',
            'sort' => 37,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 17,
            'name' => 'datingWith',
            'caption' => 'is dating with',
            'caption_ja' => 'の恋人',
            'sort' => 38,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 18,
            'name' => 'immoralRelationWith',
            'caption' => 'is in immoral relation with',
            'caption_ja' => 'と不倫関係',
            'sort' => 39,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 19,
            'name' => 'inLawFamilyOf',
            'caption' => 'is in law family of',
            'caption_ja' => 'と養子縁組家族',
            'sort' => 9,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 20,
            'name' => 'friendOf',
            'caption' => 'is a friend of',
            'caption_ja' => 'の友人',
            'sort' => 40,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 21,
            'name' => 'apprenticeOf',
            'caption' => 'is an apprentice of',
            'caption_ja' => 'の弟子',
            'sort' => 43,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 22,
            'name' => 'knows',
            'caption' => 'knows',
            'caption_ja' => 'の知人',
            'sort' => 41,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 23,
            'name' => 'graduateOf',
            'caption' => 'was graduated from',
            'caption_ja' => 'を卒業した',
            'sort' => 10,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 24,
            'name' => 'masterDegreeOf',
            'caption' => 'has a master degree of',
            'caption_ja' => '院を卒業した',
            'sort' => 44,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 25,
            'name' => 'studiedAt',
            'caption' => 'studied at',
            'caption_ja' => 'に就学する',
            'sort' => 45,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 26,
            'name' => 'memberOf',
            'caption' => 'is a member of',
            'caption_ja' => 'のメンバー',
            'sort' => 27,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 27,
            'name' => 'affiliation',
            'caption' => 'is affiliated to',
            'caption_ja' => 'に所属',
            'sort' => 26,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 28,
            'name' => 'worksFor',
            'caption' => 'works for',
            'caption_ja' => 'に勤務',
            'sort' => 11,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 29,
            'name' => 'colleague',
            'caption' => 'is a colleague of',
            'caption_ja' => 'の同僚',
            'sort' => 42,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 30,
            'name' => 'vocalOf',
            'caption' => 'is a vocal of',
            'caption_ja' => 'のボーカリスト',
            'sort' => 46,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 31,
            'name' => 'guitaristOf',
            'caption' => 'is a guitarist of',
            'caption_ja' => 'のギタリスト',
            'sort' => 47,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 32,
            'name' => 'bassistOf',
            'caption' => 'is a bassist of',
            'caption_ja' => 'のベーシスト',
            'sort' => 48,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 33,
            'name' => 'keyboardistOf',
            'caption' => 'is a keyboardist of',
            'caption_ja' => 'のキーボーディスト',
            'sort' => 49,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 34,
            'name' => 'drummerOf',
            'caption' => 'is a drummer of',
            'caption_ja' => 'のドラマー',
            'sort' => 50,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 35,
            'name' => 'dancerOf',
            'caption' => 'is a dancer of',
            'caption_ja' => 'のダンサー',
            'sort' => 51,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 36,
            'name' => 'founderOf',
            'caption' => 'is a founder of',
            'caption_ja' => 'の創業者',
            'sort' => 13,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 37,
            'name' => 'ceoOf',
            'caption' => 'is ceo of',
            'caption_ja' => 'のCEO',
            'sort' => 12,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 38,
            'name' => 'boardMemberOf',
            'caption' => 'is a boardMember of',
            'caption_ja' => 'の役員',
            'sort' => 14,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 39,
            'name' => 'ministerOf',
            'caption' => 'is minister of',
            'caption_ja' => 'の大臣',
            'sort' => 54,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 40,
            'name' => 'headOf',
            'caption' => 'is the head of',
            'caption_ja' => 'の責任者',
            'sort' => 55,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 41,
            'name' => 'coachOf',
            'caption' => 'is a coach of',
            'caption_ja' => 'のコーチ',
            'sort' => 56,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 42,
            'name' => 'funderOf',
            'caption' => 'is funder of',
            'caption_ja' => 'に出資',
            'sort' => 24,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 43,
            'name' => 'parentOrganizationOf',
            'caption' => 'is parent organization of',
            'caption_ja' => 'の親会社',
            'sort' => 57,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 44,
            'name' => 'subOrganizationOf',
            'caption' => 'is sub organization of',
            'caption_ja' => '傘下の組織',
            'sort' => 18,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 45,
            'name' => 'subFamilyOf',
            'caption' => 'is sub family of',
            'caption_ja' => 'の支流家族',
            'sort' => 58,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 46,
            'name' => 'owns',
            'caption' => 'owns',
            'caption_ja' => 'を所有',
            'sort' => 16,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 47,
            'name' => 'runs',
            'caption' => 'runs',
            'caption_ja' => 'を運営する',
            'sort' => 15,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 48,
            'name' => 'established',
            'caption' => 'established',
            'caption_ja' => 'を設立した',
            'sort' => 17,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 49,
            'name' => 'acquisition',
            'caption' => 'made acquisition with',
            'caption_ja' => 'を買収',
            'sort' => 59,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 50,
            'name' => 'acquiredBy',
            'caption' => 'was acquired by',
            'caption_ja' => 'に買収された',
            'sort' => 60,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 51,
            'name' => 'departmentOf',
            'caption' => 'is a department of',
            'caption_ja' => 'の内部無局',
            'sort' => 61,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 52,
            'name' => 'brandBy',
            'caption' => 'is a brand by',
            'caption_ja' => 'のブランド',
            'sort' => 76,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 53,
            'name' => 'locatedAt',
            'caption' => 'is located at',
            'caption_ja' => 'に所在',
            'sort' => 78,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 54,
            'name' => 'creatorOf',
            'caption' => 'is the creator of',
            'caption_ja' => 'の作者',
            'sort' => 62,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 55,
            'name' => 'authorOf',
            'caption' => 'is the author of',
            'caption_ja' => 'の著者',
            'sort' => 63,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 56,
            'name' => 'artistOf',
            'caption' => 'is the artist of',
            'caption_ja' => 'の制作者',
            'sort' => 64,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 57,
            'name' => 'producerOf',
            'caption' => 'is the producer of',
            'caption_ja' => 'のプロデューサー',
            'sort' => 65,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 58,
            'name' => 'directorOf',
            'caption' => 'is a director of',
            'caption_ja' => 'のディレクター',
            'sort' => 20,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 59,
            'name' => 'publisherOf',
            'caption' => 'is the publisher of',
            'caption_ja' => 'の出版社',
            'sort' => 66,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 60,
            'name' => 'productionCompanyOf',
            'caption' => 'is the production company of',
            'caption_ja' => 'のプロダクション会社',
            'sort' => 67,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 61,
            'name' => 'contributorOf',
            'caption' => 'is a contributor of',
            'caption_ja' => 'の貢献者',
            'sort' => 21,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 62,
            'name' => 'actorOf',
            'caption' => 'is an actor of',
            'caption_ja' => 'に出演',
            'sort' => 19,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 63,
            'name' => 'performed',
            'caption' => 'performed in',
            'caption_ja' => 'に出演',
            'sort' => 52,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 64,
            'name' => 'playsAt',
            'caption' => 'plays at',
            'caption_ja' => 'に所属',
            'sort' => 53,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 65,
            'name' => 'characterOf',
            'caption' => 'is a character of',
            'caption_ja' => 'のキャラクター',
            'sort' => 23,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 66,
            'name' => 'isBasedOn',
            'caption' => 'is based on',
            'caption_ja' => 'を原作とする',
            'sort' => 22,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 67,
            'name' => 'track',
            'caption' => 'is a track in',
            'caption_ja' => 'のトラック',
            'sort' => 77,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 68,
            'name' => 'manufacturerOf',
            'caption' => 'is a manufacturer of',
            'caption_ja' => 'の開発者',
            'sort' => 68,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 69,
            'name' => 'manufacturedBy',
            'caption' => 'is manufactured by',
            'caption_ja' => 'により開発された',
            'sort' => 69,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 70,
            'name' => 'organizerOf',
            'caption' => 'is an organizer of',
            'caption_ja' => 'を主宰',
            'sort' => 70,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 71,
            'name' => 'attendeeOf',
            'caption' => 'is an attendee of',
            'caption_ja' => 'に出席',
            'sort' => 71,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 72,
            'name' => 'isElected',
            'caption' => 'is elected',
            'caption_ja' => 'に当選',
            'sort' => 25,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 73,
            'name' => 'participated',
            'caption' => 'participated',
            'caption_ja' => 'に参画',
            'sort' => 72,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 74,
            'name' => 'executed',
            'caption' => 'executed',
            'caption_ja' => 'を実施',
            'sort' => 73,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 75,
            'name' => 'achieved',
            'caption' => 'achieved',
            'caption_ja' => 'を達成',
            'sort' => 74,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 76,
            'name' => 'isAs',
            'caption' => 'is',
            'caption_ja' => 'である',
            'sort' => 29,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 77,
            'name' => 'isOneOf',
            'caption' => 'is one of',
            'caption_ja' => 'のひとつ',
            'sort' => 28,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 78,
            'name' => 'isFrom',
            'caption' => 'is from',
            'caption_ja' => 'の出身',
            'sort' => 75,
            'created' => null,
            'modified' => null
        ],
        [
            'id' => 79,
            'name' => 'worksAs',
            'caption' => 'works as',
            'caption_ja' => 'として活動',
            'sort' => 30,
            'created' => null,
            'modified' => null
        ],
    ];
}
