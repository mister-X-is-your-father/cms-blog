<?php
if(isset($_POST['checkBoxArray'])) {
  foreach($_POST['checkBoxArray'] as $postValueId) {
    $bulk_options = $_POST['bulk_options'];
    switch($bulk_options) {
        case 'published':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}'";
        $update_to_published_status = mysqli_query($connection, $query);
        break;

        case 'draft':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}'";
        $update_to_draft_status = mysqli_query($connection, $query);
        break;

        case 'delete':
        $query = "DELETE FROM posts WHERE post_id = '{$postValueId}'";
        $update_to_delete_status = mysqli_query($connection, $query);
        break;

        case 'clone':
        $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
        $select_post_query = mysqli_query($connection,$query);

        while($row = mysqli_fetch_array($select_post_query)) {
          $post_author = $row['post_author'];
          $post_title = $row['post_title'];
          $post_category_id = $row['post_category_id'];
          $post_status = $row['post_status'];
          $post_image = $row['post_image'];
          $post_tags = $row['post_tags'];
          $post_date = $row['post_date'];
        }
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status)";
        $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
        $copy_query = mysqli_query($connection, $query);
        if(!$copy_query) {
          die("QUERY FAILED" . mysqli_error($connection));
        }
        break;
    }
  }
}
?>
<form action="" method="post">
<table class="table table-bordered table-hover">
  <div id="bulkOptionsContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options" id="">
      <option value="">記事の状態を変更します</option>
      <option value="published">公開</option>
      <option value="draft">下書き</option>
      <option value="delete">削除</option>
      <option value="clone">複製</option>
    </select>
  </div>
  <div class="col-xs-4">
  <input type="submit" name="submit" class="btn btn-success" value="適用">
  <a class="btn btn-primary" href="posts.php?source=add_post">新規投稿</a>
  </div>
  <thead>
    <tr>
      <th><input id="selectAllBoxes" type="checkbox"></th>
      <th>ID</th>
      <th>投稿者</th>
      <th>タイトル</th>
      <th>カテゴリー</th>
      <th>ステータス</th>
      <th>画像</th>
      <th>検索タグ</th>
      <th>投稿日</th>
      <th>アクセス数</th>
      <th>コメント数</th>
      <th>閲覧</th>
      <th>編集</th>
      <th>削除</th>

    </tr>
  </thead>
  <tbody>

<?php
if(isset($_GET['delete'])) {
  global $connection;
  $the_post_id = $_GET['delete'];
  $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
  $delete_query = mysqli_query($connection, $query);
  header("Location: posts.php");
}
?>

<?php
  $query = "SELECT * FROM posts ORDER BY post_id DESC";
  $select_posts = mysqli_query($connection,$query);

  while($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_views_count = $row['post_views_count'];
    echo "<tr>";
    ?>
    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
    <?php
    echo "<td>$post_id</td>";
    echo "<td>$post_author</td>";
    echo "<td>$post_title</td>";

    $query ="SELECT * FROM categories WHERE cat_id = {$post_category_id}";
      $select_categories_id = mysqli_query($connection,$query);

      while($row = mysqli_fetch_assoc($select_categories_id)) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];

    echo "<td>$cat_title</td>";
      }

    if($post_status == "published") {echo "<td>公開</td>";}
    else {echo "<td>下書き</td>";}
    echo "<td><img src='../images/$post_image' alt='image' width='100'></td>";
    echo "<td>$post_tags</td>";
    echo "<td>$post_date</td>";
    echo "<td>{$post_views_count}</td>";

    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
    $send_comment_query = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($send_comment_query);
    $comment_id = $row['comment_id'];
    $count_comments = mysqli_num_rows($send_comment_query);

    echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";

    echo "<td><a href='../post.php?p_id={$post_id}'>閲覧</a></td>";
    echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>編集</a></td>";
    echo "<td><a onClick=\"javascript: return confirm('削除しますか？'); \" href='posts.php?delete={$post_id}'>削除</a></td>";
    echo "</tr>";
  }
?>

  </tbody>
</table>
</form>