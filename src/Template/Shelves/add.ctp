<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shelf $shelf
 */
?>
<div class="shelves form content" id="app">
    <?= $this->Form->create($shelf, ['id' => 'add_shelf', 'ref' => 'form']) ?>
    <fieldset>
        <legend><?= __('Add Shelf') ?></legend>
        <?php
            echo $this->Form->control('shelf_title');
            echo $this->Form->control('shelf_height', ['id' => 'shelf_height_input', 'v-model' => 'input_height', 'v-on:change' => 'updateTraysizeList']);
            if ($this->request->getQuery('module_id')) {
                echo $this->Form->control('module_id', ['options' => $modules, 'empty' => true, 'default' => $this->request->getQuery('module_id'), 'readonly' => 'readonly']);
            } else {
                echo $this->Form->control('module_id', ['options' => $modules, 'empty' => true]);
            }
            $this->Form->unlockField('traysize_id');
        ?>
        <div class="input select">
            <label for="traysize_id">Tray size</label>
            <select name="traysize_id" form="add_shelf">
                <option value=""></option>
                <option v-for="value in cur_traysizes" :value="value.id">{{value.text}}</option>
            </select>
        </div>
        
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->button(__('Submit'), ['v-on:click' => 'goNext']) ?>
    
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            info: [],
            statusModel: 2,
            input_height: 0,
            traysizes: [],
            cur_traysizes: [{0:'type in shelf height first'}]
        },
        methods: {
            updateTraysizeList: function(evt) {
                this.cur_traysizes.length = 0;
                if (this.traysizes.length != 0) {
                    for ( i = 0 ; i < this.traysizes.length ; i++) {
                        if (this.traysizes[i].shelf_height == this.input_height) {
                            this.cur_traysizes.push({'id':this.traysizes[i]['traysize_id'], 'text': this.traysizes[i]['traysize_option']});
                        }
                    }
                }
            },
            goNext: function(e) {
                this.$refs.form.submit();
            }
        },
        mounted () {
            axios
              .get('<?=  $this->Url->build(["controller" => "Traysizes",
                                            "action" => "listAllTraysizes"]); ?>')
              .then(response => (this.traysizes = response['data']))
        }
    })
</script>
