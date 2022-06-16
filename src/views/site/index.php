<?php

/** @var yii\web\View $this */

$this->title = 'API Test';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <form id="test1-form">
                    <label for="currency">Currency filter (separated by commas)</label><br>
                    <input id="currency" type="text"><br>
                    <button id="test1-btn">GET RATES</button>
                </form>

                <div id="result1" class="m-2"></div>
            </div>
            <div class="col-lg-4">
                <h3>Converter</h3>
                <form id="test2-form">
                    <label for="currency_from">FROM</label>
                    <input id="currency_from" type="text" value="BTC"><br>
                    <label for="currency_to">TO</label>
                    <input id="currency_to" type="text" value="USD"><br>
                    <label for="value">VALUE</label>
                    <input id="value" type="text" value="0.01"><br>
                    <button id="test2-btn">CONVERT</button>
                </form>

                <div id="result2" class="m-2"></div>
            </div>
        </div>

    </div>
</div>
