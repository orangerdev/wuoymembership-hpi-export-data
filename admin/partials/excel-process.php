<div class="wrap">
    <h2>Proses Data Excel</h2>
    <div id='whpi-process'>

    </div>
</div>

<script type="text/javascript">

let whpi_process = function(text) {
    jQuery('#whpi-process').append(text + '<br />');
}

let start = 1;

let whpi_import = function() {
    jQuery.ajax({
        url : '<?php echo admin_url('admin-ajax.php'); ?>',
        data : {
            action : 'import-data',
            row : start
        },
        type : 'post',
        dataType: 'json',
        beforeSend : function() {
            whpi_process('Proses import data baris ' + start);
        },success : function(respond) {

        }
    });
}

jQuery(document).ready(function(){
    jQuery.ajax({
        url : '<?php echo admin_url('admin-ajax.php'); ?>',
        data : {
            action : 'check-file'
        },
        type : 'get',
        dataType: 'json',
        beforeSend : function() {
            whpi_process('Mengecek data excel');
        },success : function(respond) {

            whpi_process(respond.message);

            if(true === respond.continue) {
                whpi_import();
            } else {
                whpi_process('Selesai');
            }
        }
    });
});
</script>
