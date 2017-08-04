var request = require('request');

var urlJeedom = '';
var freq = 4;

process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";

process.argv.forEach(function(val, index) {
	switch ( index ) {
		case 2 : urlJeedom = val; break;
		case 3 : log = val; break;
		case 4 : freq = val; break;
	}
});

urlJeedom = urlJeedom;
freq = freq;

function connectJeedom() {
	jeeApi = urlJeedom;
	if (log == 'debug') {console.log((new Date()) + " : " + jeeApi);}
	request(jeeApi, function (error, response, body) {
		if (!error && response.statusCode == 200) {
			if (log == 'debug') {console.log((new Date()) + " - Actualisation OK fréquence : " + freq);}
		}else{
			if (log == 'debug') {console.log((new Date()) + " - Actualisation NOK");}
		}
	});
}


function maj_telecommande() {
	connectJeedom();
}

setInterval(maj_telecommande, freq*1000);