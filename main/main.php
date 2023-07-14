<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP BLOG SITE</title>

    <?php include "../include/head.php" ?>
</head>
<body class="gray">

    <?php include "../include/skip.php" ?>
    <!-- skip -->

    <?php include "../include/header.php" ?>
    <!-- header --> 

    <main id="main" class="container">
        <div class="intro__inner bmStyle">
            <picture class="intro__images">
                <source srcset="../assets/img/intro01.png, ../assets/img/intro01@2x.png 2x"/>
                <img src="../assets/img/intro01.png" alt="introimg">
            </picture>
            <p class="intro__text">
                사람은 배울수록 세상을 넓게 볼 수 있다고 합니다. <br>
                새로운 기술과 도전을 두려워하지 않고 열정적으로 학습하여 더 넓은 시야와 다양한 시각으로 세상을 바라보며,<br>
                어제보다 더 나은 오늘을 결과로 보여드리는 개발자가 되겠습니다.
            </p>
        </div>
        <div class="blog__inner">
            <div class="blog__wrap">
                <h2>NEW posts</h2>
                <div class="cards__inner col4 line3">
<?php
    $sql = "SELECT * FROM blog WHERE blogDelete = 0 ORDER BY blogID DESC LIMIT 8";
    $result = $connect -> query($sql);
?>

<?php foreach($result as $blog){?>
        <div class="card">
            <figure class="card__img">
                <a href="../blog/blogView.php?blogId=<?=$blog['blogID']?>">
                    <img src="../assets/blog/<?=$blog['blogImgFile'] ?>" alt="<?=['blogTitle']?>">
                </a>
            </figure>
            <div class="card__title">
                <h3><?=$blog['blogTitle'] ?></h3>
                <p><?=$blog['blogContents']?></p>
            </div>
        </div>
<?php } ?>
                    </div>
                </div>
            </div>

    </main>
    <!-- main -->
    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>