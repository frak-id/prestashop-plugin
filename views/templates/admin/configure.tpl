<div class="panel">
    <h3><i class="icon icon-cogs"></i> {l s='Frak Integration Configuration' mod='frakintegration'}</h3>
    <form id="module_form" class="defaultForm form-horizontal" action="{$form_action}" method="post">
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Enable Floating Button' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input type="radio" name="FRAK_FLOATING_BUTTON_ENABLED" id="FRAK_FLOATING_BUTTON_ENABLED_on" value="1" {if $floating_button_enabled}checked="checked"{/if}>
                    <label for="FRAK_FLOATING_BUTTON_ENABLED_on">{l s='Yes' mod='frakintegration'}</label>
                    <input type="radio" name="FRAK_FLOATING_BUTTON_ENABLED" id="FRAK_FLOATING_BUTTON_ENABLED_off" value="0" {if !$floating_button_enabled}checked="checked"{/if}>
                    <label for="FRAK_FLOATING_BUTTON_ENABLED_off">{l s='No' mod='frakintegration'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Enable Sharing Button' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input type="radio" name="FRAK_SHARING_BUTTON_ENABLED" id="FRAK_SHARING_BUTTON_ENABLED_on" value="1" {if $sharing_button_enabled}checked="checked"{/if}>
                    <label for="FRAK_SHARING_BUTTON_ENABLED_on">{l s='Yes' mod='frakintegration'}</label>
                    <input type="radio" name="FRAK_SHARING_BUTTON_ENABLED" id="FRAK_SHARING_BUTTON_ENABLED_off" value="0" {if !$sharing_button_enabled}checked="checked"{/if}>
                    <label for="FRAK_SHARING_BUTTON_ENABLED_off">{l s='No' mod='frakintegration'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Sharing Button Text' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_SHARING_BUTTON_TEXT" value="{$sharing_button_text}" />
            </div>
        </div>
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
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Webhook Secret' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <div class="input-group">
                    <input type="text" name="FRAK_WEBHOOK_SECRET" value="{$webhook_secret}" />
                    <span class="input-group-btn">
                        <button type="submit" name="generateFrakWebhookSecret" class="btn btn-default">{l s='Generate' mod='frakintegration'}</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" value="1" id="module_form_submit_btn" name="submitFrakIntegration" class="btn btn-default pull-right">
                <i class="process-icon-save"></i> {l s='Save' mod='frakintegration'}
            </button>
        </div>
    </form>
</div>

<div class="panel">
    <h3><i class="icon icon-cogs"></i> {l s='Frak Webhook Management' mod='frakintegration'}</h3>
    <div class="form-group">
        <label class="control-label col-lg-3">{l s='Product ID' mod='frakintegration'}</label>
        <div class="col-lg-9">
            <p class="form-control-static">{$product_id}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3">{l s='Webhook Status' mod='frakintegration'}</label>
        <div class="col-lg-9">
            <p class="form-control-static">
                {if $webhook_status}
                    <span class="label label-success">{l s='Webhook is set up' mod='frakintegration'}</span>
                {else}
                    <span class="label label-danger">{l s='Webhook is not set up' mod='frakintegration'}</span>
                {/if}
            </p>
        </div>
    </div>
    <div class="panel-footer">
        <form action="{$form_action}" method="post">
            {if $webhook_status}
                <button type="submit" name="submitFrakWebhookDelete" class="btn btn-danger">
                    <i class="process-icon-delete"></i> {l s='Delete Webhook' mod='frakintegration'}
                </button>
            {else}
                <button type="submit" name="submitFrakWebhook" class="btn btn-primary">
                    <i class="process-icon-new"></i> {l s='Create Webhook' mod='frakintegration'}
                </button>
            {/if}
        </form>
    </div>
</div>
