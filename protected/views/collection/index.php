

<div id="content-wrapper" class="clearfix">
    <!--CONTENT BODY WRAPPER NO PADDING!-->
    <div id="product-content-container">

        <!--GRID VIEW CONTAINER-->
        <div id="grid-view-wrapper" class="clearfix grid-3-cols">
            <ul id="collection-grid" class="ic-main-grid">
                <?php foreach ($data as $value) {
                ?>
                    <li>
                        <a href="View/<?= $value['id'] ?>">
                            <div class="collection-item-wrapper" style="background-image:url(<?php echo "'" . $value['coverUrl'] . "'" ?>)">
                                <div class="colection-hover">
                                    <div class="collection-title fit-me-top">
                                        <h2><?php echo $value['name'] ?></h2>
                                    </div>
                                    <div class="collection-detail fit-me-bottom">
                                        <ul>
                                            <li><?php echo $value['start_date'] ?></li>
                                            <li><?php echo $value['description'] ?></li>
                                            <li>30</li>
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