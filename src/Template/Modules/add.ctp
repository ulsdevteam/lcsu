<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 */
?>
<div class="modules form content">
    <?= $this->Form->create($module) ?>
    <fieldset>
        <legend><?= __('Add Module') ?></legend>
        <?php
            echo $this->Form->control('module_title');
            if ($this->request->getQuery('range_id')) {
                echo $this->Form->control('range_id', ['options'=>$ranges, 'empty' => true, 'default' => $this->request->getQuery('range_id'), 'readonly' => 'readonly']);
            } else {
                echo $this->Form->control('range_id', ['options'=>$ranges, 'empty' => true]);
            }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
