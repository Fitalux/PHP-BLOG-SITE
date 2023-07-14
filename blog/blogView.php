<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if(isset($_SESSION['memberID'])) {
        $memberID = $_SESSION['memberID'];
    } else {
        $memberID = 0;
    }

    if(isset($_GET['blogID'])) {
        $blogID = $_GET['blogID'];        
    } else {
        Header("Location: blog.php");
    }

    //조회수(블로그 View +1 )
    $sql = "UPDATE blog SET blogView = blogView + 1 WHERE blogID = {$blogID}";
    $connect -> query($sql);


    $blogSql = "SELECT * FROM blog WHERE blogID = '$blogID'";
    $blogResult = $connect -> query($blogSql);
    $blogInfo = $blogResult -> fetch_array(MYSQLI_ASSOC);

    $commentSql = "SELECT * FROM blogcomment WHERE blogID = '$blogID' AND commentDelete = '0' ORDER BY commentID DESC";
    $commentResult = $connect -> query($commentSql);
    $commentInfo = $commentResult -> fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title> 

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
        <div class="blog__title" style="background-image:url(../assets/blog/<?=$blogInfo['blogImgFile']?>)">
            <span class="cate"><?=$blogInfo['blogCategory'] ?></span>
            <h2 class="title"><?=$blogInfo['blogTitle'] ?></h2>
            <div class="info">
                <span class="author"><?=$blogInfo['blogAuthor'] ?></span>
                <span class="date"><?=date('Y-m-d', $blogInfo['blogRegTime'])?></span>
                <div class="modify">
                    <a href="#">수정</a>
                    <a href="#">삭제</a>
                </div>
            </div>
        </div>
        <!-- //blog__title -->

        <div class="blog__inner">
            <div class="left mt70">
                <div class="blog__contents">
                    <h3><?=$blogInfo['blogTitle'] ?></h3>
                    <?=$blogInfo['blogContents'] ?>
                </div>
            </div>
            <div class="right mt70">
                <div class="blog__aside">
                    <?php  include "../include/blogTitle.php" ?>

                    <?php  include "../include/blogCate.php" ?>

                    <?php  include "../include/blogLatest.php" ?>

                    <?php  include "../include/blogPopular.php" ?>

                    <?php  include "../include/blogComment.php" ?>
                </div>
            </div>
        </div>
        <!-- //blog__inner -->

        <div class="blog__article">
            <h3>관련글</h3>
            <?php  include "../include/blogArticle.php" ?>
        </div>
        <!-- //blog__article -->

        <div class="blog__comment" id="blogComment">
            <h3>댓글쓰기</h3>

            <?php
                foreach($commentResult as $comment) { ?>
                    <div class="comment__view" id="comment<?=$comment['commentID']?>">
                        <div class="avatar">
                            <img src="https://t1.daumcdn.net/tistory_admin/blog/admin/profile_default_06.png" alt="">
                        </div>
                        <div class="info">
                            <span class="nickname"><?=$comment['commentName']?></span>
                            <span class="date"><?=date('Y-m-d',$comment['regTime'])?></span>
                            <p class="msg"><?=$comment['commentMsg']?></p>
                            <div class="del">
                                <a href="#" class="comment__del__del">삭제</a>
                                <a href="#" class="comment__del__mod">수정</a>
                            </div>
                        </div>
                    </div>
                <?php }

            ?>

            <!-- 삭제 -->
            <div class="comment__delete" style="display: none">
                <label for="commentDeletePass" class="blind">비밀번호</label>
                <input type="password" id="commentDeletePass" name="commentDeletePass" placeholder="비밀번호">
                <button id="commentDeleteCancel">취소</button>
                <button id="commentDeleteButton">삭제</button>
            </div>
            <!-- //삭제 -->

            <!-- 수정 -->
            <div class="comment__modify" style="display: none">
                <label for="commentModifyMsg" class="blind">수정 내용</label>
                <textarea name="commentModifyMsg" id="commentModifyMsg" cols rows="4" placeholder="수정할 내용을 작성하세요." maxlength="255" required></textarea>
                <label for="commentModifyPass" class="blind">비밀번호</label>
                <input type="password" id="commentModifyPass" name="commentModifyPass" placeholder="비밀번호" required>
                <button id="commentModifyCancel">취소</button>
                <button id="commentModifyButton">수정</button>
            </div>
            <!-- //수정 -->

            <div class="comment__write">
                <form action="#">
                    <fieldset>
                        <legend class="blind">댓글 작성</legend>
                        <label for="commentPass" class="blind">비밀번호</label>
                        <input type="password" id="commentPass" name="commentPass" placeholder="비밀번호" required>
                        <label for="commentName" class="blind">이름</label>
                        <input type="text" id="commentName" name="commentName" placeholder="이름" required>
                        <label for="commentWrite" class="blind">댓글 작성</label>
                        <textarea id="commentWrite" name="commentWrite" rows="4" placeholder="내용을 입력하세요." maxlength="255" required></textarea>
                        <button type="submit" id="commentWriteBtn" class="btnStyle3 mt10">등록</button>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- //blog__comment -->
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        let commentID = "";

        //댓글 수정 btn
        $(".comment__del__mod").click(function(e){
            e.preventDefault();
            // alert("댓글 수정 btn");

            $(this).parent().before($(".comment__modify"));
            $(".comment__modify").show();
            $(".comment__delete").hide();
            commentID = $(this).parent().parent().parent().attr("id");
        });

        //댓글 수정 -> 취소 btn
        $("#commentModifyCancel").click(function(){
            $(".comment__modify").hide();
        })

        //댓글 수정 -> 수정 btn
        $("#commentModifyButton").click(function(){
            let number = commentID.replace(/[^0-9]/g, "");
            if($("#commentModifyPass").val() == ""){
                alert("댓글 작성시 비밀번호를 작성해주세요!");
                $("#commentModifyButton").focus();
            } else {
                $.ajax({
                    url: "blogCommentModify.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "commentMsg": $("#commentModifyMsg").val(),
                        "commentPass": $("#commentModifyPass").val(),
                        "commentID": number,
                    },
                    success: function(data){
                        console.log(data);
                        if(data.result == "bad"){
                            alert("비밀번호가 올바르지 않습니다.");
                        } else {
                            alert("댓글이 수정되었습니다.");
                        }
                        location.reload();
                    },
                    error: function(request, status, error){
                        console.log("request" + request);
                        console.log("status" + status);
                        console.log("error" + error);
                    }
                })
            }
        });

        //댓글 삭제 btn
        $(".comment__del__del").click(function(e){
            e.preventDefault();
            // alert("댓글 삭제 btn");
            $(this).parent().before($(".comment__delete"));
            $(".comment__delete").show();
            $(".comment__modify").hide()

            commentID = $(this).parent().parent().parent().attr("id");
            // alert(commentID);
        });

        //댓글 삭제 -> 취소 btn
        $("#commentDeleteCancel").click(function(){
            $(".comment__delete").hide();
        });

        //댓글 삭제 -> 삭제 btn
        $("#commentDeleteButton").click(function(){
            let number = commentID.replace(/[^0-9]/g, "");

            if($("#commentDeletePass").val() == "") {
                alert("댓글 작성시 사용한 비밀번호를 작성하세요.");
                $("#commentDeletePass").focus();
            } else {
                $.ajax ({
                    url: "blogCommentDelete.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "commentPass": $("#commentDeletePass").val(),
                        "commentID": number,
                    },
                    success: function(data){
                        console.log(data);
                        if(data.result == "bad"){
                            alert("비밀번호가 올바르지 않습니다.");
                        } else {
                            alert("댓글이 삭제되었습니다.");
                        }
                        location.reload();
                    },
                    error: function(request, status, error) {
                        console.log("request" + request);
                        console.log("status" + status);
                        console.log("error" + error);
                    }
                })
            }
        });


        //댓글 작성 btn
        $("#commentWriteBtn").click(function(){
            $("#blogComment").focus();
            if($("#commentWrite").val() == ""){
                alert("내용을 작성하세요.");
                $("#commentWrite").focus();
            } else {
                $.ajax ({
                    url: "blogCommentWrite.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "blogID": <?=$blogID?>,
                        "memberID": <?=$memberID?>,
                        "name": $("#commentName").val(),
                        "pass": $("#commentPass").val(),
                        "msg": $("#commentWrite").val(),
                    },
                    success: function(data){
                        console.log(data);
                        location.reload();
                        location.href = "blogView.php";
                    },
                    error: function(request, status, error){
                        console.log("request" + request);
                        console.log("status" + status);
                        console.log("error" + error);
                    }
                });
            }
        });
    </script>

</body>
</html>