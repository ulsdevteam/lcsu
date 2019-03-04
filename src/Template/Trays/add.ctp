<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 */
?>
<div class="trays form content">
    <?= $this->Form->create($tray) ?>
    <fieldset>
        <legend><?= __('Add Tray') ?></legend>
        <?php
            echo $this->Form->control('tray_title');
            echo $this->Form->control('shelf_id', ['label' => 'Located in shelf', 'disabled' => 'disabled']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
