require('./bootstrap');

import Swal from 'sweetalert2';

window.showAlert = function (title, message, type) {
    Swal.fire({
        title: title,
        html: message,
        icon: type,
        confirmButtonText: 'OK'
    });
};
