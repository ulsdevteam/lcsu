<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf[]|\Cake\Collection\CollectionInterface $shelves
 */
?>
<div class="searches index content">
    <h3 class="page-title"><?= __('Search for ') ?><span><?= "\"".$keyword."\""?></span></h3>
    <div class="index-table">

        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <?php if(is_numeric($keyword)) {
                        echo "<th scope='col'>".$this->Paginator->sort('book_barcode')."</th>";
                        echo "<th scope='col' class='actions'>".__('Actions')."</th>";
                    } else {
                        echo "<th scope='col'>".$this->Paginator->sort('tray_barcode')."</th>";
                        echo "<th scope='col'>".$this->Paginator->sort('created')."</th>";
                        echo "<th scope='col'>".$this->Paginator->sort('modified')."</th>";
                        echo "<th scope='col'>".$this->Paginator->sort('modified_user')."</th>";
                        echo "<th scope='col' class='actions'>".__('Actions')."</th>";
                    }?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                <tr>
                    <?php
                        if (is_numeric($keyword)) {
                            echo "<td>".h($result->book_barcode)."</td>";
                            echo "<td>".(isset($result->tray_id) ? $this->Html->link('View tray', ['controller' => 'Trays', 'action' => 'view', $result->tray_id]) : '')."</td>";
                        } else {
                            echo "<td>".h($result->tray_barcode)."</td>";
                            echo "<td>".h($result->created)."</td>";
                            echo "<td>".h($result->modified)."</td>";
                            echo "<td>".h($result->modified_user)."</td>";
                            echo "<td class='actions'>";
                            $filter = $this->request->getQuery('filter');
                            switch ($filter) {
                                case 'incompleted':
                                    echo $this->Html->link(__('Review'), ['action' => 'incompleted', $result->tray_id]);
                                    break;
                                case 'validate':
                                    if ($result->modified_user != env('REMOTE_USER', true)) {
                                        echo $this->Html->link(__('Validate'), ['action' => 'validate', $result->tray_id]);
                                    }
                                    break;
                                default:
                                    echo $this->Html->link(__('View'), ['controller' => 'Trays', 'action' => 'view', $result->tray_id]);
                                    echo $this->Html->link(__('Edit'), ['controller' => 'Trays', 'action' => 'edit', $result->tray_id]);
                                    echo $this->Form->postLink(__('Delete'), ['controller' => 'Trays', 'action' => 'delete', $result->tray_id], ['confirm' => __('Are you sure you want to delete # {0}?', $result->tray_id)]);
                                    break;
                            }
                            echo "</td>";
                        }
                    ?>
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
            <?= $this->Paginator->options([ 'url'=> ['action' => 'index', 'keyword' => $keyword]])?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
