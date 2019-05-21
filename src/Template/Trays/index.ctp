<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray[]|\Cake\Collection\CollectionInterface $trays
 */
?>
<div class="trays index content">

    <h3 class="page-title"><?= __('Trays') ?></h3>
    <div class="index-table">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('tray_barcode') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('status_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('modified_user', 'Modified By') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trays as $tray): ?>
                <tr>
                    <td><?= h($tray->tray_barcode) ?></td>
                    <td><?= h($tray->status->status_des) ?></td>
                    <td><?= h($tray->created) ?></td>
                    <td><?= h($tray->modified) ?></td>
                    <td><?= h($tray->modified_user) ?></td>
                    <td class="actions">
                        <?php
                            $filter = $this->request->getQuery('filter');
                            switch ($filter) {
                                case 'incompleted':
                                    echo '<span>|</span>';
                                    echo $this->Html->link(__('Review'), ['action' => 'incompleted', $tray->tray_id]);
                                    echo '<span>|</span>';
                                    /*echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $tray->tray_id], ['confirm' => __('Are you sure you want to delete # {0}?', $tray->tray_id)]);*/
                                    break;
                                case 'validate':
                                    if ($tray->modified_user != $cur_user['username']) {
                                        echo '<span>|</span>';
                                        echo $this->Html->link(__('Validate'), ['action' => 'validate', $tray->tray_id]);
                                        echo '<span>|</span>';
                                    }
                                    break;
                                default:
                                    echo '<span>|</span>';
                                    echo $this->Html->link(__('View'), ['action' => 'view', $tray->tray_id]);
                                    echo '<span>|</span>';
                                    echo $this->Html->link(__('Edit'), ['action' => 'edit', $tray->tray_id]);
                                    echo '<span>|</span>';
                                    //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $tray->tray_id], ['confirm' => __('Are you sure you want to delete # {0}?', $tray->tray_id)]);
                                    break;
                            }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
