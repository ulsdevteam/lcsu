<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tray $tray
 * @var array $bookList
 */
?>

<div class="books form columns content" id="app">
    <h1><?= $tray->tray_barcode ?></h1>
    <label for="book_barcode">Book Barcode</label>
    <input type="text" name="book_barcode" ref="input_barcode" id="input_barcode" v-model="input" v-on:keyup.13="checkBook" value="">

    <table id="book-list">
        <thead>
            <tr>
                <th scope="col"><?= h('Book List') ?></th>
                <th>Scan Status</th>
                <th>Item Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for= "book in bookList">
                <td>{{book.book_barcode}}</td>
                <td>{{book.status}}</td>
                <td>{{book.statuses}}</td>
            </tr>
        </tbody>
    </table>
    <?= $this->Form->postLink(__('Inventory Complete'), ['action' => 'shelflist', $tray->tray_id], ['class' => 'button']); ?>
</div>

<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            bookList: [],
            input:"",
            count:0
        },
        methods: {
            checkBook() {
                if (!isNaN(this.input) && this.input.length == 14) {
                    var flag = false;
                    for (var i = 0; i < this.bookList.length; i++) {
                        if(this.bookList[i]['book_barcode'] == this.input) {
                            if(this.bookList[i]['status'] == 'Uncheck') {
                                this.count++;
                                if (this.count == this.bookList.length) {
                                   alert("Verification complete");
                                }
                            }
                            this.bookList[i]['status'] = 'Checked';
                            flag = true;
                        }
                    }
                    if (!flag) {
                        alert("The book doesn't belong to this tray");
                    }
                } else {
                    alert("The barcode is invalid.");
                }
                this.input = "";
            }
        },
        mounted() {
            this.$refs.input_barcode.focus();
            $data = <?php echo json_encode($bookList);?>;
            for (var i = 0; i <$data.length; i++) {
                this.bookList.push({'book_barcode': $data[i]['book_barcode'], 'statuses': $data[i]['statuses'], 'status': 'Unchecked'});
            }
        }
    })
</script>
