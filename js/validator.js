function checkForm(form) {
	var elements = $(form).find("[data-type]");
	var bad = "";
	for (var i = 0; i < elements.length; i++)
		bad += checkElement(elements.get(i));
	if (bad == "") {
		var t_confirm = $(form).find(["data-tconfirm"]).attr("data-tconfirm");
		if (t_confirm) return confirm(t_confirm);
		return true;
	}
	alert(bad);
	return false;
}

function checkElement(element) {
	var type = $(element).attr("data-type");
	var min_len = $(element).attr("data-minlen");
	var max_len = $(element).attr("data-maxlen");
	var t_min_len = $(element).attr("data-tminlen");
	var t_max_len = $(element).attr("data-tmaxlen");
	var t_empty = $(element).attr("data-tempty");
	var t_type = $(element).attr("data-ttype");
	var f_equal = $(element).attr("data-fequal");
	var t_equal = $(element).attr("data-tequal");
	var bad = "";
	if (type == "") {
		bad += checkTextInput($(element).val(), min_len, max_len, t_empty, t_min_len, t_max_len);
		bad += checkEqual($(element), f_equal, t_equal);
	}
	else if (type == "name") {
		bad += checkName($(element).val(), max_len, t_empty, t_type, t_max_len);
	}
	else if (type == "login") {
		bad += checkLogin($(element).val(), max_len, t_empty, t_type, t_max_len);
	}
	else if (type == "email") {
		bad += checkEmail($(element).val(), max_len, t_empty, t_type, t_max_len);
	}
	
	return bad;
}

function checkTextInput(value, min_len, max_len, t_empty, t_min_len, t_max_len) {
	if (value.length == 0) return t_empty + "\n";
	else {
		if (value.length < min_len) return t_min_len + "\n";
		if (max_len && value.length > max_len) return t_max_len + "\n";
	}
	return "";
}

function checkName(name, max_len, t_empty, t_type, t_max_len) {
	if (name.length == 0) return t_empty + "\n";
	if (isContainQuotes(name)) return t_type + "\n";
	if (max_len && name.length > max_len) return t_max_len + "\n";
	return "";
}

function checkLogin(login, max_len, t_empty, t_type, t_max_len) {
	if (login.length == 0) return t_empty + "\n";
	if (isContainQuotes(login)) return t_type + "\n";
	if (max_len && login.length > max_len) return t_max_len + "\n";
	return "";
}

function checkEmail(email, max_len, t_empty, t_type, t_max_len) {
	if (email.length == 0) return t_empty + "\n";
	if (email.match(/^[a-z0-9_][a-z0-9\._-]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+$/i) == null) return t_type + "\n";
	if (max_len && email.length > max_len) return t_max_len + "\n";
	return "";
}

function isContainQuotes(string) {
	var array = new Array("\"", "'", "`", "&quot;", "&apos;");
	for (var i = 0; i < array.length; i++) {
		if (string.indexOf(array[i]) !== -1) return true;
	}
	return false;
}

function checkEqual(element, f_equal, t_equal) {
	if (f_equal == "") return "";
	var form = $(element).parents("form");
	var field = $(form).find("[name='" + f_equal + "']");
	if (element.val() != field.val()) return t_equal + "\n";
	return "";
}