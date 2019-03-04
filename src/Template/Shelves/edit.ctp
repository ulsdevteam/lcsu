<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf $shelf
 */
?>
<div class="shelves form content">
    <?= $this->Form->create($shelf) ?>
    <fieldset>
        <legend><?= __('Edit Shelf') ?></legend>
        <?php
            echo $this->Form->control('shelf_title');
            echo $this->Form->control('shelf_height');
            echo $this->Form->control('module_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
