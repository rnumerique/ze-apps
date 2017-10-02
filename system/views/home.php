<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="content" class="home">
    <div class="row">
        <?php if (count($menuTopCol1) > 0) { ?>
            <div class="col-sm-6">
                <?php
                foreach ($menuTopCol1 as $menuSpace) {
                    if(sizeof($menuSpace["item"]) > 0){
                        ?>
                        <div class="title">
                            <?php echo $menuSpace["info"]["name"]; ?>
                        </div>
                        <ul class="nav">
                            <?php foreach ($menuSpace["item"] as $menuItem) { ?>
                                <li>
                                    <a href="<?php echo $menuItem["url"]; ?>"><?php echo $menuItem["label"]; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
        <?php if (count($menuTopCol2) > 0) { ?>
            <div class="col-sm-6">
                <?php
                foreach ($menuTopCol2 as $menuSpace) {
                    if(sizeof($menuSpace["item"]) > 0){
                        ?>
                        <div class="title"><?php echo $menuSpace["info"]["name"]; ?></div>
                        <ul class="nav">
                            <?php foreach ($menuSpace["item"] as $menuItem) { ?>
                                <li>
                                    <a href="<?php echo $menuItem["url"]; ?>"><?php echo $menuItem["label"]; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>