var textBox = document.getElementById("textBox");
var second = document.getElementById("second");
var t = 4;
function showTime(href){

	t-=1;
	second.innerHTML = t;
	if(t==0){
	
		textBox.innerHTML = "正在跳转...";
		self.location = href;
	}
	setTimeout("showTime(href)",1000);
}
