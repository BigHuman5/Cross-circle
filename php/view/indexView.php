<?php
include 'templates/head.html';
include 'templates/header.php';
?>

<section class="main">
        <h1>крестики-нолики</h1>
        <ul>
            <li><a href="game" options='{"type":3, "lvl":1}'>3х3 л</a></li>
            <li><a href="game" options='{"type":3, "lvl":2}'>3х3 с</a></li>
            <li><a href="game" options='{"type":5, "lvl":1}'>5х5 л</a></li>
            <li><a href="game" options='{"type":5, "lvl":2}'>5х5 с</a></li>
            <li><a href="game" options='{"type":7, "lvl":1}'>7х7 л</a></li>
            <li><a href="game" options='{"type":7, "lvl":2}'>7х7 с</a></li>
        </ul>
</section>
<script src="js/main.js"></script>
</body>
</html>