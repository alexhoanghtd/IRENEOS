

<div id="content-wrapper" class="clearfix">
    <!--CONTENT BODY WRAPPER NO PADDING!--> 
    <div id="product-content-container">

        <!--GRID VIEW CONTAINER--> 
        <div id="grid-view-wrapper" class="clearfix grid-3-cols">
            <ul id="collection-grid" class="ic-main-grid">
                <?php for ($i = 0; $i <= count($data) - 1; $i++) { ?>
                    <li>
                        <a href="View/<?= $data[$i]['id'] ?>">
                            <div class="collection-item-wrapper" style="background-image:url(<?php echo "'" . $data[$i]['coverURL'] . "'" ?>)">
                                <div class="colection-hover">
                                    <div class="collection-title fit-me-top">
                                        <h2><?php echo $data[$i]['name'] ?></h2>
                                    </div>
                                    <div class="collection-detail fit-me-bottom">
                                        <ul>
                                            <li><?php echo $data[$i]['vote'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>           
                <?php } ?>
            </ul>
        </div>
    </div>				

</div>