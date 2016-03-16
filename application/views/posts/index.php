<table id="posts" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
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
                <td><?php echo $post_item['title'];?></td>
                <td><?php echo $post_item['body'];?></td>
                <td><a href="<?php echo site_url('posts/'.$post_item['slug']); ?>">View post</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
