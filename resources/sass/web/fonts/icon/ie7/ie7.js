/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'Shilin\'">' + entity + '</span>' + html;
	}
	var icons = {
		'shilin-infor-bell': '&#xe930;',
		'shilin-infor-chat': '&#xe931;',
		'shilin-infor-order': '&#xe932;',
		'shilin-infor-promotion': '&#xe933;',
		'shilin-information': '&#xe934;',
		'shilin-cancel-product': '&#xe92f;',
		'shilin-check-square-full': '&#xe92c;',
		'shilin-cancel-full': '&#xe929;',
		'shilin-check-circle-full': '&#xe92a;',
		'shilin-check-circle': '&#xe92b;',
		'shilin-check-square': '&#xe92d;',
		'shilin-login-facebook': '&#xe925;',
		'shilin-login-google': '&#xe926;',
		'shilin-login-password': '&#xe927;',
		'shilin-login-phone': '&#xe928;',
		'shilin-setting-notification': '&#xe92e;',
		'shilin-add-image': '&#xe900;',
		'shilin-add': '&#xe901;',
		'shilin-bell': '&#xe902;',
		'shilin-block': '&#xe903;',
		'shilin-bottom': '&#xe904;',
		'shilin-calendar': '&#xe905;',
		'shilin-cancle': '&#xe906;',
		'shilin-card': '&#xe907;',
		'shilin-cart': '&#xe908;',
		'shilin-check': '&#xe909;',
		'shilin-chicken': '&#xe90a;',
		'shilin-circle': '&#xe90b;',
		'shilin-down': '&#xe90c;',
		'shilin-hamburger': '&#xe90d;',
		'shilin-heart': '&#xe90e;',
		'shilin-juice': '&#xe90f;',
		'shilin-local': '&#xe910;',
		'shilin-location': '&#xe911;',
		'shilin-mail': '&#xe912;',
		'shilin-menu': '&#xe913;',
		'shilin-messeage': '&#xe914;',
		'shilin-minus': '&#xe915;',
		'shilin-money': '&#xe916;',
		'shilin-note': '&#xe917;',
		'shilin-phone': '&#xe918;',
		'shilin-potato': '&#xe919;',
		'shilin-promotion': '&#xe91a;',
		'shilin-proto': '&#xe91b;',
		'shilin-protom': '&#xe91c;',
		'shilin-search': '&#xe91d;',
		'shilin-send': '&#xe91e;',
		'shilin-star': '&#xe91f;',
		'shilin-telephone': '&#xe920;',
		'shilin-time': '&#xe921;',
		'shilin-top': '&#xe922;',
		'shilin-user-full': '&#xe923;',
		'shilin-user': '&#xe924;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/shilin-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
