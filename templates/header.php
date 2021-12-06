<?php $path = explode("/", $_SERVER["REQUEST_URI"]); ?>
<header>
    <div><a href="
    <?php echo $path[1]; ?>
    "><img src="jpg/Mask Group.png" alt=""></a></div>
    <div><a href="
    <?php echo "".$path[1]."/statics" ?>
    ">Cтатистика</a></div>
</header>