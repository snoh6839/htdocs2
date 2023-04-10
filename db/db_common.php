<?php
function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board_project";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option =
        array(
            PDO::ATTR_EMULATE_PREPARES => false
            ,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
    
    try {
        $param_conn = new PDO ($dns, $user, $pass, $pdo_option);
        return true;
    } catch (EXCEPTION $e) {
        $param_conn = null;
        throw new Exception($e->getMessage());
        
    }

}

function select_board_info_paging( &$param_arr ){
    $sql =
        " select "
            . " board_no "
            ." , board_title "
            ." , create_date "
        ." from "
            ." board_info "
        ." where "
            ." del_flag = '0' "
        ." order by "
            ." board_no  DESC "
        ." limit :limit_num offset :offset "
        ;
    
    $arr_prepare =
        array(
            ":limit_num" => $param_arr["limit_num"]
            ,":offset" => $param_arr["offset"]
        );
    // $conn = null;
    try{
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $result = $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result;

    
}

function select_board_info_cnt()
{
    $sql =
        " select "
        . " count(*) as cnt "
        . " from "
        . " board_info "
        . " where "
        . " del_flag = '0' "
        ;

    $arr_prepare =
        array();
        
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch (EXCEPTION $e) {
        return $e->getMessage();
        // return false;
    } finally {
        $conn = null;
    }

    return $result;
}
//TODO : test start
// $arr =
//     array(
//         "limit_num" => 5
//         , "offset" => 0
//     );
// $result = select_board_info_paging($arr);
// print_r($result);
//TODO : test end
?>