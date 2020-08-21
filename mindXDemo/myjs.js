
var like = 0;
var j =0;
var k =0;
var input = document.getElementById("input");
var array = [];
const resultprint = document.getElementById("resultprint");
var result = [];
input.addEventListener('input', function() {
	document.getElementById("loading").style.display = " block";
	setTimeout(function(){
		document.getElementById("loading").style.display = "none";
	}, 2000)
	setTimeout(function(){
		inputValue = document.getElementById("input").value;
		if(inputValue == ""){
			
			array = [];
			result = [];
			resultprint.innerHTML = "";
		}
		console.log("the character input is : " + inputValue);
		$.getJSON( "data.json", function( data ) {

			console.log(data);
			for(var i =0; i < data.length-1; i ++){
				if(data[i].name.charAt(0).toUpperCase() == inputValue.charAt(0).toUpperCase()){
					array[j] = data[i];
					result[k] = "name :" + array[j].name + ", " + "abbr :"+ array[j].abbr;
					j = j+1;
					k = k +1;
				}
			}
			console.log(array);
			printresult(result);
		});
	}, 2000)
});

function printresult( $array){
	for(var i =0; i < result.length; i ++){
		result.sort();
		resultprint.innerHTML = result.join(" <br> ");
	}
	
	if (array == []) {
		resultprint.innerHTML = "";
	}
}



var turn1 =0;
var turn2 =0;
var turn3 =0;
var turn4 =0;
var turn5 =0;

const contact = document.getElementById("contact");
const displaycontact = document.getElementById("displaycontact");
const displayFAQs = document.getElementById("displayFAQs");
const FAQs = document.getElementById("FAQs");
const delivery = document.getElementById("delivery");
const displaydelivery = document.getElementById("displaydelivery");
const guidepage = document.getElementById("guidepage");
const displayguidepage = document.getElementById("displayguidepage");
const payment = document.getElementById("paymentoption");
const displaypayment = document.getElementById("displaypayment");


contact.onclick = function(){
	if(turn1 %2 == 0){
		displaycontact.innerHTML = "<b>Sale hotline</b>" + " +6592177659" 
		+ "<br>" + "<b>Adress</b>" + "Upper Serangoon road, Upper " +"<br>" +
		" Serangoon Shopping center #01-21, Singapore 534626 " + "<br>"
		+"Monday to Sunday" + "11a.m to 8p.m" + "<br><b>Contact web page</b>" + "<br><b>Location Map </b>"
		+"<b>about us</b>";
		document.getElementById("displaycontact").style.display = "block";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
		turn1 = 0;
		turn2 = 0;
		turn3 = 0;
		turn4 = 0;
		turn5 = 0;
	}
	else{
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
	}
	turn1 = turn1+1;
};
FAQs.onclick = function(){
	if(turn2 %2 == 0){
		displayFAQs.innerHTML = "aaaaaaaaaaaaaa";
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "block";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
		turn1 = 0;
		turn2 = 0;
		turn3 = 0;
		turn4 = 0;
		turn5 = 0;
	}
	else{
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
	}
	turn2 = turn2+1;
};
delivery.onclick = function(){
	if(turn3 %2 == 0){
		displaydelivery.innerHTML = "aaaaaaaaaaaaaa";
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "block";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
		turn1 = 0;
		turn2 = 0;
		turn3 = 0;
		turn4 = 0;
		turn5 = 0;
	}
	else{
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
	}
	turn3 = turn3+1;
};
guidepage.onclick = function(){
	if(turn4 %2 == 0){
		displayguidepage.innerHTML = "aaaaaaaaaaaaaa";
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "block";
		document.getElementById("displaypayment").style.display = "none";
		turn1 = 0;
		turn2 = 0;
		turn3 = 0;
		turn4 = 0;
		turn5 = 0;
	}
	else{
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
	}
	turn4 = turn4+1;
};
payment.onclick = function(){
	if(turn5 %2 == 0){
		displaypayment.innerHTML = "aaaaaaaaaaaaaa";
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "block";
		turn1 = 0;
		turn2 = 0;
		turn3 = 0;
		turn4 = 0;
		turn5 = 0;
	}
	else{
		document.getElementById("displaycontact").style.display = "none";
		document.getElementById("displayFAQs").style.display = "none";
		document.getElementById("displaydelivery").style.display = "none";
		document.getElementById("displayguidepage").style.display = "none";
		document.getElementById("displaypayment").style.display = "none";
	}
	turn5 = turn5+1;
}