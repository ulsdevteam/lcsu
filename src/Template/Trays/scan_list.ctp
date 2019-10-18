<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>

<div class="books form columns content" id="app">
    <label for="book_barcode">Book Barcode</label>
    <input type="text" name="book_barcode" ref="input_barcode" id="input_barcode" v-model="input" v-on:keyup.13="checkBook" value="">

    <table id="book-list">
        <thead>
            <tr>
                <th scope="col"><?= h('Book List') ?></th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for= "book in bookList">
                <td>{{book.book_barcode}}</td>
                <td>{{book.status}}</td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            bookList: [],
            input:"",
            count:0,
            checkedFlag: 'Checked',
            uncheckedFlag: 'Unchecked'
        },
        methods: {
            checkBook() {
                if (!isNaN(this.input) && this.input.length == 14) {
                    var flag = false;
                    for (var i = 0; i < this.bookList.length; i++) {
                        if(this.bookList[i]['book_barcode'] == this.input) {
                            if(this.bookList[i]['status'] == this.uncheckedFlag) {
                                this.count++;
                                if (this.count == this.bookList.length) {
                                    window.location = "<?= $this->Url->build([
                                                            'controller' => 'trays',
                                                            'action' => 'scan_end',
                                                            $tray->tray_id,
                                                            '?' => [
                                                                'source' => 'validate',
                                                                'count' => count($bookList->toArray())
                                                            ]
                                                        ], ['escape' => false])?>";
                                }
                            }
                            this.bookList[i]['status'] = this.checkedFlag;
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
                this.bookList.push({'book_barcode': $data[i]['book_barcode'], 'status': this.uncheckedFlag});
            }
        }
    })
</script>
