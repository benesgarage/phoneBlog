<table id="posts" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Text</th>
            <th>Date Posted</th>
            <th>User</th>
            <th>Device</th>
            <th> </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($post as $post_item):?>
            <tr>
                <td><?php echo $post_item['id_post'];?></td>
                <td><?php echo $post_item['title'];?></td>
                <td><?php echo $post_item['body'];?></td>
                <td><?php echo $post_item['datetime'];?></td>
                <td><?php
            foreach ($user as $user_solo):
                if ($user_solo['id_user'] == $post_item['id_user']){
                    echo $user_solo['user_name'];
                }
                    endforeach;?></td>
                <td><?php echo $post_item['device']?></td>
                <td><a href="<?php echo site_url('posts/'.$post_item['slug']); ?>">View post</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>