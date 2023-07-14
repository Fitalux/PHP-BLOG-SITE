<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    
    if(isset ($_GET['category'])){
        $category = $_GET['category'];
    } else {
        Header("Location: blog.php");
    }
    $categorySql = "SELECT * FROM blog WHERE blogDelete = 0 AND blogCategory= '$category' ORDER BY blogID DESC";
    $categoryResult = $connect -> query($categorySql);
    $categoryInfo = $categoryResult -> fetch_array(MYSQLI_ASSOC);
    $categoryCount = $categoryResult -> num_rows;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Category</title> 

    <?php include "../include/head.php" ?>

    <!-- Toast UI Editor -->
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
</head>
<body class="gray">
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main" class="container">
        <div class="blog__search bmStyle">
        <?php 
            if($categoryCount == 0) { ?>
                <h2>해당 카테고리에는 게시글이 없습니다.</h2>
                <p>해당 카테고리와(과) 관련된 글이 존재하지 않습니다.</p>
           <?php } else { ?>
                <h2><?=$categoryInfo['blogCategory'] ?></h2>
                <p><?=$categoryInfo['blogCategory'] ?>와(과) 관련된 글이 <?= $categoryCount ?>개 존재합니다.</p>
           <?php }
        ?>
        </div>

        <div class="blog__inner">
            <div class="left mt70">
                <div class="blog__wrap">
                    <div class="cards__inner col2 row line2">
<?php foreach($categoryResult as $blog){ ?>
    <div class="card">
        <figure class="card__img">
            <a href="blogView.php?blogID=<?=$blog['blogID']?>">
                <img src="../assets/blog/<?=$blog['blogImgFile']?>" alt="<?=$blog['blogTitle']?>">
            </a>
        </figure>
        <div class="card__title">
            <h3><a href="blogView.php?blogID=<?=$blog['blogID']?>"><?=$blog['blogTitle']?></a></h3>
            <p><?=$blog['blogContents']?></p>
        </div>
    </div>
<?php } ?>
                    </div>
                </div>
            </div>
            <div class="right mt70">
                <div class="blog__aside">
                    <?php include "../include/blogTitle.php" ?>
                    <?php include "../include/blogCate.php" ?>
                    <?php include "../include/blogLatest.php" ?>
                    <?php include "../include/blogPopular.php" ?>
                    <?php include "../include/blogComment.php" ?>
                </div>
            </div>
        </div>
        <!-- //blog__inner -->

        <div class="blog__article">
            <h3>관련글</h3>
            <?php  include "../include/blogArticle.php" ?>
        </div>
        <!-- //blog__article -->

        <div class="blog__comment">
            <h3>댓글쓰기</h3>
            <div></div>
        </div>
        <!-- //blog__comment -->
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>
</html>