<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 */
?>
<div class="modules form content">
    <?= $this->Form->create($module) ?>
    <fieldset>
        <legend><?= __('Edit Module') ?></legend>
        <?php
            echo $this->Form->control('module_title');
            echo $this->Form->control('range_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
