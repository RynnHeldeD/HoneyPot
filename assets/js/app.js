﻿var accounts = $('.app-content-data .app-content-account .account');
var meters = $('.app-content-data .app-content-objective .objective .objective-progress .objective-meter');
var colors = [
	'#7373D9', // Violet
	'#64DE89', // Green
	'#FF7373', // Red
	'#FFD073', // Yellow
	'#62B1D0', // Blue
];

// Sets the right colors and width for accounts and objective meters
var setAccountsColors = function() {
	accounts.each(function(index) {
		$(this).addClass('account' + (index + 1));
	});
	meters.each(function() {
		var meterAccountClass = '';
		var meterAccountId = $(this).attr('data-account-id');
		var objectiveValue = $(this).parent().next().find('.objective-amount').text();
		var meterValue = $(this).text();
		var meterWidth = (parseInt(meterValue) * 100) / parseInt(objectiveValue.substring(0, objectiveValue.length - 1));
		//console.log(meterWidth);
		accounts.each(function() {
			if($(this).attr('data-account-id') === meterAccountId) {
				var accountClasses = $(this).attr('class').split(' ');
				meterAccountClass = accountClasses[accountClasses.length - 1];
			}
		});
		$(this).addClass(meterAccountClass);
		$(this).css({
			width: meterWidth + '%'
		});
	});
}

