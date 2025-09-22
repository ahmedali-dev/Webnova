<h1>welcome from home page</h1>
<div id="div">hello <?= isset($name) ? $name : 'no name found' ?></div>

<?php
    if (isset($params['errors'])) {
        foreach ($errors as $field => $error) {
            $m = <<< EOF
                <div id='div'>$field => $error</div>
            EOF;
            echo $m;
        }
    }
?>
