<?php
    $products   = get_posts([
        'post_type' => 'wuoyproduct'
    ]);

    $max = wp_max_upload_size() / ( 1024  * 1000);
?>
<div class="wrap">
    <h2><?php _e('Ekspor Data HPI', 'whpi'); ?></h2>
    <form class="" action="<?php echo admin_url('/'); ?>" method="POST" enctype="multipart/form-data">
        <table class='form-table'>
            <tr>
                <th><?php _e('Keanggotaan', 'whpi'); ?></th>
                <td>
                    <select class="" name="product" id='product'>
                        <?php foreach($products as $product) : ?>
                        <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>File Excel</th>
                <td>
                    <input type="file" name="file" value="" id='file'><br />
                    <em>
                        <?php _e('File yang diizinkan hanya yang berformat .xls atau .xlsx', 'wphi'); ?><br />
                        <?php printf(__('Besar file yang digunakan adalah %s MB', 'wphi'), $max); ?>
                    </em>
                </td>
            </tr>
            <tr>
                <th><?php _e('Status Aktif', 'wphi'); ?></th>
                <td>
                    <label for="active">
                        <input type="checkbox" name="active" value="1" id='active' />
                        <?php _e('Status keanggotaan langsung aktif', 'wphi'); ?>
                    </label>
                </td>
            </tr>
        </table>
        <p class='submit'>
            <?php wp_nonce_field('wphi-upload-excel'); ?>
            <button type="submit" name="button" class='button button-primary'><?php _e('Upload Data','wphi'); ?></button>
        </p>
    </form>
</div>
