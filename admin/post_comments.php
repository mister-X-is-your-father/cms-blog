<?php include "includes/admin_header.php" ?>
<div id="wrapper">
<?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12"></div>
                    <h1 class="page-header">コメント</h1>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>投稿者</th>
      <th>コメント</th>
      <th>メールアドレス</th>
      <th>状態</th>
      <th>記事名</th>
      <th>投稿日</th>
      <th>表示する</th>
      <th>非表示にする</th>
      <th>削除</th>
    </tr>
  </thead>
  <tbody>

<?php

if(isset($_GET['approve'])) {
  $the_comment_id = $_GET['approve'];
  $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";
  $approve_comment_query = mysqli_query($connection, $query);
  header("Location: post_comments.php?id=" .$_GET['id']."");
}


if(isset($_GET['unapprove'])) {
  $the_comment_id = $_GET['unapprove'];
  $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id";
  $unapprove_comment_query = mysqli_query($connection, $query);
  header("Location: post_comments.php?id=" .$_GET['id']."");
}

if(isset($_GET['delete'])) {
  global $connection;
  $the_comment_id = $_GET['delete'];
  $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
  $delete_query = mysqli_query($connection, $query);
  header("Location: post_comments.php?id=" .$_GET['id']."");
}
?>

<?php
  $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) . " ORDER BY comment_id DESC";
  $select_comments = mysqli_query($connection,$query);

  while($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_email = $row['comment_email'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];

    echo "<tr>";

    echo "<td>$comment_id</td>";
    echo "<td>$comment_author</td>";
    echo "<td>$comment_content</td>";


    echo "<td>$comment_email</td>";
    if($comment_status == "approved") {echo "<td>表示</td>";}
    else {echo "<td>非表示</td>";}

    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
    $select_post_id_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_post_id_query)){
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
    }



    echo "<td>$comment_date</td>";
    //$commen_id&id=で、削除するコメントID情報を乗せて、idでリダイレクト先のポストIDを乗せている
    echo "<td><a href='post_comments.php?approve=$comment_id&id=" .$_GET['id'] ."'>表示する</a></td>";
    echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" .$_GET['id'] ."'>非表示にする</a></td>";
    echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] ."'>削除</a></td>";
    echo "</tr>";
  }
?>

  </tbody>
</table>


                    </div>
                </div>
            </div>
        </div>
<?php include "includes/admin_footer.php" ?>