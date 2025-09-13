<div class="wrap">
	<h1>Encuesta de satisfacción</h1>
	<p>Reporte de las personas que completaron la encuesta de satisfacción.</p>
  <form method="post" action="options.php">
		<input type="month" name="mos-month-quiz">
		<input type="hidden" name="export-mos-month-quiz">
		<input type="hidden" name="export-mos-year-quiz">
    <button type="submit" name="export-report-quiz" class="button button-primary">Descargar reporte CSV</button>
  </form>
</div>
<script>
	window.addEventListener('load', function () {
	const inputMesAno = document.querySelector('input[name="mos-month-quiz"]');

		inputMesAno.addEventListener('change', function(event) {
			const valor = event.target.value;

			const resultadoP = document.getElementById('resultado');

			if (valor) {
				const [ano, mes] = valor.split('-');
				const year = document.querySelector('input[name="export-mos-year-quiz"]');
				const month = document.querySelector('input[name="export-mos-month-quiz"]');
				year.value = ano;
				month.value = mes;
			}
		});
	});
</script>