$(document).ready(function() {
	setAccountsColors();
	
	// Handle the click on an account
	accounts.click(function() {
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
		var objectives = $('#nonCompletedObjectives .app-content-objective');
		objectives.each(function() {
			// Retrieves the objective's informations
			var objectiveLabel = $(this).find('.objective-label').text();
			var objectiveAmount = $(this).find('.objective-amount').text();
			var objectiveId = $(this).find('.objective-label').attr('data-id');
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
                // If an objective has no goal : its ceil is infinite, we can put all the money we want in it
                if(objectiveAmountInt == 0) {
                    objectiveSliderMaxValue = accountBalanceInt;
                }
                else {
				    objectiveSliderMaxValue = objectiveAmountInt;
                }
			}
            
            if(accountBalanceInt == 0) {
                objectiveSliderMaxValue = 1;
            }

			// Creates the new elements
			var modalObjective = $('<div/>', {
				class: 'large-12 columns account-modal-objective'
			});

			var modalObjectiveLabel = $('<h3/>', {
				text : objectiveLabel,
				class: 'large-4 columns account-modal-objective-label',
			}).attr('data-id', objectiveId).appendTo(modalObjective);
			
			var modalObjectiveContainer = $('<div/>', {
				'class': 'large-6 columns account-modal-objective-container',
			});
			var modalObjectiveInput = $('<input/>', {
				'type': 'number',
				'class': 'account-modal-objective-input',
				'value': objectiveAllowedAmount
			}).css({
				'display': 'inline-block',
				'width': '90%'
			});
			var modalObjectiveInputDevise = $('<span>€<span/>');
			
			var modalObjectiveSlider = $('<div/>', {
				class: 'large-6 columns account-modal-objective-slider noUiSlider'
			}).noUiSlider({
				range  : [0, parseInt(objectiveAllowedAmount) + parseInt(objectiveSliderMaxValue)],
				start  : objectiveAllowedAmount,
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
                        // TO REACTIVATE WHEN REDUCING SLIDER WORK
                        /*
						sliders.each(function() {
							var slider = $(this);
							// Only take care about the other sliders
							if(parseInt(slider.val()) !== sliderValue) {
								// console.log('different');
								// -1 because we don't care about the selected slider
								slider.val(Math.ceil(parseInt(slider.val()) - ((slidersSum - accountBalanceInt) / (slidersNumber - 1))), true);
							}
							else {
								// console.log('equals');
							}
						});*/
					}
				},
				set    : function() {
					// Updates the slider's value
					$(this).parent().find('.account-modal-objective-slider-value').text(parseInt($(this).val()) + '€');
                    if($(this).val() < parseInt(objectiveAllowedAmount)) {
                        // TO DO
                        /*var credit = parseInt(objectiveAllowedAmount) - $(this).val();
                        accountBalanceInt = accountBalanceInt + credit;
                        accountModalBalance.text(accountBalanceInt);*/
                    }
				}
			});
            
            if(accountBalanceInt > 0) {
            	modalObjectiveInput.appendTo(modalObjectiveContainer);
                modalObjectiveInputDevise.appendTo(modalObjectiveContainer);
                modalObjectiveContainer.appendTo(modalObjective);
            }

			// var modalObjectiveSliderValue = $('<h5/>', {
			// 	text : parseInt(objectiveAllowedAmount) + '€',
			// 	class: 'large-2 columns account-modal-objective-slider-value'
			// }).appendTo(modalObjective);

			
			//======= NICO BELLIC FORGOTTEN CODE ======//
			/*
			if( objectiveSliderMaxValue === 0) {
				var modalObjectiveErrorContainer = $('<div/>', {
					class: 'large-12 columns account-modal-error'
				});
				var modalObjectiveError = $('<h2/>', {
					class: 'error',
					text : 'Le solde de ce compte est insuffisant'
				}).appendTo(modalObjectiveErrorContainer);
				console.log(modalObjectiveErrorContainer);
				modalObjectiveErrorContainer.appendTo(modalObjective);
			}
			else {
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
									//console.log(Math.ceil(parseInt(slider.val()) - ((slidersSum - accountBalanceInt) / (slidersNumber - 1))));
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
			}
			*/
			//>>>>>>> Don't remember
			
			
			// Adds the new elements to the modal
			accountModalSplit.append(modalObjective);
		});

		// Fills the modal
		accountModalLabel.text(accountLabel);
		accountModalLabel.attr('account-id', accountId);
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
	meters.click(function() {
		// console.log($(this));
	});
	
	// Handle the click on the "Cancel and close" button
	$(".close-window").click(function() {
		var modalWindows = $(this).parent().parent();
		modalWindows.foundation('reveal', 'close');
	});
    
    // Handle the click on the "Save" button in Account form
	$("#save-account-confirm").click(function() {
        var modalWindows = $(this).parent().parent();
        var objectives = $('.account-modal-objective');
        var allocations = new Array();
        var accountId = modalWindows.find('.account-modal-title > h4').attr('account-id');
        
        objectives.each(function() {
            // Retrieves the objective's informations
            var objectiveId = $(this).find('.account-modal-objective-label').attr('data-id');
            var objectiveAmount = $(this).find('.account-modal-objective-input').val();
            allocations.push(new Array(objectiveId, objectiveAmount));
        });
        $.post( "index.php", { a: "updateObjective", p: 'Objective', allocations:allocations, accountId: accountId })
        .done(function( data ) {
            modalWindows.foundation('reveal', 'close');
            location.reload(true);
        });
    });
	
	// Handle the click on the "Add new account" button
	$('#add-account').click(function() {
		var newAccountModal = $('#new-account-modal');
		var libelleInput = $('input[name="new-account-label"]');
		var soldeInput = $('input[name="new-account-amount"]');
		/*newAccountModal.foundation('reveal', {
			closed: function() {
				//$(this).find('.account-modal-objective').remove();
			}
		});*/

		// Opens the modal
		newAccountModal.foundation('reveal', 'open');
		
		libelleInput.focus(function() {
			this.value = "";
		});
		
		libelleInput.focusout(function() {
			if(this.value.trim() == "") {
				this.value = "Nouveau compte";
			}
		});
		
		// Handle the click on the "Save" button for "New Account" form
		$('#new-account-confirm').click(function() {
			var libelle = libelleInput.val();
			var solde = soldeInput.val();
			
			$.post( "index.php", { a: "createAccount", p: 'Account', libelle:libelle, solde:solde })
			.done(function( data ) {
				newAccountModal.foundation('reveal', 'close');
                location.reload(true);
				
			});
		});
	});
	
	
	// Handle the click on the "Add new objective" button
	$('#add-objective').click(function() {
		var newObjectiveModal = $('#new-objective-modal');
		/*newAccountModal.foundation('reveal', {
			closed: function() {
				//$(this).find('.account-modal-objective').remove();
			}
		});*/

		// Opens the modal
		newObjectiveModal.foundation('reveal', 'open');
		
		$('input[name="new-objective-label"]').focus(function() {
			this.value = "";
		});
		
		$('input[name="new-objective-label"]').focusout(function() {
			if(this.value.trim() == "") {
				this.value = "Nouvel objectif";
			}
		});
	});
	
	// Handle the click on the "Add new objective" confirm button
	$('#new-objective-confirm').click(function() {
		var newObjectiveModal = $('#new-objective-modal');
		var objectiveLabel = $('input[name="new-objective-label"]').val();
		var objectiveGoal = $('input[name="new-objective-goal"]').val();
        
        $.post( "index.php", { label: objectiveLabel, goal: objectiveGoal, a: 'createNewObjective', p: 'Objective' })
        .done(function( data ) {
            newObjectiveModal.foundation('reveal', 'close');
            location.reload(true);
        });
	});
	
	// Handle the click on the completed objectives "Show/hide" button
	$("#completedObjectivesBtn").click(function() {
		var completedObjectivesDiv = $('#completedObjectives');
		if(completedObjectivesDiv.css('display') == 'none') {
			completedObjectivesDiv.show('slow');
			$('html, body').animate({scrollTop:$(document).height()}, 'slow');
		}
		else {
			completedObjectivesDiv.hide('slow');
		}
	});
    
    // Handle the click on a objective validation button
	$(".objective-validation-button").click(function() {
		var objectiveId = $(this).attr('data-objective-id');
        
		$.post( "index.php", { objectiveId: objectiveId, a: 'validateObjective', p: 'Objective' })
        .done(function( data ) {
            location.reload(true);
        });
	});
    
    // Handle the click on a new deposit button
	$("#account-add-deposit").click(function() {
        var modalWindows = $(this).parent().parent();
		var accountId = modalWindows.find('.account-modal-title > h4').attr('account-id');
        var depositAmount = $('input[name="new-deposit"]').val();
        
		$.post( "index.php", { accountId: accountId, depositAmount: depositAmount, a: 'newDeposit', p: 'Account' })
        .done(function( data ) {
            location.reload(true);
        });
	});
});