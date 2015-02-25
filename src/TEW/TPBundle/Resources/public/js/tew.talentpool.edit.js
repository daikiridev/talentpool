// div containing the collection of addresses
var profileCollection = $('#talentpool_profiles');
profileCollection.after(addButton());

// initialize things
$(document).ready(function () {
    // catches a click on an "add" button #}
    $('.add_item_link').on('click', function (e) {
        e.preventDefault();
        collection = $(this).parent().prev('.form-collection');
        addItemForm(collection, length);
    });
    // adds a remove button to each item of each form collection
    $('.form-collection').children('div').each(function () {
        addItemFormDeleteLink($(this));
    });
});