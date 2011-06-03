<?php

?>
<div class="wrap">

    <h2>Smart Custom Post Types</h2>

    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th>Name</th>
                <th>Public</th>
                <th>Enable Menu</th>
                <th>Archive</th>
            </tr>
        </thead>
    <?php foreach ( $post_types as $post_type ) { ?>
        <tr>
            <th><?php echo $post_type->name; ?></th>
            <th><?php echo $post_type->is_public; ?></th>
            <th><?php echo $post_type->show_in_menu; ?></th>
            <th><?php echo $post_type->has_archive; ?></th>
        </tr>
    <?php } ?>
    </table>

    <form method="POST">
        <?php wp_nonce_field( 'sct_cpt_page', 'sct_cpt_nonce' ); ?>
    <table style="margin-top: 30px;">
        <tr>
            <td>Post Type Name</td>
            <td><input type="text" name="type_name" value="" size="20" /> (e.g: Company Member)</td>
        </tr>
        <tr>
            <td>Public</td>
            <td><input type="checkbox" name="is_public" value="1" /> </td>
        </tr>
        <tr>
            <td>Enable Menu</td>
            <td><input type="checkbox" name="show_in_menu" value="1" /> </td>
        </tr>
        <tr>
            <td>Archive</td>
            <td><input type="checkbox" name="has_archive" value="1" /> </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Create" /> </td>
        </tr>
    </table>
    </form>
</div>
