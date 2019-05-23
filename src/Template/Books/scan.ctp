<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<div class="books form columns content" id="app">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Add Book').'- ['.$this->request->getQuery('id').'/'.$this->request->getQuery('count').']' ?></legend>
        <?php
            echo $this->Form->control('book_barcode', ['autofocus'=>'autofocus', 'ref' => 'book_barcode']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        mounted() {
            this.$refs.book_barcode.focus();
            var url = new URL(window.location.href);
            var block_item = url.searchParams.get("block_item");
            if (block_item) {
                alert(block_item + ": This barcode doesn't exist in voyager database. Please replace this item.");
            }
        }
    })
</script>