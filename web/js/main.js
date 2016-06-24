/*
 
 *
 * Portions Copyrighted 2011 Sun Microsystems, Inc.
 */

$('#modalRechazo, #modalRechazoDel').on('show.bs.modal', function (event) {
  $(this).find("#numero").val($(event.relatedTarget).data('numero'))
  $(this).find("#descripcion").val($(event.relatedTarget).data('descripcion'))
  $(this).find("#depositaria").attr('checked', $(event.relatedTarget).data('depositaria'))
  $(this).find("#girada").attr('checked', $(event.relatedTarget).data('girada'))
})

$(document).ready(function() {
    initDatepicker();
    initFlashes();
    initErrorFields();
});

function initDatepicker() {
    $('.datepicker')
            .attr('write', 'readonly')
            .datepicker({
                dateFormat: 'd/m/yy'
            });
}

function initFlashes() {
    var flashes = $("#flashes");
    if (!flashes.length) {
        return;
    }
    setTimeout(function() {
        flashes.slideUp("slow");
    }, 3000);
}

function initErrorFields() {
    $('.error-field').first().focus();
}