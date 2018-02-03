      function toggleCheckbox(checkbox){
				if(checkboxIsChecked(checkbox)){
					uncheckCheckbox(checkbox);
				}
				else{
					checkCheckbox(checkbox);
				}
			}
			
			function checkCheckbox(checkbox){
				$(checkbox)[0].className = $(checkbox)[0].className + " checked";
			}
			
			function uncheckCheckbox(checkbox){
				$(checkbox)[0].className = $(checkbox)[0].className.replace("checked", "").trim();
			}
			
			function checkboxIsChecked(checkbox){
				return ($(checkbox)[0].className.indexOf("checked") > -1);
			}
