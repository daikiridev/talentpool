// div containing the collection of addresses
var addressCollection = $('#candidate_addresses');
addressCollection.after(addButton());

// div containing the collection of mobilities
var mobilityCollection = $('#candidate_mobilities');
mobilityCollection.after(addButton());

// div containing the collection of comments
var commentCollectionDB = $('#candidate_comments');
var commentCollection = $('#candidate_comments_new');
commentCollection.after(addButton());



// Google places API
var autocomplete = new Array();

// Handle the way form inputs are filled in
function convertForm(addressPrefix, field) {
    switch(addressPrefix.replace((/candidate_([^_]*)_.*/), "$1")){
        case 'mobilities':
            return {
                locality: [{field: 'city', action: 'replace', format: 'short_name'}],
                administrative_area_level_1: [{field: 'region', action: 'replace', format: 'short_name'}],
                country: [{field: 'country', action: 'replace', format: 'short_name'}],
                continent: [{field: 'zone', action: 'replace', format: 'short_name'}]
            };
        default: // case 'addresses':
            return {
                street_number: [{field: field, action: 'replace', format: 'short_name'}], // the search input field is replaced by the street number
                route: [{field: field, action: 'add', format: 'long_name'}], // the route is added to the search input field
                locality: [{field: 'city', action: 'replace', format: 'long_name'}],
                postal_code: [{field: 'zip', action: 'replace', format: 'long_name'}],
                administrative_area_level_1: [{field: 'province', action: 'replace', format: 'long_name'}],
                country: [{field: 'country', action: 'replace', format: 'long_name'}]
            };
            
    }
}

function googleInit(addressPrefix, field) {
    // Create the autocomplete object
    // Types are availabe here: https://developers.google.com/places/documentation/supported_types
    var searchType;
    switch (addressPrefix.replace((/candidate_([^_]*)_.*/), "$1")) {
        case 'addresses':
            searchType = 'address';
            break;
        case 'mobilities':
            searchType = 'geocode';
            break;
        default:
            searchType = 'geocode';
    }
    autocomplete[addressPrefix] = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById(addressPrefix + field)),
            {types: [searchType]});
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete[addressPrefix], 'place_changed', function () {
        fillInAddress(addressPrefix, field);
    });
}

function fillInAddress(addressPrefix, field) {
    // Get the place details from the autocomplete object.
    var place = autocomplete[addressPrefix].getPlace();
    var convForm = convertForm(addressPrefix, field);

    // Reset all inputs
    for (var component in convForm) {
        //alert('comp: '+component); // addressPrefix.replace((/candidate_([^_]*)_.*/), "$1")
        var id = '#' + addressPrefix + convForm[component][0]['field'];
        $(id).val('');
        $(id).prop('disabled', false);
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        //alert(addressType+': '+place.address_components[i]['long_name']);
        if (convForm[addressType]) {
            var val = place.address_components[i][convForm[addressType][0]['format']]; // short_name or long_name
            var id = '#' + addressPrefix + convForm[addressType][0]['field'];
            if (convForm[addressType][0]['action'] === 'add') { // append the value to the field
                $(id).val($(id).val() + ' ' + val);
            } else { // put the value into the field
                $(id).val(val);
            }
            $(id).trigger('change'); // since some of the fields are hidden fields (which don't natively throw a change event)
        }
    }
}

// initialize things
$(document).ready(function () {
    // catches a click on an "add" button #}
    $('.add_item_link').on('click', function (e) {
        e.preventDefault();
        collection = $(this).parent().prev('.form-collection');
        //alert(collection.attr('id'));
        // if this is the comments collection, start numbering at the end index stored in DB
        length = collection.is("#candidate_comments_new") ? commentCollectionDB.children().length : collection.children().length;
        addItemForm(collection, length);
        // if this is an address form, initialise google place API
        if (collection.is('#candidate_addresses')) {
            googleInit('candidate_addresses_' + length + '_', 'street1'); // location search is done in the 'street1' field
        }
        if (collection.is('#candidate_mobilities')) {
            googleInit('candidate_mobilities_' + length + '_', 'location'); // location search is done in the 'location' field
        }
    });
    // adds a remove button to each item of each form collection
    $('.form-collection').children('div').each(function () {
        addItemFormDeleteLink($(this));
    });
    // adds a google field for each address
    for (i = 0; i < addressCollection.children().length; i++) {
        googleInit('candidate_addresses_' + i + '_', 'street1'); // location search is done in the 'street1' field
    }
    // adds a google field for each mobility
    for (i = 0; i < mobilityCollection.children().length; i++) {
        googleInit('candidate_mobilities_' + i + '_', 'location'); // location search is done in the 'location' field
    }
});