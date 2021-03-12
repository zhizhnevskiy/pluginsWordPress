<div class="wrap">
    <h1>Status Page</h1>
    <h2>Plugin innowise</h2>
</div>
<form class="wrap" action="" method="post">

    <p>Please select your page:</p>

    <select name="pages">

        <?php
        $my_wp_pages = get_pages();
        foreach ($my_wp_pages as $value) {
            $post = get_post($value);
            $title = $post->post_title;
            $id = $post->ID;
            echo '<option value="pageId' . $id . '">' . $title . '</option>';
        }; ?>

    </select>

    <br><br>

    <select name="cron">
        <option selected disabled>Select Options</option>
        <option name="" value="Option 1">Option 1</option>
        <option name="" value="Option 2">Option 2</option>
        <option name="" value="Option 3">Option 3</option>
        <option name="" value="Option 4">Option 4</option>
    </select>

    <br><br>

    <button type="submit">Submit</button>


</form>