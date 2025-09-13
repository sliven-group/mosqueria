export default function on(ele, type, selector, handler) {
	ele.addEventListener(type, (event) => {
		const el = event.target.closest(selector);

		if (el) handler.call(el, event);
	});
}
