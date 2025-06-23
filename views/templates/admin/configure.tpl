<div class="panel">
    <h3><i class="icon icon-cogs"></i> {l s='Frak Integration Configuration' mod='frakintegration'}</h3>
    <form id="module_form" class="defaultForm form-horizontal" action="{$form_action}" method="post">
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Shop Name' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_SHOP_NAME" value="{$shop_name}" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Logo URL' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_LOGO_URL" value="{$logo_url}" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Language' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <select name="FRAK_MODAL_LNG">
                    <option value="default" {if $modal_lng == 'default'}selected="selected"{/if}>{l s='Default' mod='frakintegration'}</option>
                    <option value="en" {if $modal_lng == 'en'}selected="selected"{/if}>{l s='English' mod='frakintegration'}</option>
                    <option value="fr" {if $modal_lng == 'fr'}selected="selected"{/if}>{l s='French' mod='frakintegration'}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='i18n Customizations' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <textarea name="FRAK_MODAL_I18N" rows="10" cols="50">{$modal_i18n}</textarea>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" value="1" id="module_form_submit_btn" name="submitFrakIntegration" class="btn btn-default pull-right">
                <i class="process-icon-save"></i> {l s='Save' mod='frakintegration'}
            </button>
        </div>
    </form>
</div>
