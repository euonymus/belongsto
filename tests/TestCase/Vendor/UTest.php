<?php
namespace App\Test\TestCase\Vendor;

use Cake\Core\Configure;

use App\Utils\U;
use Cake\TestSuite\TestCase;
use Cake\Cache\Cache;
/**
 * App\Vendor\U Test Case
 */
class UTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
	$this->U = new U;
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->U);
        parent::tearDown();
    }

    public function testSalvageDateFromText()
    {
      $testText = 'あああ2017年1月1日だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年1月1日');

      $testText = 'あああ2017年1月だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年1月');

      $testText = 'あああ2017年だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年');

      $testText = 'あああ 2017 年 1 月 1 日 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017 年 1 月 1 日');

      $testText = 'あああ 2017 年 1 月 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017 年 1 月');

      $testText = 'あああ 2017 年 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017 年');

      $testText = 'あああ 2017年01月01日 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年01月01日');

      $testText = 'あああ 2017年01月 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年01月');

      $testText = 'あああ 2017年 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017年');

      $testText = 'あああ 2017 年 01 月 01 日 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017 年 01 月 01 日');

      $testText = 'あああ 2017 年 01 月 だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '2017 年 01 月');

      $testText = 'あああ 昭和44年（1969年）5月8日だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '（1969年）5月8日');

      $testText = 'あああ 昭和44年（1969年）5月だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '（1969年）5月');

      $testText = 'あああ 昭和44年（1969年）だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '（1969年）');

      $testText = 'あああ 昭和44年（1969年） 05 月 08 日だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '（1969年） 05 月 08 日');

      $testText = 'あああ 昭和44年（1969年） 05 月だお';
      $res = U::salvageDateFromText($testText);
      $this->assertSame($res, '（1969年） 05 月');
    }

    public function testSalvagePeriodFromText()
    {
      $testText = 'あああ2017年1月1日 - 2017年07 月15日だお';
      $res = U::salvagePeriodFromText($testText);
      $this->assertSame($res, '2017年1月1日 - 2017年07 月15日');

      $start = U::salvageStartFromPeriodText($res);
      $this->assertSame($start, '2017年1月1日');
      $end = U::salvageEndFromPeriodText($res);
      $this->assertSame($end, '2017年07 月15日');

      $res = U::normalizeDateFormat($start);
      $this->assertSame($res, '2017-01-01');
      $res = U::normalizeDateFormat($end);
      $this->assertSame($res, '2017-07-15');



      $testText = 'あああ2017年 - 2019年だお';
      $res = U::salvagePeriodFromText($testText);
      $this->assertSame($res, '2017年 - 2019年');

      $start = U::salvageStartFromPeriodText($res);
      $this->assertSame($start, '2017年');
      $end = U::salvageEndFromPeriodText($res);
      $this->assertSame($end, '2019年');

      $res = U::normalizeDateFormat($start);
      $this->assertSame($res, '2017');
      $res = U::normalizeDateFormat($end);
      $this->assertSame($res, '2019');



      $testText = 'あああ2017年 9月 ~ 2019年10月3日だお';
      $res = U::salvagePeriodFromText($testText);
      $this->assertSame($res, '2017年 9月 ~ 2019年10月3日');

      $start = U::salvageStartFromPeriodText($res);
      $this->assertSame($start, '2017年 9月');
      $end = U::salvageEndFromPeriodText($res);
      $this->assertSame($end, '2019年10月3日');

      $res = U::normalizeDateFormat($start);
      $this->assertSame($res, '2017-09');
      $res = U::normalizeDateFormat($end);
      $this->assertSame($res, '2019-10-03');



      $testText = 'あああ 昭和44年（1969年） 05 月-だお';
      $res = U::salvagePeriodFromText($testText);
      $this->assertSame($res, '（1969年） 05 月-');

      $start = U::salvageStartFromPeriodText($res);
      $this->assertSame($start, '（1969年） 05 月');
      $end = U::salvageEndFromPeriodText($res);
      $this->assertFalse($end);

      $res = U::normalizeDateFormat($start);
      $this->assertSame($res, '1969-05');
      $res = U::normalizeDateFormat($end);
      $this->assertFalse($end);



      $testText = 'あああ、明治19年（1886年）7月 - 昭和44年（1969年）5月8日）、だお';
      $res = U::salvagePeriodFromText($testText);
      $this->assertSame($res, '（1886年）7月 - 昭和44年（1969年）5月8日');

      $start = U::salvageStartFromPeriodText($res);
      $this->assertSame($start, '（1886年）7月');
      $end = U::salvageEndFromPeriodText($res);
      $this->assertSame($end, '（1969年）5月8日');

      $res = U::normalizeDateFormat($start);
      $this->assertSame($res, '1886-07');
      $res = U::normalizeDateFormat($end);
      $this->assertSame($res, '1969-05-08');

      $testText = 'あああ、明治19年（1886年）7月 - 昭和44年（1969年）5月8日）、だお';
      $res = U::getStartDateFromText($testText);
      $this->assertSame($res, '1886-07');

      $res = U::getEndDateFromText($testText);
      $this->assertSame($res, '1969-05-08');
    }

    public function testNormalizeDateArrayFormat()
    {
      $dateTxt = '1999';
      $res = U::normalizeDateArrayFormat($dateTxt);
      $this->assertSame($res, ['date' => '1999-01-01 00:00:00', 'date_accuracy' => 'year']);

      $dateTxt = '2018-2';
      $res = U::normalizeDateArrayFormat($dateTxt);
      $this->assertSame($res, ['date' => '2018-02-01 00:00:00', 'date_accuracy' => 'month']);

      $dateTxt = '593-10-16';
      $res = U::normalizeDateArrayFormat($dateTxt);
      $this->assertSame($res, ['date' => '593-10-16 00:00:00', 'date_accuracy' => NULL]);
    }

    public function testSameStr()
    {
      $str1 = '';
      $str2 = '';
      $this->assertTrue(U::sameStr($str1, $str2));

      $str1 = ' a a';
      $str2 = 'aa';
      $this->assertFalse(U::sameStr($str1, $str2));

      $str1 = ' 　 a a　 　 ';
      $str2 = 'a a';
      $this->assertTrue(U::sameStr($str1, $str2));
    }
}
