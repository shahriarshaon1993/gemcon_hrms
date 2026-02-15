(function(){
	var URL = {
		currentUrl: function(){
			return '<?php echo Request::url(); ?>';
		},
		baseUrl: function(action){
			return '<?php echo $baseURL; ?>/' + action;
		},
		get: function(action){
			return '<?php echo url("/"); ?>' + action;
		},
		templ: function(action){
			return '<?php echo url("templates"); ?>/' + action;
		}
	};
	window.URL = URL;
}());