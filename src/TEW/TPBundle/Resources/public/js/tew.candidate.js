$('.tags-field').tagsInput({
    //'autocomplete_url': url_to_autocomplete_api,
    //'autocomplete': { option: value, option: value},
    'height': '30px',
    'width': '400px',
    //'interactive':true,
    //'defaultText':'add a tag',
    //'onAddTag':callback_function,
    //'onRemoveTag':callback_function,
    //'onChange' : callback_function,
    //'removeWithBackspace' : true,
    //'minChars' : 0,
    //'maxChars' : 0 //if not provided there is no limit,
    //'placeholderColor' : '#666666'

});
// « add » button
var addButton = function () {
    var $addItemLink = $('<a href="#" class="add_item_link btn-xs btn-warning">Add</a>');
    return $('<span></span>').append($addItemLink);
};

// adapted from http://symfony.com/doc/2.3/cookbook/form/form_collections.html
function addItemForm(collectionHolder, length) {
    var prototype = collectionHolder.attr('data-prototype');
    // Replaces '__name__' in the prototype HTML by the index of the current item
    var newItemForm = prototype.replace(/__name__/g, length);
    // Displays the item form in a <div>, just before the "add" button
    var $newItemFormDiv = $('<div></div>').append(newItemForm);
    collectionHolder.append($newItemFormDiv);
    // add a "remove" link at the end of the new form
    addItemFormDeleteLink($newItemFormDiv);
    // if this is an address form, initialise google place API
    if (collectionHolder.is('#candidate_addresses')) {
        addressGoogleInit('candidate_addresses_' + length + '_', 'street1'); // location search is done in the 'street1' field
    }

}

function addItemFormDeleteLink($itemFormLi) {
    var $removeFormA = $('<a href="#" class="btn-xs btn-danger">Remove</a>');
    $itemFormLi.append($removeFormA);
    $removeFormA.on('click', function (e) {
        e.preventDefault();
        if (confirm("Are you sure?")) {
            $itemFormLi.remove();
        }
    });
}

// div containing the collection of addresses
var addressCollection = $('#candidate_addresses');
addressCollection.after(addButton());
// div containing the collection of comments
var commentCollectionDB = $('#candidate_comments');
var commentCollection = $('#candidate_comments_new');
commentCollection.after(addButton());



// Google places API
var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name', // province
    //administrative_area_level_2:  'short_name', // department
    country: 'long_name',
    postal_code: 'short_name'
};
var convertForm = {
    street_number: [{field: 'street1', action: 'replace'}],
    route: [{field: 'street1', action: 'add'}],
    locality: [{field: 'city', action: 'replace'}],
    administrative_area_level_1: [{field: 'province', action: 'replace'}],
    country: [{field: 'country', action: 'replace'}],
    postal_code: [{field: 'zip', action: 'replace'}]
};

function addressGoogleInit(addressPrefix, field) {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById(addressPrefix + field)),
            {types: ['geocode']});
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress(addressPrefix);
    });
}

function fillInAddress(addressPrefix) {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in convertForm) {
        document.getElementById(addressPrefix + convertForm[component][0]['field']).value = '';
        document.getElementById(addressPrefix + convertForm[component][0]['field']).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        //alert(addressType+': '+place.address_components[i]['long_name']);
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            if (convertForm[addressType][0]['action'] == 'add') {
                document.getElementById(addressPrefix + convertForm[addressType][0]['field']).value += ' ' + val;
            } else {
                document.getElementById(addressPrefix + convertForm[addressType][0]['field']).value = val;
            }
        }
    }
}

$(document).ready(function () {
    // catches a click on an "add" button #}
    $('.add_item_link').on('click', function (e) {
        e.preventDefault();
        collection = $(this).parent().prev('.form-collection');
        //alert(collection.attr('id'));
        // if this is the comments collection, start numbering at the end index stored in DB
        length = collection.is("#candidate_comments_new") ? commentCollectionDB.children().length : collection.children().length;
        addItemForm(collection, length);
    });
    // adds a remove button to each item of each form collection
    $('.form-collection').children('div').each(function () {
        addItemFormDeleteLink($(this));
    });
    // adds a google field for each address
    for (i = 0; i < addressCollection.children().length; i++) {
        addressGoogleInit('candidate_addresses_' + i + '_', 'street1'); // location search is done in the 'street1' field
    }
});