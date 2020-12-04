<?php

namespace Anax\View;

?>




<h1>Weather Information</h1>
<p>Enter an IP Address and recieve weather information!</p>
<form action="">
    <input type="text" name="ipAddress" placeholder="ip..." value="<?= $ipAddress; ?>">
    <button type="submit">Show</button>
</form>

<h1>Error</h1>
<p><?= $message; ?></p>



