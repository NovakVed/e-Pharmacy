$(document).ready(function () {
    $('#search').keyup(function () { //pretrazuje se na pritisak tipke
        search_table($(this).val().toLowerCase()); //funkcija koja prima ovu vrijednost dobivenu iz inputa
    });

    function search_table(value) {
        $('#myTable tr').filter(function () {
            $(this).each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    }
});