import { createHooks } from '@wordpress/hooks';
import domReady from '@wordpress/dom-ready';

window.wpcomsp_t5pi = window.wpcomsp_t5pi || {};
window.wpcomsp_t5pi.hooks = createHooks();

domReady( () => {
	window.wpcomsp_t5pi.hooks.doAction( 'editor.ready' );
} );
