import './bootstrap';
import Alpine from 'alpinejs'
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.Alpine = Alpine
Alpine.start()


document.addEventListener('DOMContentLoaded', function () {
    new TomSelect("#supplierid", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
});


