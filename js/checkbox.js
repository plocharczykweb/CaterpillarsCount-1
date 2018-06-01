      			function toggleCheckbox(checkbox){
				if(checkboxIsChecked(checkbox)){
					uncheckCheckbox(checkbox);
				}
				else{
					checkCheckbox(checkbox);
				}
			}
			
			function checkCheckbox(checkbox){
				if(!checkboxIsChecked(checkbox)){
					$(checkbox).addClass("checked");
				}
			}
			
			function uncheckCheckbox(checkbox){
				if(checkboxIsChecked(checkbox)){
					$(checkbox).removeClass("checked");
				}
			}
			
			function checkboxIsChecked(checkbox){
				return $(checkbox).hasClass("checked");
			}
