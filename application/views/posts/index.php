<?php
$user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : Anonymous;
?>
<table id="posts" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Text</th>
            <th>Date Posted</th>
            <th>User</th>
            <th>Device</th>
            <th>View</th>
            <?php
                if($user_role == Administrator) {
                    echo '<th>Manage</th>';
                };?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($post as $post_item):
            if ($post_item['hide'] == TRUE and $user_role != Administrator) {
                continue;
            }else{
                ?>
                <tr>
                    <td><?php echo $post_item['id_post']; ?></td>
                    <td><?php echo $post_item['title']; ?></td>
                    <td><?php echo $post_item['body']; ?></td>
                    <td><?php echo $post_item['datetime']; ?></td>
                    <td><?php
                        foreach ($user as $user_solo):
                            if ($user_solo['id_user'] == $post_item['id_user']) {
                                echo $user_solo['user_name'];
                            }
                        endforeach; ?></td>
                    <td><?php echo $post_item['device'] ?></td>
                    <td>
                        <a href="<?php echo site_url('posts/' . $post_item['slug'] . '_' . $post_item['id_post']); ?>">View
                            post</a></td>
                    <?php
                        if ($user_role == 1) {
                            echo '<td>';
                                if($post_item['hide'] == FALSE) {
                                    echo '<label style="position: relative; left: 15px;">Visible</label><a href="'
                                        .site_url('posts/hide/' . $post_item['slug'] . '_' . $post_item['id_post']);
                                    echo '"><img class="admin_manage_btn" src="'
                                        . base_url('assets/images/show_icon.png') . '"</a> </td>';
                                    }else {
                                    echo '<label style="position: relative; left: 15px;">Hidden</label><a href="'
                                        .site_url('posts/hide/' . $post_item['slug'] . '_' . $post_item['id_post']);
                                    echo '"><img class="admin_manage_btn" src="'
                                        . base_url('assets/images/hide_icon.png') . '"</a> </td>';
                                    }
                                }
                        } ?>
                </tr>
                <?php
        endforeach; ?>
    </tbody>
</table>