<?php
// define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
// define( "URL_DB", DOC_ROOT. "db/db_common.php" );
// include_once( URL_DB );

define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("URL_DB", DOC_ROOT . "db/db_common.php");
include_once(URL_DB);

if (array_key_exists("page_num", $_GET)) {
    $page = $_GET["page_num"];
} else {
    $page = 1;
}

$limit_num = 5;
$result_cnt = select_board_info_cnt();
// $offset = ($page > 1) ? ($page_limit * ($page - 1)) : 0;
// $pages = ($result_cnt % $page_limit == 0) ? ($result_cnt / $limit_num) : (round($result_cnt / $limit_num, 0) + 1);
$offset = ($page * $limit_num) - $limit_num;
$num_pages = ceil((int)$result_cnt[0]["cnt"] / $limit_num);
// echo $num_pages;

$arr_prepare =
    array(
        "limit_num" => $limit_num, "offset" => $offset
    );
$result_pasing = select_board_info_paging($arr_prepare);
// print_r($result_cnt);

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유 게시판</title>
    <link rel="stylesheet" href="./css/default.css">
</head>

<body>
    <div class="content-wrap">
        <div class="title">
            <div class="page-title">
                <h3>자유 게시판 미니 프로젝트</h3>
            </div>
        </div>
        <div class="content">
            <input type="hidden" name="boardMode" value="list">
            <div class="board list ys-board">
                <div class="common">
                    <div class="board-wrap board-qa">
                        <table class="board-table">
                            <caption class="hide">미니 &gt; 자유 &gt; 게시판</caption>
                            <colgroup>
                                <col width="10%">
                                <col width="*">
                                <col width="15%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">제목</th>
                                    <th scope="col">등록일</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result_pasing as $recode) {
                                ?>
                                    <tr class="  ">
                                        <td class="">
                                            <?php
                                            echo $recode["board_no"]
                                            ?>
                                        </td>
                                        <td class="text-left">
                                            <div class="c-board-title-wrap">
                                                <a href="#" class="c-board-title">
                                                    <?php
                                                    echo $recode["board_title"]
                                                    ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            echo $recode["create_date"]
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <ul class="paging-wrap">
                        <li><a href='index.php?page_num=<?php if((int)$page > 1 && (int)$page < $num_pages){ echo (int)$page - 1;}?>' class='btn01'>Prev</a></li>
                        <?php
                        for ($i = 1; $i <= $num_pages; $i++) {
                            if ($i === (int)$page) {
                        ?>
                                <li><a href="index.php?page_num=<?php echo $i ?>" class="page-icon active"><?php echo $i ?></a></li>
                            <?php
                            } else {
                            ?>
                                <li><a href="index.php?page_num=<?php echo $i ?>" class="page-icon"><?php echo $i ?></a></li>
                        <?php
                            }
                        }
                        
                        ?>
                        <li><a href='index.php?page_num=<?php if ((int)$page > 1 && (int)$page < $num_pages) { echo (int)$page + 1; } ?>' class='btn01'>Next</a></li>
                    </ul>
                    <ul class="btn-wrap text-right">
                        <li>
                            <a class="btn btn01" href="#">글쓰기</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>