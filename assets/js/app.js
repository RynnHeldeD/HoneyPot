$(document).ready(function() {
	// Handle the click on an account
	$('.app-content-data .app-content-account .account').click(function() {
		// Retrieves the account modal
		var accountModal = $('#account-modal');
		var accountModalLabel = accountModal.find('.account-modal-title h4');
		var accountModalBalance = accountModal.find('.account-modal-balance span');
		var accountModalSplit = accountModal.find('.account-modal-split');

		// Retrieves the clicked account's informations
		var accountLabel = $(this).find('h2').text();
		var accountBalance = $(this).find('span').text();
		var accountId = $(this).attr('data-account-id');

		// Retrieves and adds the objectives to the modal
		/* Modal objectives pattern
			<div class="large-12 columns account-modal-objective">
				<h3 class="large-4 columns account-modal-objective-label">ObjectiveName</h3>
				<div class="large-6 columns account-modal-objective-slider noUiSlider"></div>
				<h5 class="large-2 columns account-modal-objective-slider-value"></h5>
			</div>
		*/
		var objectives = $('.app-content-objective');
		objectives.each(function() {
			// Retrieves the objective's informations
			var objectiveLabel = $(this).find('.objective-label').text();
			var objectiveAmount = $(this).find('.objective-amount').text();
			var objectiveAllowedAmount = '0';
			var objectiveSliderMaxValue = 0;

			// Finds if the objective is already composed of part of this account
			$(this).find('.objective-meter').each(function() {
				if($(this).attr('data-account-id') === accountId) {
					objectiveAllowedAmount = $(this).text();
				}
			});

			// Determines if the max value of the slider will be the one of the
			// account or of the objective
			var accountBalanceInt = parseInt(accountBalance.substring(0, accountBalance.length - 1), 10);
			var objectiveAmountInt = parseInt(objectiveAmount.substring(0, objectiveAmount.length - 1), 10);

			if(objectiveAmountInt >= accountBalanceInt) {
				objectiveSliderMaxValue = accountBalanceInt;
			}
			else {
				objectiveSliderMaxValue = objectiveAmountInt;
			}

			// Creates the new elements
			var modalObjective = $('<div/>', {
				class: 'large-12 columns account-modal-objective'
			});

			var modalObjectiveLabel = $('<h3/>', {
				text : objectiveLabel,
				class: 'large-4 columns account-modal-objective-label'
			}).appendTo(modalObjective);

			var modalObjectiveSlider = $('<div/>', {
				class: 'large-6 columns account-modal-objective-slider noUiSlider'
			}).noUiSlider({
				range  : [0, objectiveSliderMaxValue],
				start  : 0,
				handles: 1,
				step   : 1,
				slide  : function() {
					var sliderValue   = parseInt($(this).val());
					var sliders       = $('.account-modal-objective-slider');
					var slidersNumber = sliders.length;
					var slidersSum    = 0;

					// Count the sliders value
					sliders.each(function() {
						slidersSum += parseInt($(this).val());
					});

					// Updates the slider's value
					$(this).parent().find('.account-modal-objective-slider-value').text(sliderValue + '€');

					// Balance the sliders values
					if(slidersSum > accountBalanceInt) {
						sliders.each(function() {
							var slider = $(this);
							// Only take care about the other sliders
							if(parseInt(slider.val()) !== sliderValue) {
								// console.log('different');
								// -1 because we don't care about the selected slider
								slider.val(Math.ceil(parseInt(slider.val()) - ((slidersSum - accountBalanceInt) / (slidersNumber - 1))), true);
								console.log(Math.ceil(parseInt(slider.val()) - ((slidersSum - accountBalanceInt) / (slidersNumber - 1))));
							}
							else {
								// console.log('equals');
							}
						});
					}
				},
				set    : function() {
					// Updates the slider's value
					$(this).parent().find('.account-modal-objective-slider-value').text(parseInt($(this).val()) + '€');
				}
			}).appendTo(modalObjective);

			var modalObjectiveSliderValue = $('<h5/>', {
				text : '0€',
				class: 'large-2 columns account-modal-objective-slider-value'
			}).appendTo(modalObjective);

			// Adds the new elements to the modal
			accountModalSplit.append(modalObjective);
		});

		// Fills the modal
		accountModalLabel.text(accountLabel);
		accountModalBalance.text(accountBalance);

		// Sets a callback on closing
		accountModal.foundation('reveal', {
			closed: function() {
				$(this).find('.account-modal-objective').remove();
			}
		});

		// Opens the modal
		accountModal.foundation('reveal', 'open');
	});

	// Handle the click on an objective name
	$('.app-content-data .app-content-objective .objective .objective-header .objective-label').click(function() {
		// console.log($(this));
	});

	// Handle the click on an objective amount
	$('.app-content-data .app-content-objective .objective .objective-postfix .objective-amount').click(function() {
		// console.log($(this));
	});

	// Handle the click on an objective bar part
	$('.app-content-data .app-content-objective .objective .objective-progress .objective-meter').click(function() {
		// console.log($(this));
	});
});