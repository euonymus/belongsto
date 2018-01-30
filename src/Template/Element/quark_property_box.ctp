<?
namespace App\Model\Entity;
if (!empty($targetGluons)): ?>
<h2><?= $this->LangMngr->txt($quark_property->caption, $quark_property->caption_ja); ?></h2>
<div class="related">
   <div class="well subject-relation white">

<? foreach ($targetGluons as $targetGluon): ?>
      <? $isPassive = ($targetGluon['sides'] == Subject::SIDES_FORWARD) ? false : true;
         $relation = $targetGluon['relation'];
         $colorType = 1; ?>
      <?= $this->element('subject_box', compact(['subject', 'relation', 'isPassive', 'colorType'])) ?>
<? endforeach; ?>

   </div>
</div>
<? endif; ?>
