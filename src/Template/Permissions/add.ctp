<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */
?>
<div class="permissions form columns content">
    <?= $this->Form->create($permission) ?>
    <fieldset>
        <legend><?= __('Add Permission') ?></legend>
        <?php
            echo $this->Form->control('permission_title');
            echo $this->Form->control('permission_level');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
