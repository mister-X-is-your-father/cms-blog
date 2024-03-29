<?php include "includes/admin_header.php" ?>

    <div id="wrapper" class="bg">

        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12"></div>
                        <h3 class="page-header">
                            ダッシュボード
                            <small><?php echo $_SESSION['username'] ?>さん</small>
                        </h3>
                    </div>
                </div>


                <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM posts";
                            $select_all_posts = mysqli_query($connection, $query);
                            $post_count = mysqli_num_rows($select_all_posts);
                            echo "<div class='huge'>{$post_count}</div>";
                        ?>
                        <div>投稿</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">投稿一覧</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                        $query = "SELECT * FROM comments";
                        $select_all_comments = mysqli_query($connection, $query);
                        $comment_count = mysqli_num_rows($select_all_comments);
                        echo "<div class='huge'>{$comment_count}</div>";
                    ?>
                        <div>コメント</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">コメント一覧</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM users";
                            $select_all_users = mysqli_query($connection, $query);
                            $user_count = mysqli_num_rows($select_all_users);
                            echo "<div class='huge'>{$user_count}</div>";
                        ?>
                        <div>ユーザー</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">ユーザー一覧</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM categories";
                            $select_all_categories = mysqli_query($connection, $query);
                            $category_count = mysqli_num_rows($select_all_categories);
                            echo "<div class='huge'>{$category_count}</div>";
                        ?>
                        <div>カテゴリー</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">カテゴリー一覧</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php

$query = "SELECT * FROM posts WHERE post_status = 'published'";
$select_all_published_posts = mysqli_query($connection, $query);
$post_published_count = mysqli_num_rows($select_all_published_posts);

$query = "SELECT * FROM posts WHERE post_status = 'draft'";
$select_all_draft_posts = mysqli_query($connection, $query);
$post_draft_count = mysqli_num_rows($select_all_draft_posts);

$query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
$unapproved_comments_query = mysqli_query($connection, $query);
$unapproved_comment_count = mysqli_num_rows($unapproved_comments_query);

$query = "SELECT * FROM users WHERE user_role = 'subscriber'";
$select_all_subscribers = mysqli_query($connection, $query);
$subscriber_count = mysqli_num_rows($select_all_subscribers);
?>

<div class="">
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['項目', '数'],
            <?php
            $element_text = ['全投稿', '公開投稿', '下書き', '全コメント', '非表示コメント', '全ユーザー', '非ADMINユーザー', 'カテゴリー'];
            $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $unapproved_comment_count, $user_count, $subscriber_count, $category_count];
            $number_of_element = count($element_text);
            for($i=0; $i<$number_of_element; $i++) {
                echo "['{$element_text[$i]}'".","." {$element_count[$i]}], ";
            }
            ?>
        ]);

        var options = {
            chart: {
                title: '各種状態グラフ',
                subtitle: '投稿やコメント、ユーザー状況が一目でわかりますが、あまり意味がありません。',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

                </div>
            </div>
        </div>
<?php include "includes/admin_footer.php" ?>