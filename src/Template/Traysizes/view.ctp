<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Traysize $traysize
 */
?>
<div class="traysizes view content">
    <h3 class="page-title"><?= __('Traysize detail') ?></h3>
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $traysize->traysize_id], ['confirm' => __('Are you sure you want to delete # {0}?', $traysize->traysize_id), 'class' => 'func-btn']) ?>

    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Tray Category') ?></th>
            <td><?= h($traysize->tray_category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shelf Height') ?></th>
            <td><?= $this->Number->format($traysize->shelf_height) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number of the Tray') ?></th>
            <td><?= $this->Number->format($traysize->num_trays) ?></td>
        </tr>
    </table>
</div>
