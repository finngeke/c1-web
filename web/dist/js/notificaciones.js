/**
 * Funcion de notificacion
 * ------------------
 */


document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

function notificacionNavegador(titulo, subtitulo) {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification(titulo, {
            icon: 'http://spp/images/company/logo.png',
            body: subtitulo,
        });

        /* notification.onclick = function () {
         window.open("link..");
         };*/

    }

}