<div class="cate list2">
    <h4>최신 글</h4>
    <ul>
        <?php
            $blogLatest = "SELECT * FROM blog WHERE blogDelete = 0 ORDER BY blogID DESC LIMIT 4";
            $blogLatestResult = $connect -> query($blogLatest);

            foreach($blogLatestResult as $blog) { ?>
                <li>
                    <a href="blogView.php?blogID=<?=$blog['blogID']?>">
                        <img src="../assets/blog/<?=$blog['blogImgFile']?>" alt="<?=$blog['blogTitle']?>">
                        <span><?=$blog['blogTitle']?></span>
                    </a>
                </li>
            <?php }
        ?>
    </ul>
</div>