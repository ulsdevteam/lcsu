<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Traysize $traysize
 */
?>
<div class="traysizes form content">
    <?= $this->Form->create($traysize) ?>
    <fieldset>
        <legend><?= __('Add Traysize') ?></legend>
        <?php
            echo $this->Form->control('tray_category');
            echo $this->Form->control('shelf_height');
            echo $this->Form->control('num_trays');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
