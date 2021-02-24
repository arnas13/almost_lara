<a href="/posts" class='btn btn-light my-3'> <i class="fa fa-chevron-left"></i> Back</a>
<br />

<h1 class="display-3"><?php echo $post->title ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <strong><?php echo $user->name ?></strong>
    On: <?php echo $post->created_at ?>
</div>
<p class="lead"><?php echo $post->body ?></p>

<!-- show this only if this post belongs to this user -->
<?php // if ($_SESSION['user_id'] === $data['post']->user_id) : ?>
    <hr>
    <a href="<?php echo '/post/edit/' . $post->post_id ?>" class='btn btn-info '> <i class="fa fa-pencil"></i> Edit</a>

    <form action="<?php echo '/post/delete/' . $post->id ?>" method="post" class='float-right'>
        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i> Delete</button>
    </form>
<?php // endif; ?>
