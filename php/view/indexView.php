<?php
include 'templates/head.html';
include 'templates/header.php';
?>

<section class="main">
        <h1>крестики-нолики</h1>
        <div class="state__title">1 уровень</div>
        <ul>
            <li><a href="game" options='{"type":3, "lvl":1}'>3х3</a></li>
            <li><a href="game" options='{"type":5, "lvl":1}'>5х5</a></li>
            <li><a href="game" options='{"type":7, "lvl":1}'>7х7</a></li>
        </ul>
        <div class="state__title">2 уровень</div>
        <ul>
            <li><a href="game" options='{"type":3, "lvl":2}'>3х3</a></li>
            <li><a href="game" options='{"type":5, "lvl":2}'>5х5</a></li>
            <li><a href="game" options='{"type":7, "lvl":2}'>7х7</a></li>
        </ul>
</section>
<script src="js/main.js"></script>
</body>
</html>