<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Range $range
 */
?>
<div class="ranges form content">
    <?= $this->Form->create($range) ?>
    <fieldset>
        <legend><?= __('Edit Range') ?></legend>
        <?php
            echo $this->Form->control('range_title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
