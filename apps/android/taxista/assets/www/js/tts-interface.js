function startupWin(result) {
	// When result is equal to STARTED we are ready to play
	if (result == TTS.STARTED) {
		window.plugins.tts.getLanguage(win, fail);
		//window.plugins.tts.speak("The text to speech service is ready");
		window.plugins.tts.isLanguageAvailable("en_US", function() {
			addLang("en_US", "English (American)");
		}, fail);
		window.plugins.tts.isLanguageAvailable("en_GB", function() {
			addLang("en_GB", "English (UK)");
		}, fail);
		window.plugins.tts.isLanguageAvailable("fr", function() {
			addLang("fr", "French");
		}, fail);
		window.plugins.tts.isLanguageAvailable("de", function() {
			addLang("de", "German");
		}, fail);
		window.plugins.tts.isLanguageAvailable("it", function() {
			addLang("it", "Italian");
		}, fail);
		window.plugins.tts.isLanguageAvailable("es", function() {
			addLang("es", "Spanish");
		}, fail);        
	}
}

function addLang(loc, lang) {
	var langs = document.getElementById('langs');
	var langOption = document.createElement("OPTION"); 
	langOption.innerText = lang; 
	langOption.value = loc;
	langs.options.add(langOption); 
}

function changeLang() {
	var yourSelect = document.getElementById('langs');
	window.plugins.tts.setLanguage(yourSelect.options[yourSelect.selectedIndex].value, win, fail);
}

function win(result) {
	console.log(result);
}

function fail(result) {
	console.log("Error = " + result);
}

function speak(word) {
	window.plugins.tts.speak(word);
}