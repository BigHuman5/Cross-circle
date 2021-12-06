<?php
echo session_id();
include 'templates/head.html';
include 'templates/header.php';
?>

<section class="main">
        <h1>крестики-нолики</h1>
        <ul>
            <li><a href="game" options='{"type":3, "lvl":2}'>3х3</a></li>
            <li><a href="game" options='{"type":5, "lvl":2}'>5х5</a></li>
            <li><a href="game" options='{"type":7, "lvl":2}'>7х7</a></li>
        </ul>
</section>
<script src="js/main.js"></script>
</body>
</html>