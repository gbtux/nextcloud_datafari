<div id="datafari" class="section">
    <h2 class="inlineblock">Datafari</h2>
    <p>Datafari SearchProxy Address</p>
    <form>
        <input style="width: 320px" id="searchProxyUrl" value="<?php p($_["search_proxy_URL"]) ?>" placeholder="http://demo.datafari.com/Datafari" type="text">/SearchProxy
        <input type="button" id="submitDatafariURL" value="Enregistrer">
    </form>
</div>
<?php
script('datafari', 'admin');
?>