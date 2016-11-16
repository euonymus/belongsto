<?
namespace App\View\Helper;

use Cake\View\Helper;

class PageHelper extends Helper
{

  const PAGETYPE_DEFAULT  = 0;
  const PAGETYPE_TOP      = 1;
  const PAGETYPE_SUBJECT  = 2;
  const PAGETYPE_RELATION = 3;
  public function sideType()
  {
    if (($this->request->params['controller'] == 'Pages') && ($this->request->params['action'] == 'display') ) {
      return self::PAGETYPE_TOP;
    } elseif (($this->request->params['controller'] == 'Subjects') && 
	(($this->request->params['action'] == 'relations') || ($this->request->params['action'] == 'edit'))) {
      return self::PAGETYPE_SUBJECT;
    } elseif (($this->request->params['controller'] == 'Relations') && 
	($this->request->params['action'] == 'view')) {
      return self::PAGETYPE_RELATION;
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
}
