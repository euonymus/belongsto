<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GluonTypesFixture
 *
 */
class GluonTypesFixture extends TestFixture
{
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
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 2,
            'name' => 'childOf',
            'caption' => 'is a child of',
            'caption_ja' => 'の子供',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 3,
            'name' => 'sonOf',
            'caption' => 'is a son of',
            'caption_ja' => 'の息子',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 4,
            'name' => 'daughterOf',
            'caption' => 'is a daughter of',
            'caption_ja' => 'の娘',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 5,
            'name' => 'siblingOf',
            'caption' => 'is a sibling of',
            'caption_ja' => 'の兄弟（姉妹）',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 6,
            'name' => 'twinsOf',
            'caption' => 'is a twin of',
            'caption_ja' => 'と双子',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 7,
            'name' => 'brotherOf',
            'caption' => 'is a brother of',
            'caption_ja' => 'の兄弟',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 8,
            'name' => 'sisterOf',
            'caption' => 'is a sister of',
            'caption_ja' => 'の姉妹',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 9,
            'name' => 'grandchildOf',
            'caption' => 'is a grandchild of',
            'caption_ja' => 'の孫',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 10,
            'name' => 'greatGrandchildOf',
            'caption' => 'is a great grandchild of',
            'caption_ja' => 'のひ孫',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 11,
            'name' => 'cousinOf',
            'caption' => 'is a cousin of',
            'caption_ja' => 'のいとこ',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 12,
            'name' => 'descendantOf',
            'caption' => 'is a descendant of',
            'caption_ja' => 'の子孫',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 13,
            'name' => 'adoptedChildOf',
            'caption' => 'is an adopted child of',
            'caption_ja' => 'の養子',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 14,
            'name' => 'relatedTo',
            'caption' => 'is related to',
            'caption_ja' => 'と血縁関係にある',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 15,
            'name' => 'wifeOf',
            'caption' => 'is a wife of',
            'caption_ja' => 'の妻',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 16,
            'name' => 'concubineOf',
            'caption' => 'is a concubine of',
            'caption_ja' => 'の妾',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 17,
            'name' => 'datingWith',
            'caption' => 'is dating with',
            'caption_ja' => 'の恋人',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 18,
            'name' => 'immoralRelationWith',
            'caption' => 'is in immoral relation with',
            'caption_ja' => 'と不倫関係',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 19,
            'name' => 'inLawFamilyOf',
            'caption' => 'is in law family of',
            'caption_ja' => 'と養子縁組家族',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 20,
            'name' => 'friendOf',
            'caption' => 'is a friend of',
            'caption_ja' => 'の友人',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 21,
            'name' => 'apprenticeOf',
            'caption' => 'is an apprentice of',
            'caption_ja' => 'の弟子',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 22,
            'name' => 'knows',
            'caption' => 'knows',
            'caption_ja' => 'の知人',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 23,
            'name' => 'graduateOf',
            'caption' => 'was graduated from',
            'caption_ja' => 'を卒業した',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 24,
            'name' => 'masterDegreeOf',
            'caption' => 'has a master degree of',
            'caption_ja' => '院を卒業した',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 25,
            'name' => 'studiedAt',
            'caption' => 'studied at',
            'caption_ja' => 'に就学する',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 26,
            'name' => 'memberOf',
            'caption' => 'is a member of',
            'caption_ja' => 'のメンバー',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 27,
            'name' => 'affiliation',
            'caption' => 'is affiliated to',
            'caption_ja' => 'に所属',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 28,
            'name' => 'worksFor',
            'caption' => 'works for',
            'caption_ja' => 'に勤務',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 29,
            'name' => 'colleague',
            'caption' => 'is a colleague of',
            'caption_ja' => 'の同僚',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 30,
            'name' => 'vocalOf',
            'caption' => 'is a vocal of',
            'caption_ja' => 'のボーカリスト',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 31,
            'name' => 'guitaristOf',
            'caption' => 'is a guitarist of',
            'caption_ja' => 'のギタリスト',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 32,
            'name' => 'bassistOf',
            'caption' => 'is a bassist of',
            'caption_ja' => 'のベーシスト',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 33,
            'name' => 'keyboardistOf',
            'caption' => 'is a keyboardist of',
            'caption_ja' => 'のキーボーディスト',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 34,
            'name' => 'drummerOf',
            'caption' => 'is a drummer of',
            'caption_ja' => 'のドラマー',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 35,
            'name' => 'dancerOf',
            'caption' => 'is a dancer of',
            'caption_ja' => 'のダンサー',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 36,
            'name' => 'founderOf',
            'caption' => 'is a founder of',
            'caption_ja' => 'の創業者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 37,
            'name' => 'ceoOf',
            'caption' => 'is ceo of',
            'caption_ja' => 'のCEO',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 38,
            'name' => 'boardMemberOf',
            'caption' => 'is a boardMember of',
            'caption_ja' => 'の役員',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 39,
            'name' => 'ministerOf',
            'caption' => 'is minister of',
            'caption_ja' => 'の大臣',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 40,
            'name' => 'headOf',
            'caption' => 'is the head of',
            'caption_ja' => 'の責任者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 41,
            'name' => 'coachOf',
            'caption' => 'is a coach of',
            'caption_ja' => 'のコーチ',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 42,
            'name' => 'funderOf',
            'caption' => 'is funder of',
            'caption_ja' => 'に出資',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 43,
            'name' => 'parentOrganizationOf',
            'caption' => 'is parent organization of',
            'caption_ja' => 'の親会社',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 44,
            'name' => 'subOrganizationOf',
            'caption' => 'is sub organization of',
            'caption_ja' => '傘下の組織',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 45,
            'name' => 'subFamilyOf',
            'caption' => 'is sub family of',
            'caption_ja' => 'の支流家族',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 46,
            'name' => 'owns',
            'caption' => 'owns',
            'caption_ja' => 'を所有',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 47,
            'name' => 'runs',
            'caption' => 'runs',
            'caption_ja' => 'を運営する',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 48,
            'name' => 'established',
            'caption' => 'established',
            'caption_ja' => 'を設立した',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 49,
            'name' => 'acquisition',
            'caption' => 'made acquisition with',
            'caption_ja' => 'を買収',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 50,
            'name' => 'acquiredBy',
            'caption' => 'was acquired by',
            'caption_ja' => 'に買収された',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 51,
            'name' => 'departmentOf',
            'caption' => 'is a department of',
            'caption_ja' => 'の内部無局',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 52,
            'name' => 'brandBy',
            'caption' => 'is a brand by',
            'caption_ja' => 'のブランド',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 53,
            'name' => 'locatedAt',
            'caption' => 'is located at',
            'caption_ja' => 'に所在',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 54,
            'name' => 'creatorOf',
            'caption' => 'is the creator of',
            'caption_ja' => 'の作者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 55,
            'name' => 'authorOf',
            'caption' => 'is the author of',
            'caption_ja' => 'の著者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 56,
            'name' => 'artistOf',
            'caption' => 'is the artist of',
            'caption_ja' => 'の制作者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 57,
            'name' => 'producerOf',
            'caption' => 'is the producer of',
            'caption_ja' => 'のプロデューサー',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 58,
            'name' => 'directorOf',
            'caption' => 'is a director of',
            'caption_ja' => 'のディレクター',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 59,
            'name' => 'publisherOf',
            'caption' => 'is the publisher of',
            'caption_ja' => 'の出版社',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 60,
            'name' => 'productionCompanyOf',
            'caption' => 'is the production company of',
            'caption_ja' => 'のプロダクション会社',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 61,
            'name' => 'contributorOf',
            'caption' => 'is a contributor of',
            'caption_ja' => 'の貢献者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 62,
            'name' => 'actorOf',
            'caption' => 'is an actor of',
            'caption_ja' => 'に出演',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 63,
            'name' => 'performed',
            'caption' => 'performed in',
            'caption_ja' => 'に出演',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 64,
            'name' => 'playsAt',
            'caption' => 'plays at',
            'caption_ja' => 'に所属',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 65,
            'name' => 'characterOf',
            'caption' => 'is a character of',
            'caption_ja' => 'のキャラクター',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 66,
            'name' => 'isBasedOn',
            'caption' => 'is based on',
            'caption_ja' => 'を原作とする',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 67,
            'name' => 'track',
            'caption' => 'is a track in',
            'caption_ja' => 'のトラック',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 68,
            'name' => 'manufacturerOf',
            'caption' => 'is a manufacturer of',
            'caption_ja' => 'の開発者',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 69,
            'name' => 'manufacturedBy',
            'caption' => 'is manufactured by',
            'caption_ja' => 'により開発された',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 70,
            'name' => 'organizerOf',
            'caption' => 'is an organizer of',
            'caption_ja' => 'を主宰',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 71,
            'name' => 'attendeeOf',
            'caption' => 'is an attendee of',
            'caption_ja' => 'に出席',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 72,
            'name' => 'isElected',
            'caption' => 'is elected',
            'caption_ja' => 'に当選',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 73,
            'name' => 'participated',
            'caption' => 'participated',
            'caption_ja' => 'に参画',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 74,
            'name' => 'executed',
            'caption' => 'executed',
            'caption_ja' => 'を実施',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 75,
            'name' => 'achieved',
            'caption' => 'achieved',
            'caption_ja' => 'を達成',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 76,
            'name' => 'isAs',
            'caption' => 'is',
            'caption_ja' => 'である',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 77,
            'name' => 'isOneOf',
            'caption' => 'is one of',
            'caption_ja' => 'のひとつ',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 78,
            'name' => 'isFrom',
            'caption' => 'is from',
            'caption_ja' => 'の出身',
            'created' => NULL,
            'modified' => NULL
        ],
        [
            'id' => 79,
            'name' => 'worksAs',
            'caption' => 'works as',
            'caption_ja' => 'として活動',
            'created' => NULL,
            'modified' => NULL
        ],
    ];
}
