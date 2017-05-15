<?
namespace App\View\Helper;

use Cake\View\Helper;

class PageHelper extends Helper
{

  const PAGETYPE_DEFAULT  = 0;
  const PAGETYPE_TOP      = 1;
  const PAGETYPE_SUBJECT  = 2;
  const PAGETYPE_RELATION = 3;
  const PAGETYPE_SEARCH   = 4;
  const PAGETYPE_SIGNUP   = 5;
  const PAGETYPE_BARYON   = 6;
  public function sideType()
  {
    if (($this->request->params['controller'] == 'Pages') && ($this->request->params['action'] == 'display') ) {
      return self::PAGETYPE_TOP;
    } elseif (($this->request->params['controller'] == 'Subjects') && ($this->request->params['action'] == 'relations')) {
      return self::PAGETYPE_SUBJECT;
    } elseif (($this->request->params['controller'] == 'Relations') && ($this->request->params['action'] == 'view')) {
      return self::PAGETYPE_RELATION;
    } elseif (($this->request->params['controller'] == 'Subjects') && ($this->request->params['action'] == 'search')) {
      return self::PAGETYPE_SEARCH;
    } elseif (($this->request->params['controller'] == 'Users') && ($this->request->params['action'] == 'add')) {
      return self::PAGETYPE_SIGNUP;
    } elseif ($this->request->params['controller'] == 'Baryons') {
      return self::PAGETYPE_BARYON;
    }
    return self::PAGETYPE_DEFAULT;
  }

  public function isTop()
  {
    return ($this->sideType() == self::PAGETYPE_TOP);
  }
  public function isSubject()
  {
    return ($this->sideType() == self::PAGETYPE_SUBJECT);
  }
  public function isRelation()
  {
    return ($this->sideType() == self::PAGETYPE_RELATION);
  }
  public function isSearch()
  {
    return ($this->sideType() == self::PAGETYPE_SEARCH);
  }
  public function isSignup()
  {
    return ($this->sideType() == self::PAGETYPE_SIGNUP);
  }
  public function isBaryon()
  {
    return ($this->sideType() == self::PAGETYPE_BARYON);
  }
}
