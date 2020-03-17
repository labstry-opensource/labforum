<?php
include dirname(__FILE__) . '/../laf-config.php';
$table_struct = json_decode(file_get_contents(API_PATH . '/installer/laf-structure.json'), true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://www.unpkg.com/jquery@latest/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/jquery-serializejson@2.9.0/jquery.serializejson.min.js"></script>
    <script src="https://unpkg.com/vue@latest/dist/vue.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <title>Labforum Database Update</title>
</head>
<body>
<div class="text-center py-5" style="background-color: #0099ff; min-height: 100px;">
    <h1 class="text-light">Labforum Database Update Generator</h1>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#0099ff" fill-opacity="1" d="M0,224L48,202.7C96,181,192,139,288,112C384,85,480,75,576,106.7C672,139,768,213,864,229.3C960,245,1056,203,1152,181.3C1248,160,1344,160,1392,160L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
</svg>


<form class="update-form" action="<?php echo BASE_ROOT_API_URL .'/installer/update-generator.php '?>" method="POST">
    <div class="container py-4">
        <div class="text-right">
            <button class="btn btn-primary" v-on:click.prevent="addTable()">&plus; Add Table</button>
        </div>

        <div class="py-4 " v-for="(table_item, table_index) in table_struct">
            <div class="table-name">
                <div class="row align-items-end py-4">
                    <div class="col-12 col-md-4">
                        Original Table Name:
                        <input type="text" class="form-control-plaintext"
                               v-bind:name="'table[' + table_index + '][original_name]'"
                               v-bind:value="table_item.table" readonly>
                    </div>
                    <div class="col-12 col-md-4">
                        New Table Name:
                        <input type="text" class="form-control"
                               v-bind:name="'table[' + table_index + '][new_name]'"
                               v-bind:value="table_item.table">
                    </div>
                    <div class="col-12 col-md-4">
                        <button class="btn btn-primary" type="button" v-on:click.prevent="addColumn(table_index)">&plus; Add Column</button>
                        <button class="btn btn-danger btn-drop" type="button" v-on:click.prevent="dropTable(table_index)">
                            Drop Table
                        </button>
                        <input type="hidden" v-bind:name="'table[' + table_index + '][drop]'" value="0">
                    </div>
                </div>

            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Field</th>
                    <th scope="col">Original Type</th>
                    <th scope="col">Rename As Field</th>
                    <th scope="col">Type</th>
                    <th scope="col">Nullable</th>
                    <th scope="col">Default Value</th>
                    <th scope="col">Extra</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(col, index) in table_item.cols">
                    <td>
                        <input type="text"
                               class="form-control-plaintext"
                               v-bind:class="{'d-none': col.field === ''}"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][original_field]'"
                               v-bind:value="col.field"
                               readonly>
                    </td>
                    <td>
                        <input type="text"
                               class="form-control-plaintext"
                               v-bind:class="{'d-none': col.type === ''}"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][original_type]'"
                               v-bind:value="col.type"
                               readonly>
                    </td>
                    <td>
                        <input type="text"
                               class="form-control"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][field]'"
                               v-bind:value="col.field">
                    </td>
                    <td>
                        <input type="text"
                               class="form-control"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][type]'"
                               v-bind:value="col.type">
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox"
                                   class="form-check-input"
                                   v-bind:id="'table['+ table_index +'][cols][' + index +'][null]'"
                                   v-bind:name="'table['+ table_index +'][cols][' + index +'][null]'"
                                   value="true" v-bind:checked="col.null">
                            <label class="form-check-label" v-bind:for="'table['+ table_index +'][cols][' + index +'][null]'">Null</label>
                            <input type="hidden"
                                   v-bind:name="'table['+ table_index +'][cols][' + index +'][original_null]'"
                                   v-bind:value="col.null | boolean">

                        </div>

                    </td>
                    <td>
                        <input type="text"
                               class="form-control"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][default]'"
                               v-bind:value="col.default">
                        <input type="hidden"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][original_default]'"
                               v-bind:value="col.default">
                    </td>
                    <td>
                        <input type="text"
                               class="form-control"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][extra]'"
                               v-bind:value="col.extra">
                        <input type="hidden"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][original_extra]'"
                               v-bind:value="col.extra">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" v-on:click.prevent="toggleRemoveColumn(table_index, index)">
                            Drop
                        </button>
                        <input type="hidden" v-bind:class="'table-' + table_index + '-col-' + index + '-delete'"
                               v-bind:name="'table['+ table_index +'][cols][' + index +'][drop]'"
                               value="0">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button class="btn btn-success">Generate</button>
    </div>
</form>

</body>
<script>
    Vue.filter('boolean', function(flag){
        return (flag === true) ? 'true' : 'false';
    });
    var updater = new Vue({
        el: '.update-form',
        data:{
            table_struct: <?php echo json_encode($table_struct); ?>,
            db_version: '',
        },
        mounted: function(){
            var self = this;
            this.$nextTick(function(){
                $('.update-form').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: $(this).attr('method'),
                        data:{json: JSON.stringify($(this).serializeJSON())},
                        success: function(data){
                            $("<a />", {
                                "download": "labforum-" + data.to_db_api + "-increment.json",
                                "href" : "data:application/json," + encodeURIComponent(JSON.stringify(data))
                            }).appendTo("body")
                                .click(function() {
                                    $(this).remove()
                                })[0].click();
                        }
                    })
                });
            });
        },
        methods: {
            addTable: function(){
                var random = Math.random().toString(36).substring(7);
                var obj = {
                    table: '',
                    cols: [{
                        field: '',
                        type: '',
                        null: false,
                        key: '',
                        default: '',
                        extra: '',
                    }],
                };
                this.table_struct.push(obj);
                this.table_struct.table = random;
                $("html, body").animate({ scrollTop: $(document).height() }, 600);
            },
            addColumn: function(index){
                var column = {
                    field: '',
                    type: '',
                    null: false,
                    key: '',
                    default: '',
                    extra: '',
                };
                this.table_struct[index].cols.push(column);
            },
            toggleRemoveColumn: function(table_index, col_index){
                //alert(1);

                $('.table-' + table_index + '-col-' + col_index + '-delete')
                    .val(($('.table-' + table_index + '-col-' + col_index + '-delete').val() === '0')? '1': '0');

                $('.table-' + table_index + '-col-' + col_index + '-delete').siblings('.btn')
                    .text(
                        ($('.table-' + table_index + '-col-' + col_index + '-delete').siblings('.btn').text() === 'Revert') ?
                            'Drop' : 'Revert');
                //$('.table-' + table_index + '-col-' + col_index + '-delete').siblings('.btn').text('Revert');
            },
            dropTable: function(table_index){
                $("input[name='table[" + table_index + "][drop]']")
                    .val(($("input[name='table[" + table_index + "][drop]']").val() === '0' ) ? '1' : '0');

                $("input[name='table[" + table_index + "][drop]']").siblings('.btn-drop')
                    .text(
                        ($("input[name='table[" + table_index + "][drop]']").siblings('.btn-drop').text() === 'Revert Table Drop') ?
                            'Drop Table' : 'Revert Table Drop');
            },
        }
    })
</script>
</html>