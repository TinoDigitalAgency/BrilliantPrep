jQuery(function($) {
	"use strict";

	let params = MWCPaymentsPaymentMethods;

	if (! params.allowManage) {
		$('tr[data-gateway_id="'+params.gatewayId+'"] td.name a').replaceWith(function() {
			return $("<span>" + $(this).html() + "</span>");
		});
	}

	if (! params.allowButton) {
		$('tr[data-gateway_id="'+params.gatewayId+'"] .onboarding-action a').css('pointer-events','none').css('opacity', '0.2');
	}

	if (! params.allowEnable) {
		$('tr[data-gateway_id="'+params.gatewayId+'"] .wc-payment-gateway-method-toggle-enabled').css('pointer-events','none').css('opacity', '0.2');
	}

	let $setUpButton = $('tr[data-gateway_id="'+params.gatewayId+'"] .onboarding-action a.start, tr[data-gateway_id="'+params.gatewayId+'"] .onboarding-action a.disconnected').on('click', function(event){

		event.preventDefault();

		let data = {
			action: params.setupIntentAction,
			setupIntentNonce: params.setupIntentNonce,
		}

		const sourceMatch = document.location.search.match(/\Wsource=([\w-]+)\W?/);
		if (sourceMatch && sourceMatch[1]) {
			data.source = sourceMatch[1];
		}

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data,
		});

		new $.WCBackboneModal.View({
			target: 'mwc-payments-godaddy-onboarding-start'
		});
	});

	// open the Set up modal if the gdpsetup parameter is included in the URL and the button would have normally opened the Set up modal
	if (document.location.search.match(/\bgdpsetup=true\b/)) {
		$setUpButton.click();
	}

	$('tr[data-gateway_id="'+params.gatewayId+'"] .onboarding-action a.remove').on('click', function(event){

		event.preventDefault();

		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: params.removePaymentMethodAction,
				nonce: params.removePaymentMethodNonce,
			}
		});

		$('tr[data-gateway_id="'+params.gatewayId+'"]').remove();
	});

	$('#woocommerce_'+params.gatewayId+'_transaction_type').on('change', function(){

		if ($(this).val() === 'authorization') {
			$('#woocommerce_'+params.gatewayId+'_charge_virtual_orders, #woocommerce_'+params.gatewayId+'_capture_paid_orders').closest('tr').show();
		} else {
			$('#woocommerce_'+params.gatewayId+'_charge_virtual_orders, #woocommerce_'+params.gatewayId+'_capture_paid_orders').closest('tr').hide();
		}

	}).change();

});
