const chboxSend = $('#chboxSend');
const btnSend = $('#btnSend');;
btnSend.attr('disabled', true);

chboxSend.on('change', function() {
    if (this.checked) {
       btnSend.attr('disabled', false);
    } else {
       btnSend.attr('disabled', true);
    }
});