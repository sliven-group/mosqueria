export default function ajax({
	url,
	method = 'GET',
	params = {},
	async = true,
	done = function () {},
	error = function () {},
	always = function () {},
	responseType = 'json',
}) {
	const request = new XMLHttpRequest();

	request.responseType = responseType;
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			always();
			if (request.status === 200) {
				done(request.response);
			} else {
				error(request.status);
			}
		}
	};
	request.open(method, url, async);
	request.send(params);
}
