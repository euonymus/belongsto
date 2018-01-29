<?
namespace App\Model\Entity;
if (!empty($targetGluons)): ?>
<h2><?= $this->LangMngr->txt($quark_property->caption, $quark_property->caption_ja); ?></h2>
<div class="related">
   <div class="well subject-relation">

<? foreach ($targetGluons as $targetGluon): ?>
      <? $isPassive = ($targetGluon['sides'] == Subject::SIDES_FORWARD) ? false : true;
         $relation = $targetGluon['relation']; ?>
      <?= $this->element('subject_box', compact(['subject', 'relation', 'isPassive'])) ?>
<? endforeach; ?>

   </div>
</div>
<? endif; ?>
