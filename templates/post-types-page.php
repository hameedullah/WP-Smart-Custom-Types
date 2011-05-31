<?php

?>
<div class="wrap">
    <form method="POST">
        <?php wp_nonce_field( 'sct_cpt_page', 'sct_cpt_nonce' ); ?>
    <h2>Smart Custom Post Types</h2>
    <table>
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
