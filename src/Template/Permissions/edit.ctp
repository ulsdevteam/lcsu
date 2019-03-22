<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Permission $permission
 */
?>
<div class="permissions form columns content">
    <?= $this->Form->create($permission) ?>
    <fieldset>
        <legend><?= __('Edit Permission') ?></legend>
        <?php
            echo $this->Form->control('create_time');
            echo $this->Form->control('permission_level');
            echo $this->Form->control('permission_title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
