      			function toggleCheckbox(checkbox){
				if(checkboxIsChecked(checkbox)){
					uncheckCheckbox(checkbox);
				}
				else{
					checkCheckbox(checkbox);
				}
			}
			
			function checkCheckbox(checkbox){
				$(checkbox).addClass("checked");
			}
			
			function uncheckCheckbox(checkbox){
				$(checkbox).removeClass("checked");
			}
			
			function checkboxIsChecked(checkbox){
				return $(checkbox).hasClass("checked");
			}
