$(document).ready(function () {
    // Ajout de l'option nulle dans le select
    $('#form_presentateurs').prepend($('<option>', {
        value: '',
        text: 'Sélectionnez des animateurs…',
        disabled: 'disabled'
    }));

    // Activer le select multiple
    $('select').material_select();

    // Design des checkboxes du select multiple
    $('input:checkbox').addClass('filled-in');

    // Affichage / Disparition des champs d'horaires
    var active = $('#form_active:checkbox');

    // Définition pour la valeur initiale
    if (active.prop('checked')) {
        $('#horaire').show();
    } else {
        $('#horaire').hide();
    }

    // Écouteur d'événement sur la case à cocher "Active"
    active.change(function () {
        if (this.checked) {
            $('#horaire').show(400);
        } else {
            $('#horaire').hide(400);
        }
    })
});
