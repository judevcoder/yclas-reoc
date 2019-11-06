<?if (core::config('advertisement.dropbox_app_key')):?>
    <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?=core::config('advertisement.dropbox_app_key')?>"></script>
<?endif?>
<?if (core::config('advertisement.picker_api_key') AND core::config('advertisement.picker_client_id')):?>
    <script type="text/javascript" id="googlepickerjs">
        var developerKey = '<?=core::config('advertisement.picker_api_key')?>';
        var clientId = "<?=core::config('advertisement.picker_client_id')?>";
        var scope = ['https://www.googleapis.com/auth/drive'];
        var authApiLoaded = false;
        var pickerApiLoaded = false;
        var oauthToken;
        var viewIdForhandleAuthResult;
    </script>
<?endif?>