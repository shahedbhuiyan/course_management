<style type="text/css">
	div#test{border: #000 1px solid; padding: 10px 40px 40px 40px; }
</style>
<script type="text/javascript">
	var pos = 0, test, test_status, question, choice,choices,chA,chB,chC,correct = 0;
	var questions = [
		["what is 10 + 4?","12","14","16","B"],
		["what is 20 - 9?","7","13","11","C"],
		["what is 7 x 3?","21","24","25","A"],
		["what is 8/2?","10","2","4","C"],
	];

	function _(x){
		return document.getElementById(x);
	}

	function renderQuestion(){
		test = _("test");
		if(pos >= questions.length){
			test.innerHTML = "<h2> You got "+correct+" of "+questions.length+" questions correct.</h2>";
			_("test_status").innerHTML = "Test Completed";
			pos = 0;
			correct = 0;
			return false;
		}
		_("test_status").innerHTML = "Question "+(pos+1)+" of "+questions.length;
		question = questions[pos][0];
		chA = questions[pos][1];
		chB = questions[pos][2];
		chC = questions[pos][3];

		test.innerHTML = "<h2>"+question+"</h2>";

		test.innerHTML += "<input type = 'radio' name = 'choices' value = 'A'> "+chA+"<br>";
		test.innerHTML += "<input type = 'radio' name = 'choices' value = 'B'> "+chB+"<br>";
		test.innerHTML += "<input type = 'radio' name = 'choices' value = 'C'> "+chC+"<br>";
		test.innerHTML += "<button onclick = 'checkAnswer()'>Submit Answer</button>";
	}

	function checkAnswer(){
		choices = document.getElementsByName("choices");
		for (var i = 0; i<choices.length; i++) {
			if(choices[i].checked){
				choice = choices[i].value;
			}
		}
		if(choice == questions[pos][4]){
			correct++;
		}
		pos++;
		renderQuestion();
	}

	window.addEventListener('load',renderQuestion,false);
</script>

<h2 id = "test_status">test status</h2>
<div id = "test">Hello</div>