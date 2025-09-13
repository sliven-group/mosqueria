/* global jsVars, tarifasDistritos */
import ajax from '../helpers/ajax';
import { variableRateDistrictsRegular, variableRateDistrictsExpress } from '../helpers/varible-rate-districts';

window.addEventListener('load', function () {
    const departamentoSelect = document.getElementById('billing_departamento');
    const provinciaSelect = document.getElementById('billing_provincia');
    const distritoSelect = document.getElementById('billing_distrito');
    const calcularBtn = document.getElementById('mos-form-billing-btn');
    const messageCartShipping = document.getElementById('message-cart-shipping');
    // const billing_delivery_methods = document.getElementById('billing_delivery_methods');
    const expressDistricts = tarifasDistritos.express.map((d) => d.toUpperCase());
    const regularDistricts = tarifasDistritos.regular.map((d) => d.toUpperCase());
    //const provinceDistricts = tarifasDistritos.provincia.map((d) => d.toUpperCase());

    if (departamentoSelect) {
        departamentoSelect.addEventListener('change', function () {
            const idDepa = this.value;

            if(messageCartShipping){
                messageCartShipping.innerHTML = '';
            }               
            if (provinciaSelect) {
                provinciaSelect.innerHTML = '<option value=""></option>';

                const formData = new FormData();

                formData.append('action', 'get_provincias');
                formData.append('id_depa', idDepa);

                ajax({
                    url: jsVars.ajax_url,
                    method: 'POST',
                    params: formData,
                    async: true,
                    done: function (response) {
                        if (response.success) {
                            provinciaSelect.innerHTML = '<option value="">Seleccione provincia</option>';
                            response.data.forEach((item) => {
                                const option = document.createElement('option');

                                option.value = item.idProv;
                                option.textContent = item.nombre;
                                provinciaSelect.appendChild(option);
                            });
                        } else {
                            //alert(response.data.message);
                        }
                    },
                    error: function () {},
                    always: function () {},
                });
            }
        });
    }

    
    if (provinciaSelect) {
        provinciaSelect.addEventListener('change', function () {
            const idProv = this.value;
            
            if(messageCartShipping){
                messageCartShipping.innerHTML = '';
            }  
            if (distritoSelect) {
                distritoSelect.innerHTML = '<option value=""></option>';

                const formData = new FormData();

                formData.append('action', 'get_distritos');
                formData.append('id_prov', idProv);

                ajax({
                    url: jsVars.ajax_url,
                    method: 'POST',
                    params: formData,
                    async: true,
                    done: function (response) {
                        if (response.success) {
                            distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
                            response.data.forEach((item) => {
                                const option = document.createElement('option');

                                option.value = item.idDist;
                                option.textContent = item.nombre;
                                distritoSelect.appendChild(option);
                            });
                        } else {
                            //alert(response.data.message);
                        }
                    },
                    error: function () {},
                    always: function () {
                        //console.log('La solicitud AJAX ha finalizado.');
                    },
                });
            }
        });
    }

    function mostrarMensajeVariable(wrapper) {
        wrapper.innerHTML =
            '<p>La tarifa de delivery hacia su destino es variable. <a href="https://wa.me/51908900915?text=Necesito cotizar la tarifa de envío" target="_blank">Comuníquese con un asesor</a></p>';
    }

    function updateDeliveryMethods() {
        const wrapperElement = document.querySelector('#billing_delivery_methods_wrapper');
        let selectElement = document.getElementById('billing_delivery_methods');

        const distritoElement = document.getElementById('billing_distrito');
        const provinciaElement = document.getElementById('billing_provincia');
        const departamentoElement = document.getElementById('billing_departamento');

        if (!selectElement) {
            wrapperElement.innerHTML =
                '<select name="billing_delivery_methods" id="billing_delivery_methods" class="select"><option value="">Selecciona un método</option></select>';
            selectElement = document.getElementById('billing_delivery_methods');
        }
        const distrito = distritoElement ? distritoElement.options[distritoElement.selectedIndex].textContent.trimStart().trimEnd() : '';
        const provincia = provinciaElement ? provinciaElement.options[provinciaElement.selectedIndex].textContent.trimStart().trimEnd() : '';
        const departamento = departamentoElement ? departamentoElement.options[departamentoElement.selectedIndex].textContent.trimStart().trimEnd() : '';

        selectElement.innerHTML = '<option value="">Selecciona un método</option>';
        messageCartShipping.innerHTML = '';

        if (departamento === 'LIMA' && provincia === 'LIMA' && regularDistricts.includes(distrito) && expressDistricts.includes(distrito)) {
            selectElement.innerHTML = `
                <option value="">Selecciona un método</option>
                <option value="express">Envío Express - Máx. 4 horas</option>
                <option value="regular">Envío Regular - Máx. 2 días hábiles</option>
            `;
        } else if (
            departamento === 'LIMA' &&
            provincia === 'LIMA' &&
            expressDistricts.includes(distrito) &&
            !variableRateDistrictsExpress.includes(distrito)
        ) {
            selectElement.innerHTML += '<option value="express">Envío Express - Máx. 4 horas</option>';
        } else if (
            departamento === 'LIMA' &&
            provincia === 'LIMA' &&
            regularDistricts.includes(distrito) &&
            !variableRateDistrictsRegular.includes(distrito)
        ) {
            selectElement.innerHTML += '<option value="regular">Envío Regular - Máx. 2 días hábiles</option>';
        } else if (
            departamento !== 'LIMA' &&
            provincia !== 'LIMA' &&
            tarifasDistritos.provincia.some(
                (item) =>
                    item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito,
            )
        ) {
            selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
        } else if (
            departamento === 'LIMA' &&
            provincia !== 'LIMA' &&
            tarifasDistritos.provincia.some(
                (item) =>
                    item.departamento.toUpperCase() === departamento && item.provincia.toUpperCase() === provincia && item.distrito.toUpperCase() === distrito,
            )
        ) {
            selectElement.innerHTML += '<option value="provincia">Envío Provincia - Máx. 5 días hábiles</option>';
        } else if (
            departamento === 'LIMA' &&
            provincia === 'LIMA' &&
            (variableRateDistrictsRegular.includes(distrito) || variableRateDistrictsExpress.includes(distrito))
        ) {
            mostrarMensajeVariable(wrapperElement);
        } else if (
            departamento === 'LIMA' &&
            provincia === 'CALLAO' &&
            (variableRateDistrictsRegular.includes(distrito) || variableRateDistrictsExpress.includes(distrito))
        ) {
            mostrarMensajeVariable(wrapperElement);
        } else {
            wrapperElement.innerHTML = '<p>No se realizan envíos a la ubicación seleccionada.</p>';
        }
    }

    if (distritoSelect) {
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type === 'childList') {
                    updateDeliveryMethods();
                }
            });
        });

        observer.observe(distritoSelect, { childList: true });
        distritoSelect.addEventListener('change', updateDeliveryMethods);
    }
    if (calcularBtn) {
        calcularBtn.addEventListener('click', function () {
            const distrito = distritoSelect ? distritoSelect.options[distritoSelect.selectedIndex].textContent : '';
            let metodo = document.getElementById('billing_delivery_methods');
            const formData = new FormData();

            if (distritoSelect.value === '' && metodo.value == '') {
                return;
            }

            formData.append('action', 'calcular_envio_dinamico');
            formData.append('distrito', distrito);
            formData.append('metodo', metodo.value);

            calcularBtn.innerHTML = 'CALCULANDO...';
            messageCartShipping.innerHTML = '';

            ajax({
                url: jsVars.ajax_url,
                method: 'POST',
                params: formData,
                async: true,
                done: function (response) {
                    if (response.success) {
                        messageCartShipping.innerHTML = `<p>Metodo: ${response.data.metodo}</p><p>Precio: S/${response.data.precio}</p>`;
                    } else {
                        messageCartShipping.innerHTML = 'Error: ' + response.data.message;
                    }
                },
                error: function () {},
                always: function () {
                    calcularBtn.innerHTML = 'CALCULAR';
                },
            });
        });
    }

    const wrapperElement = document.querySelector('#billing_delivery_methods_wrapper');

    if (wrapperElement) {
      wrapperElement.addEventListener('change', function (event) {
        if (event.target && event.target.id === 'billing_delivery_methods') {
          const idMethods = event.target.value;                    
          
          if (idMethods === '') {
            messageCartShipping.innerHTML = '';
          }
        }
      });

    }


});
