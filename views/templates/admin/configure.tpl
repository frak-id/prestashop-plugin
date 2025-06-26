<div class="panel">
    <h3><i class="icon icon-toggle-on"></i> {l s='Buttons' mod='frakintegration'}</h3>
    <form id="module_form_buttons" class="defaultForm form-horizontal" action="{$form_action}" method="post">
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
            <label class="control-label col-lg-3">{l s='Sharing Button Style' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <select name="FRAK_SHARING_BUTTON_STYLE" id="frak_sharing_button_style">
                    <option value="primary" {if isset($sharing_button_style) && $sharing_button_style == 'primary'}selected="selected"{/if}>{l s='Primary' mod='frakintegration'}</option>
                    <option value="secondary" {if !isset($sharing_button_style) || $sharing_button_style == 'secondary'}selected="selected"{/if}>{l s='Secondary' mod='frakintegration'}</option>
                    <option value="custom" {if isset($sharing_button_style) && $sharing_button_style == 'custom'}selected="selected"{/if}>{l s='Custom' mod='frakintegration'}</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="frak_sharing_button_custom_style_group" {if !isset($sharing_button_style) || $sharing_button_style != 'custom'}style="display: none;"{/if}>
            <label class="control-label col-lg-3">{l s='Custom CSS Class' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_SHARING_BUTTON_CUSTOM_STYLE" value="{if isset($sharing_button_custom_style)}{$sharing_button_custom_style}{/if}" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Floating Button Position' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <select name="FRAK_FLOATING_BUTTON_POSITION">
                    <option value="right" {if $floating_button_position == 'right'}selected="selected"{/if}>{l s='Right' mod='frakintegration'}</option>
                    <option value="left" {if $floating_button_position == 'left'}selected="selected"{/if}>{l s='Left' mod='frakintegration'}</option>
                </select>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" value="1" name="submitFrakButtons" class="btn btn-default pull-right">
                <i class="process-icon-save"></i> {l s='Save' mod='frakintegration'}
            </button>
        </div>
    </form>
</div>

<div class="panel">
    <h3><i class="icon icon-paint-brush"></i> {l s='Modal Personnalisations' mod='frakintegration'}</h3>
    <form id="module_form_modal" class="defaultForm form-horizontal" action="{$form_action}" method="post">
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
        <hr>
        <h4>{l s='Internationalization' mod='frakintegration'}</h4>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Login (referrer)' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_MODAL_I18N[sdk.wallet.login.text_sharing]" value="{if isset($modal_i18n['sdk.wallet.login.text_sharing'])}{$modal_i18n['sdk.wallet.login.text_sharing']}{/if}" />
                <p class="help-block">{l s='Text displayed in the login modal when a user is a referrer.' mod='frakintegration'}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Login (referred)' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_MODAL_I18N[sdk.wallet.login.text_referred]" value="{if isset($modal_i18n['sdk.wallet.login.text_referred'])}{$modal_i18n['sdk.wallet.login.text_referred']}{/if}" />
                <p class="help-block">{l s='Text displayed in the login modal when a user is referred.' mod='frakintegration'}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Login Button' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_MODAL_I18N[sdk.wallet.login.primaryAction]" value="{if isset($modal_i18n['sdk.wallet.login.primaryAction'])}{$modal_i18n['sdk.wallet.login.primaryAction']}{/if}" />
                <p class="help-block">{l s='Text for the primary action button in the login modal.' mod='frakintegration'}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Sharing Title' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_MODAL_I18N[sharing.title]" value="{if isset($modal_i18n['sharing.title'])}{$modal_i18n['sharing.title']}{/if}" />
                <p class="help-block">{l s='Title of the sharing modal.' mod='frakintegration'}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Sharing Text' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <input type="text" name="FRAK_MODAL_I18N[sharing.text]" value="{if isset($modal_i18n['sharing.text'])}{$modal_i18n['sharing.text']}{/if}" />
                <p class="help-block">{l s='Text displayed alongside the sharing link.' mod='frakintegration'}</p>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" value="1" name="submitFrakModal" class="btn btn-default pull-right">
                <i class="process-icon-save"></i> {l s='Save' mod='frakintegration'}
            </button>
        </div>
    </form>
</div>

<div class="panel">
    <h3><i class="icon icon-cogs"></i> {l s='Frak Webhook Management' mod='frakintegration'}</h3>
    <form id="webhook_form" class="defaultForm form-horizontal" action="{$form_action}" method="post">
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Webhook Secret' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <div class="input-group">
                    <input type="text" name="FRAK_WEBHOOK_SECRET" value="{$webhook_secret}" readonly />
                    <span class="input-group-btn">
                        {if $webhook_secret}
                            <button type="submit" name="generateFrakWebhookSecret" class="btn btn-default" onclick="return confirm('{l s='Are you sure you want to regenerate the webhook secret? This will break the integration if you have already configured it on Frak.' mod='frakintegration'}');">
                                {l s='Regenerate' mod='frakintegration'}
                            </button>
                        {else}
                            <button type="submit" name="generateFrakWebhookSecret" class="btn btn-default">
                                {l s='Generate' mod='frakintegration'}
                            </button>
                        {/if}
                    </span>
                </div>
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
        <div class="form-group">
            <label class="control-label col-lg-3">{l s='Manage Webhook' mod='frakintegration'}</label>
            <div class="col-lg-9">
                <a id="open-webhook-popup" href="#" class="btn btn-default">
                    <i class="icon-cog"></i> {l s='Create Webhook' mod='frakintegration'}
                </a>
                <a href="{$frak_product_url}" target="_blank" class="btn btn-default">
                    <i class="icon-external-link"></i> {l s='Manage on Frak' mod='frakintegration'}
                </a>
            </div>
        </div>
    </form>
    <div class="panel-footer">
        <h4>Info</h4>
        <p>Domain: {$domain}</p>
        <p>Product ID: {$product_id}</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const styleSelect = document.getElementById('frak_sharing_button_style');
        const customStyleGroup = document.getElementById('frak_sharing_button_custom_style_group');

        styleSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customStyleGroup.style.display = 'block';
            } else {
                customStyleGroup.style.display = 'none';
            }
        });

        const productId = '{$product_id}';
        const webhookSecret = '{$webhook_secret}';

        if (!document.getElementById('open-webhook-popup')) {
            return;
        }

        document.getElementById('open-webhook-popup').addEventListener('click', function(e) {
            e.preventDefault();

            const createUrl = new URL("https://business.frak.id");
            createUrl.pathname = "/embedded/purchase-tracker";
            createUrl.searchParams.append("pid", productId);
            createUrl.searchParams.append("s", webhookSecret);
            createUrl.searchParams.append("p", "custom");

            const openedWindow = window.open(
                createUrl.href,
                "frak-business",
                "menubar=no,status=no,scrollbars=no,fullscreen=no,width=500,height=800"
            );

            if (openedWindow) {
                openedWindow.focus();

                const timer = setInterval(() => {
                    if (openedWindow.closed) {
                        clearInterval(timer);
                        setTimeout(() => window.location.reload(), 1000);
                    }
                }, 500);
            }
        });
    });
</script>
