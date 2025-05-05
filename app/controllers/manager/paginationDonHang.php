<div class="content__page">

    <?php

    $param = "";
    $from_date = '';
    $to_date = '';
    if ($search_donhang) {
        $param = "search_donhang=" . $search_donhang;
    }

    if ($start_date && $end_date) {
        $from_date = "start_date=".$start_date;
        $to_date = "end_date=".$end_date;
        exit;
    }

    if ($current_page > 3) {
        $first_page = 1;
    ?>
        <a class="page__item" href="/CuaHangGiaDung/public/manager/index.php?page=donhang&donhang.php?<?=$param?>&<?=$from_date?>&<?=$to_date?>&per_page=<?= $item_per_page ?>&pages=<?= $first_page ?>">Trang đầu</a>
    <?php

    }

    if ($current_page > 1) {
        $prev_page = $current_page - 1;
    ?>
        <a class="page__item" href="/CuaHangGiaDung/public/manager/index.php?page=donhang&donhang.php?<?=$param?>&<?=$from_date?>&<?=$to_date?>&per_page=<?= $item_per_page ?>&pages=<?= $prev_page ?>">Trang trước</a>

    <?php } ?>

    <?php for ($sum = 1; $sum <= $totalPages; $sum++) { ?>
        <?php if ($sum != $current_page) { ?>
            <a class="page__item" href="/CuaHangGiaDung/public/manager/index.php?page=donhang&donhang.php?<?=$param?>&<?=$from_date?>&<?=$to_date?>&per_page=<?= $item_per_page ?>&pages=<?= $sum ?>"><?= $sum ?></a>
        <?php } else { ?>
            <strong class="page__item current_page_item"><?= $sum ?></strong>
        <?php } ?>
    <?php } ?>


    <?php

    if ($current_page < $totalPages - 1) {
        $next_page = $current_page + 1;
    ?>
        <a class="page__item" href="/CuaHangGiaDung/public/manager/index.php?page=donhang&donhang.php?<?=$param?>&<?=$from_date?>&<?=$to_date?>&per_page=<?= $item_per_page ?>&pages=<?= $next_page ?>">Trang sau</a>

    <?php }

    if ($current_page < $totalPages - 3) {
        $end_page = $totalPages;
    ?>
        <a class="page__item" href="/CuaHangGiaDung/public/manager/index.php?page=donhang&donhang.php?<?=$param?>&<?=$from_date?>&<?=$to_date?>&per_page=<?= $item_per_page ?>&pages=<?= $end_page ?>">Trang cuối</a>
    <?php } ?>
</div>