<?php

namespace Anax\View;

?>
<h1>Weather Information</h1>
<p>Enter an IP Address and recieve weather information!</p>
<form action="">
    <input type="text" name="ipAddress" placeholder="ip...">
    <button type="submit">Show</button>
</form>

<h1>API Documentation</h1>

<p>To validate an IP address send a GET request to the following endpoint:</p>

<pre class="code-block">
<?= "{$this->di->request->getBaseUrl()}/api/weather"; ?>
</pre>

<p>Set <strong>ipAddress</strong> to the ip you want to fetch data for.</p>

<p>The result will be returned as JSON</p>

<h3>Test Routes</h3>

<form action="<?= "{$this->di->request->getBaseUrl()}/api/weather"; ?>" method="GET" class="mb-1">
    <input type="hidden" name="ipAddress" value="194.47.150.9">
    <button type="submit">Test: 194.47.150.9 (valid)</button>
</form>

<form action="<?= "{$this->di->request->getBaseUrl()}/api/weather"; ?>" method="GET" class="mb-1">
    <input type="hidden" name="ipAddress" value="2001:0db8:85a3:0000:0000:8a2e:0370:7334">
    <button type="submit">Test: 2001:0db8:85a3:0000:0000:8a2e:0370:7334 (valid but no data)</button>
</form>

<form action="<?= "{$this->di->request->getBaseUrl()}/api/weather"; ?>" method="GET">
    <input type="hidden" name="ipAddress" value="dsadsad.dasffsfads.dasdas">
    <button type="submit">Test: dsadsad.dasffsfads.dasdas (invalid)</button>
</form>